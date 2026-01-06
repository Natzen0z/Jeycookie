<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmationMail;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('warning', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $cartItems = $this->getCartItems($cart);
        $totals = $this->calculateTotals($cartItems);

        // Check if all items are in stock
        $outOfStock = $cartItems->filter(fn($item) => !$item['in_stock']);
        if ($outOfStock->isNotEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Beberapa produk di keranjang tidak tersedia. Silakan perbarui keranjang Anda.');
        }

        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'totals', 'user'));
    }

    /**
     * Direct buy now - add product to cart and redirect to checkout (guest or logged in).
     */
    public function buyNow(Product $product)
    {
        if (!$product->is_active || $product->stock <= 0) {
            return back()->with('error', 'Produk tidak tersedia untuk dibeli.');
        }

        // Add to cart
        $cart = session('cart', []);
        $productId = (string) $product->id;
        $quantity = 1;

        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok produk tidak mencukupi untuk jumlah yang diminta.');
            }
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }

        session(['cart' => $cart]);

        // If not authenticated, redirect to guest checkout
        if (!Auth::check()) {
            return redirect()->route('checkout.guest');
        }

        // If authenticated, redirect to normal checkout
        return redirect()->route('checkout.index');
    }

    /**
     * Display guest checkout page (no login required).
     */
    public function guestCheckout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('warning', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $cartItems = $this->getCartItems($cart);
        $totals = $this->calculateTotals($cartItems);

        // Check if all items are in stock
        $outOfStock = $cartItems->filter(fn($item) => !$item['in_stock']);
        if ($outOfStock->isNotEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Beberapa produk di keranjang tidak tersedia. Silakan perbarui keranjang Anda.');
        }

        return view('checkout.guest', compact('cartItems', 'totals'));
    }

    /**
     * Process guest checkout - create order without authentication.
     */
    public function processGuest(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_phone.required' => 'Nomor telepon wajib diisi.',
            'customer_email.required' => 'Email wajib diisi untuk konfirmasi pesanan.',
            'customer_email.email' => 'Format email tidak valid.',
            'customer_address.required' => 'Alamat pengiriman wajib diisi.',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        $cartItems = $this->getCartItems($cart);
        $totals = $this->calculateTotals($cartItems);

        // Check stock availability again
        foreach ($cartItems as $item) {
            if (!$item['in_stock']) {
                return redirect()->route('cart.index')
                    ->with('error', "Produk {$item['name']} tidak tersedia dalam jumlah yang diminta.");
            }
        }

        try {
            DB::beginTransaction();

            // Create order as guest (user_id = null)
            $order = Order::create([
                'user_id' => null, // Guest order
                'status' => Order::STATUS_PENDING,
                'subtotal' => $totals['subtotal'],
                'delivery_fee' => $totals['delivery_fee'],
                'discount' => $totals['discount'],
                'total' => $totals['total'],
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'payment_method' => 'qris',
                'payment_status' => Order::PAYMENT_UNPAID,
                'notes' => $request->notes,
            ]);

            // Create order items and decrease stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Decrease product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decreaseStock($item['quantity']);
                }
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            // Redirect to payment page
            return redirect()->route('checkout.payment', $order)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Guest checkout failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Process the checkout and create order.
     */
    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_phone.required' => 'Nomor telepon wajib diisi.',
            'customer_email.required' => 'Email wajib diisi untuk konfirmasi pesanan.',
            'customer_email.email' => 'Format email tidak valid.',
            'customer_address.required' => 'Alamat pengiriman wajib diisi.',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        $cartItems = $this->getCartItems($cart);
        $totals = $this->calculateTotals($cartItems);

        // Check stock availability again
        foreach ($cartItems as $item) {
            if (!$item['in_stock']) {
                return redirect()->route('cart.index')
                    ->with('error', "Produk {$item['name']} tidak tersedia dalam jumlah yang diminta.");
            }
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => Order::STATUS_PENDING,
                'subtotal' => $totals['subtotal'],
                'delivery_fee' => $totals['delivery_fee'],
                'discount' => $totals['discount'],
                'total' => $totals['total'],
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email ?? Auth::user()->email,
                'customer_address' => $request->customer_address,
                'payment_method' => 'qris',
                'payment_status' => Order::PAYMENT_UNPAID,
                'notes' => $request->notes,
            ]);

            // Create order items and decrease stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Decrease product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decreaseStock($item['quantity']);
                }
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            // Redirect to payment page
            return redirect()->route('checkout.payment', $order)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Display the payment page with Midtrans Snap.
     */
    public function payment(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // If already paid, redirect to order detail
        if ($order->isPaid()) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pesanan ini sudah dibayar.');
        }

        $order->load('items');

        // Generate Midtrans Snap Token
        try {
            if (!$order->snap_token) {
                $midtransService = new MidtransService();
                $snapToken = $midtransService->generateSnapToken($order);
                
                if ($snapToken) {
                    $order->update(['snap_token' => $snapToken]);
                } else {
                    return back()->with('error', 'Gagal membuat token pembayaran. Silakan coba lagi.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat token pembayaran. Silakan coba lagi.');
        }

        return view('checkout.payment', compact('order'));
    }

    /**
     * Handle Midtrans payment notification (webhook).
     */
    public function notification(Request $request)
    {
        $midtransService = new MidtransService();

        try {
            // Get notification object
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Invalid notification'], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $fraudStatus = $notif->fraud_status ?? null;
        $orderId = $notif->order_id;
        $paymentType = $notif->payment_type;

        Log::info("Midtrans Notification - Order: {$orderId}, Status: {$transactionStatus}, Payment: {$paymentType}");

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning("Order not found: {$orderId}");
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        // Update based on transaction status
        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            if ($fraudStatus === null || $fraudStatus === 'accept') {
                $order->markAsPaid($notif->transaction_id ?? $notif->bank_transfer_id ?? 'PAID');
                
                // Send confirmation email
                try {
                    Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
                } catch (\Exception $e) {
                    Log::error('Email send failed: ' . $e->getMessage());
                }
                
                Log::info("Order {$orderId} marked as paid");
            }
        } elseif ($transactionStatus === 'pending') {
            $order->update(['payment_status' => Order::PAYMENT_PENDING]);
            Log::info("Order {$orderId} payment pending");
        } elseif ($transactionStatus === 'cancel' || $transactionStatus === 'deny' || $transactionStatus === 'expire') {
            $order->update(['payment_status' => Order::PAYMENT_FAILED]);
            Log::info("Order {$orderId} payment failed");
        } elseif ($transactionStatus === 'refund') {
            $order->update(['payment_status' => Order::PAYMENT_REFUNDED]);
            Log::info("Order {$orderId} refunded");
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Confirm payment manually (for demo purposes).
     */
    public function confirmPayment(Request $request, Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->isPaid()) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Pesanan sudah dibayar sebelumnya.');
        }

        // In real implementation, this would verify with Midtrans API
        // For now, we'll just mark as paid (for demo)
        $order->markAsPaid('MANUAL-' . time());

        // Send order confirmation email
        try {
            Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Email konfirmasi telah dikirim ke ' . $order->customer_email);
    }

    /**
     * Guest quick buy - create order directly from product page and generate snap token.
     * Returns JSON with snap token for AJAX.
     */
    public function quickBuy(Request $request, Product $product)
    {
        // Validate request
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string|max:1000',
            'quantity' => 'required|integer|min:1',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_phone.required' => 'Nomor telepon wajib diisi.',
            'customer_email.required' => 'Email wajib diisi.',
            'customer_email.email' => 'Format email tidak valid.',
            'customer_address.required' => 'Alamat wajib diisi.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.min' => 'Jumlah minimal 1.',
        ]);

        // Check product availability
        if (!$product->is_active || $product->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak tersedia untuk dibeli.'
            ], 400);
        }

        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => "Stok produk tidak mencukupi. Stok tersedia: {$product->stock}"
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Calculate order totals
            $subtotal = $product->price * $validated['quantity'];
            $deliveryFee = $subtotal > 0 ? 15000 : 0;
            if ($subtotal >= 100000) {
                $deliveryFee = 0;
            }
            $total = $subtotal + $deliveryFee;

            // Create order as guest
            $order = Order::create([
                'user_id' => null,
                'order_number' => 'ORD-' . date('YmdHis') . '-' . rand(1000, 9999),
                'status' => Order::STATUS_PENDING,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'discount' => 0,
                'total' => $total,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'customer_address' => $validated['customer_address'],
                'payment_method' => 'qris',
                'payment_status' => Order::PAYMENT_UNPAID,
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => $validated['quantity'],
                'subtotal' => $subtotal,
            ]);

            // Decrease product stock
            $product->decreaseStock($validated['quantity']);

            // Generate Midtrans Snap Token
            $midtransService = new MidtransService();
            $snapToken = $midtransService->generateSnapToken($order);

            if (!$snapToken) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat token pembayaran. Silakan coba lagi.'
                ], 500);
            }

            // Update order with snap token
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'message' => 'Pesanan berhasil dibuat. Silakan selesaikan pembayaran.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Guest quick buy failed: ' . $e->getMessage(), ['exception' => $e]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart items with current product data.
     */
    private function getCartItems(array $cart)
    {
        if (empty($cart)) {
            return collect([]);
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        return collect($cart)->map(function ($item, $productId) use ($products) {
            $product = $products->get($productId);
            
            return [
                'product_id' => $productId,
                'product' => $product,
                'name' => $product ? $product->name : $item['name'],
                'price' => $product ? $product->price : $item['price'],
                'image' => $product ? $product->image : $item['image'],
                'quantity' => $item['quantity'],
                'subtotal' => ($product ? $product->price : $item['price']) * $item['quantity'],
                'in_stock' => $product && $product->is_active && $product->stock >= $item['quantity'],
            ];
        });
    }

    /**
     * Calculate cart totals.
     */
    private function calculateTotals($cartItems): array
    {
        $subtotal = $cartItems->sum('subtotal');
        $deliveryFee = $subtotal > 0 ? 15000 : 0;
        $discount = 0;

        if ($subtotal >= 100000) {
            $deliveryFee = 0;
        }

        $total = $subtotal + $deliveryFee - $discount;

        return [
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'discount' => $discount,
            'total' => $total,
            'item_count' => $cartItems->sum('quantity'),
        ];
    }
}
