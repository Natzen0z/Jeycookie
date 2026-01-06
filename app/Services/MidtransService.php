<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        $this->configure();
    }

    /**
     * Configure Midtrans SDK
     */
    private function configure(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
        // During local development (sandbox) some Windows setups lack a proper CA bundle
        // which causes cURL SSL verification errors. For convenience only, disable
        // peer verification in non-production. Do NOT enable in production.
        if (!Config::$isProduction) {
            // Ensure CURLOPT_HTTPHEADER exists to avoid undefined index warnings
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [],
            ];
        }
    }

    /**
     * Generate Snap Token for order
     */
    public function generateSnapToken(Order $order): ?string
    {
        try {
            $transactionDetails = [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ];

            $customerDetails = [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
                'billing_address' => [
                    'address' => $order->customer_address,
                ],
                'shipping_address' => [
                    'address' => $order->customer_address,
                ],
            ];

            $items = [];
            foreach ($order->items as $item) {
                $items[] = [
                    'id' => $item->product_id,
                    'price' => (int) $item->product_price,
                    'quantity' => $item->quantity,
                    'name' => $item->product_name,
                ];
            }

            // Add delivery fee as item if exists
            if ($order->delivery_fee > 0) {
                $items[] = [
                    'id' => 'delivery',
                    'price' => (int) $order->delivery_fee,
                    'quantity' => 1,
                    'name' => 'Biaya Pengiriman',
                ];
            }

            $payload = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $items,
            ];

            $snapToken = Snap::getSnapToken($payload);
            
            Log::info("Snap Token generated for order: {$order->order_number}");
            
            return $snapToken;
        } catch (\Exception $e) {
            Log::error("Failed to generate Snap Token: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    /**
     * Get transaction status from Midtrans
     */
    public function getTransactionStatus(string $orderId): ?array
    {
        try {
            $status = Transaction::status($orderId);
            return (array) $status;
        } catch (\Exception $e) {
            Log::error("Failed to get transaction status: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cancel transaction in Midtrans
     */
    public function cancelTransaction(string $orderId): bool
    {
        try {
            Transaction::cancel($orderId);
            Log::info("Transaction cancelled for order: {$orderId}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to cancel transaction: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Refund transaction in Midtrans
     */
    public function refundTransaction(string $orderId, ?float $amount = null): bool
    {
        try {
            if ($amount) {
                Transaction::refund($orderId, [
                    'refund_amount' => (int) $amount,
                ]);
            } else {
                Transaction::refund($orderId);
            }
            
            Log::info("Transaction refunded for order: {$orderId}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to refund transaction: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify notification signature
     */
    public function verifyNotification(array $data): bool
    {
        try {
            $serverKey = config('midtrans.server_key');
            $signature = $data['signature_key'] ?? '';
            
            $orderId = $data['order_id'] ?? '';
            $statusCode = $data['status_code'] ?? '';
            $grossAmount = $data['gross_amount'] ?? '';
            
            $calculatedSignature = hash(
                'sha512',
                $orderId . $statusCode . $grossAmount . $serverKey
            );
            
            return hash_equals($calculatedSignature, $signature);
        } catch (\Exception $e) {
            Log::error("Signature verification failed: " . $e->getMessage());
            return false;
        }
    }
}
