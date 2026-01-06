# 🧪 Testing Guide - Payment Gateway Midtrans

## Quick Start Testing

### 1. Persiapan Awal

#### Daftar Midtrans Sandbox
```
1. Buka https://dashboard.midtrans.com/register
2. Daftar dengan email Anda
3. Verify email
4. Login ke dashboard
```

#### Dapatkan API Keys
```
1. Login ke Midtrans Dashboard
2. Settings → Merchant Key
3. Copy 3 informasi berikut (Mode: Sandbox):
   - Merchant ID
   - Client Key
   - Server Key
```

#### Update .env
```env
MIDTRANS_MERCHANT_ID=G123456789012345678901234
MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxxxxxxx
MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

### 2. Test Scenario - Happy Path

#### Step 1: User Registration
```
URL: http://localhost:8000/register
- Nama: John Doe
- Email: john@example.com
- Password: password123
```

#### Step 2: Browse Products
```
URL: http://localhost:8000/products
- Pilih beberapa produk
- Click "Tambah ke Keranjang"
```

#### Step 3: View Cart
```
URL: http://localhost:8000/cart
- Verifikasi produk dan total
- Click "Checkout"
```

#### Step 4: Checkout Form
```
URL: http://localhost:8000/checkout
- Nama Lengkap: John Doe
- No. Telepon: 081234567890
- Email: john@example.com
- Alamat: Jl. Test No. 123, Jakarta
- Notes: (optional)
- Click "Buat Pesanan"
```

#### Step 5: Payment Page (Expected Output)
```
Expected Results:
✅ Halaman payment muncul
✅ Order number terlihat (JCxxxxxx)
✅ Total pembayaran ditampilkan
✅ Tombol "Proses Pembayaran" available
✅ Detail pesanan di sebelah kanan
```

#### Step 6: Payment via Midtrans Snap
```
URL: http://localhost:8000/checkout/payment/{order_id}

Expected Flow:
1. Click "Proses Pembayaran"
2. Midtrans modal muncul
3. Pilih metode pembayaran
4. Selesaikan payment

Test Card (Sandbox):
- Card: 4811 1111 1111 1114
- Exp: 12/25
- CVV: 123
```

#### Step 7: Verify Payment Success
```
Expected Results:
✅ Modal closed
✅ Redirected to order detail page
✅ Payment status: PAID
✅ Order status: PAID
✅ Email confirmation diterima
```

### 3. Test Scenario - Error Cases

#### Error Case 1: Insufficient Stock
```
1. Pergi ke Products
2. Coba checkout dengan quantity > stock
3. Expected: Error message "Stok tidak mencukupi"
```

#### Error Case 2: Invalid Email
```
1. Checkout form
2. Input email tidak valid (e.g., "notanemail")
3. Expected: Validation error "Format email tidak valid"
```

#### Error Case 3: Empty Cart
```
1. Clear cart
2. Try akses /checkout
3. Expected: Redirect ke cart dengan warning
```

#### Error Case 4: Payment Declined (Test Card)
```
Card: 4911 1111 1111 1113 (Decline)
Expected: Payment failed message
```

### 4. Test Scenario - Payment States

#### Test Payment Pending
```
- Payment status: pending
- Order status: pending
- Expected: Customer bisa retry pembayaran
```

#### Test Payment Refund
```
Admin Panel:
1. Go to Orders
2. Select order
3. Change status to "Cancelled"
4. Stock auto-restored
```

#### Test Payment Cancel
```
1. Payment belum completed
2. Close modal
3. Click back
4. Expected: Order tetap bisa di-retry
```

### 5. Database Verification

#### Check Order Record
```sql
SELECT * FROM orders WHERE order_number = 'JCxxxxxxxx';
```

Expected columns:
```
- snap_token: [filled if payment initiated]
- payment_status: 'paid' / 'unpaid' / 'pending'
- payment_reference: [midtrans transaction id]
- paid_at: [timestamp if paid]
- status: 'paid' / 'pending'
```

#### Check Order Items
```sql
SELECT * FROM order_items WHERE order_id = [order_id];
```

Expected:
- Semua item checkout tercatat
- Stock sudah dikurangi dari products table

### 6. Logs Verification

#### Check Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

Expected entries:
```
[timestamp] local.INFO: Snap Token generated for order: JCxxxxxxxx
[timestamp] local.INFO: Midtrans Notification - Order: JCxxxxxxxx, Status: settlement
[timestamp] local.INFO: Order JCxxxxxxxx marked as paid
```

### 7. Admin Panel Testing

#### Orders Management
```
URL: http://localhost:8000/admin/orders

Verify:
✅ Order list menampilkan semua orders
✅ Search by order number works
✅ Filter by status works
✅ Filter by payment status works
✅ Click order detail menampilkan info lengkap
```

#### Update Order Status
```
1. Select order
2. Change status (pending → processing → shipped, etc.)
3. Expected: Status updated successfully
```

### 8. Email Testing

#### Verify Email Sent
```
Check dengan:
1. Mailtrap (jika setup)
2. Terminal (jika using test driver)
3. Gmail (jika setup real SMTP)

Expected Email:
- To: customer_email
- Subject: Order Confirmation - [Order Number]
- Body: Order details, tracking link
```

### 9. Performance Testing

#### Load Test Payment Page
```bash
# Jika perlu load testing
ab -n 100 -c 10 http://localhost:8000/checkout/payment/JCxxxxxxxx
```

Expected:
- Response time < 200ms
- No SQL errors
- Token valid

### 10. Security Testing

#### Test Authorization
```
1. Login as User A
2. Try akses /checkout/payment/{User B Order}
3. Expected: 403 Forbidden error
```

#### Test CSRF Protection
```
1. Try POST /payment/notification tanpa CSRF token
2. Expected: 419 Token Mismatch error
```

#### Test Webhook Verification
```
1. Send webhook dengan invalid signature
2. Expected: 400 Bad Request
```

## Troubleshooting Common Issues

### Issue 1: Snap Modal Tidak Muncul
```
Debug:
1. Check console (F12 → Console)
2. Verify snap_token not null in Order
3. Verify Midtrans keys correct in .env
4. Check network tab untuk JS loading
```

### Issue 2: "Gagal membuat token pembayaran"
```
Solution:
1. Verify MIDTRANS_SERVER_KEY di .env
2. Check Laravel logs
3. Test server key valid di Midtrans Dashboard
```

### Issue 3: Webhook Tidak Diterima
```
Solution:
1. Verify webhook URL di Midtrans Dashboard
2. Ensure public URL (tidak localhost)
3. Check logs untuk notification received
4. Verify signature calculation correct
```

### Issue 4: Payment Status Tidak Update
```
Debug:
1. Check database order record
2. Verify payment_status column exist
3. Check Laravel logs untuk notification
4. Manually test notification endpoint
```

## Test Coverage Checklist

- [ ] User bisa register & login
- [ ] Produk bisa ditambah ke cart
- [ ] Cart bisa dilihat & diupdate
- [ ] Checkout form bisa diisi
- [ ] Order berhasil dibuat
- [ ] Snap token berhasil di-generate
- [ ] Payment modal muncul
- [ ] Payment berhasil diproses
- [ ] Order status updated ke PAID
- [ ] Email confirmation dikirim
- [ ] Stock dikurangi sesuai order
- [ ] Admin bisa lihat orders
- [ ] Admin bisa update order status
- [ ] Error handling berfungsi
- [ ] Logs terekam dengan baik

## Automation Testing (Optional)

### Using Laravel Testing
```bash
# Run existing tests
php artisan test

# Run specific test
php artisan test tests/Feature/CheckoutTest.php

# Run with coverage
php artisan test --coverage
```

### Example Test Case
```php
// tests/Feature/CheckoutTest.php
public function test_successful_payment() {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/checkout/process', [
            'customer_name' => 'John Doe',
            // ... other data
        ]);
    
    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'status' => 'pending',
    ]);
}
```

---

## Quick Reference

### URLs
- Register: `http://localhost:8000/register`
- Products: `http://localhost:8000/products`
- Cart: `http://localhost:8000/cart`
- Checkout: `http://localhost:8000/checkout`
- Orders: `http://localhost:8000/orders`
- Admin: `http://localhost:8000/admin`
- Webhook: `http://localhost:8000/payment/notification`

### Test Cards (Sandbox)
- Success: `4811 1111 1111 1114`
- Decline: `4911 1111 1111 1113`
- Exp: `12/25`, CVV: `123`

### Commands
```bash
# Start server
php artisan serve

# Check logs
tail -f storage/logs/laravel.log

# Migrate database
php artisan migrate

# Seed database
php artisan db:seed
```

---

**Happy Testing! 🚀**
