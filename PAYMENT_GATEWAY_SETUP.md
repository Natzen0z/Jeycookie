# Setup Midtrans Payment Gateway

## Dokumentasi Integrasi Payment Gateway Midtrans untuk Jeycookie

### 📋 Persyaratan

1. Akun Midtrans (sandbox untuk development)
2. Merchant ID, Client Key, dan Server Key dari Midtrans Dashboard
3. Composer package `midtrans/midtrans-php` (sudah terinstall)

### 🔧 Setup Konfigurasi

#### 1. Environment Variables
Tambahkan ke file `.env`:

```env
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false  # Set true untuk production
```

#### 2. Konfigurasi File
File konfigurasi: `config/midtrans.php` sudah tersedia dengan setting:
- `merchant_id` - dari env
- `client_key` - dari env
- `server_key` - dari env
- `is_production` - default false untuk sandbox

### 🏗️ Struktur Implementasi

#### Database
Order model sudah memiliki field:
- `snap_token` - menyimpan token Snap dari Midtrans
- `payment_reference` - referensi pembayaran
- `paid_at` - timestamp pembayaran

#### Service Class
File: `app/Services/MidtransService.php`

Methods yang tersedia:
- `generateSnapToken(Order $order)` - Generate token untuk payment
- `getTransactionStatus(string $orderId)` - Cek status transaksi
- `cancelTransaction(string $orderId)` - Cancel transaksi
- `refundTransaction(string $orderId, ?float $amount)` - Refund transaksi
- `verifyNotification(array $data)` - Verifikasi webhook signature

#### Controller
File: `app/Http/Controllers/CheckoutController.php`

Methods:
1. **index()** - Tampilkan halaman checkout
2. **process()** - Process order dan kurangi stock
3. **payment()** - Generate snap token dan tampilkan payment page
4. **confirmPayment()** - Confirm pembayaran manual (fallback)
5. **notification()** - Handle webhook dari Midtrans

#### Routes
```php
// Payment routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/confirm/{order}', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm');

// Webhook
Route::post('/payment/notification', [CheckoutController::class, 'notification'])->name('payment.notification');
```

#### View
File: `resources/views/checkout/payment.blade.php`

Features:
- Midtrans Snap integration
- Payment methods display (E-Wallet, Transfer Bank)
- Order details
- Real-time payment button

### 🔄 Payment Flow

1. **Customer melakukan checkout**
   - Mengisi form checkout (nama, alamat, phone, email)
   - System membuat Order dengan status PENDING
   - Stock produk dikurangi

2. **Redirect ke Payment Page**
   - System generate Snap Token dari Midtrans
   - Display halaman pembayaran dengan Midtrans Snap

3. **Customer melakukan pembayaran**
   - Click tombol "Proses Pembayaran"
   - Diarahkan ke Midtrans Snap modal
   - Pilih metode pembayaran (GoPay, OVO, Dana, Transfer Bank, dll)

4. **Verifikasi Pembayaran**
   - Midtrans mengirim webhook notification
   - System update payment status menjadi PAID
   - Kirim email konfirmasi order

### 📧 Email Notification

File: `app/Mail/OrderConfirmationMail.php`

Email dikirim otomatis saat:
- Pembayaran berhasil (via webhook)
- Customer click "Saya Sudah Bayar" button

### 🔐 Security

1. **Signature Verification**
   - Webhook dari Midtrans di-verify menggunakan server key
   - Method `verifyNotification()` di MidtransService

2. **Authorization Check**
   - User hanya bisa akses order miliknya sendiri
   - Admin bisa manage semua order

3. **Data Validation**
   - Validasi semua input di controller
   - Error handling comprehensive

### 📊 Payment Status Tracking

Status dalam database:
- `unpaid` - Belum bayar
- `pending` - Sedang diproses
- `paid` - Sudah dibayar
- `failed` - Pembayaran gagal
- `refunded` - Refund

### 🧪 Testing

#### Sandbox
Gunakan credential sandbox dari Midtrans dashboard:
- Set `MIDTRANS_IS_PRODUCTION=false` di .env

#### Test Credit Card
Midtrans provide test card numbers untuk sandbox testing

#### Webhook Testing
Use Midtrans Dashboard atau tools seperti Webhook.site untuk test webhook

### 🚀 Production Deployment

Sebelum go live:
1. Daftarkan webhook URL di Midtrans Dashboard
2. Set `MIDTRANS_IS_PRODUCTION=true` di .env
3. Gunakan production server key dan client key
4. Setup HTTPS (Midtrans require SSL untuk production)
5. Test full payment flow
6. Monitor logs di `storage/logs/`

### 📝 Logs
Semua aktivitas Midtrans di-log di:
- `storage/logs/laravel.log`

Check logs untuk:
- Token generation
- Webhook notifications
- Payment status updates
- Error messages

### 🆘 Troubleshooting

**Token tidak bisa di-generate:**
- Verify Midtrans credentials di .env
- Check server key dan client key benar

**Webhook tidak diterima:**
- Ensure webhook URL registered di Midtrans Dashboard
- Check HTTPS for production
- Monitor logs untuk error messages

**Payment gagal:**
- Check order amount dan currency
- Verify payment method available di region

### 📚 Referensi

- [Midtrans Documentation](https://docs.midtrans.com)
- [Midtrans API Reference](https://api-docs.midtrans.com)
- [Laravel Midtrans Package](https://github.com/Midtrans/midtrans-php)
