@extends('layouts.app')

@section('title', 'Pembayaran - ' . $order->order_number)

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="text-center mb-4">
            <div class="mb-3" style="font-size: 4rem;">✅</div>
            <h2 class="fw-bold">Pesanan Berhasil Dibuat!</h2>
            <p class="text-muted">Silakan lakukan pembayaran untuk memproses pesanan Anda</p>
        </div>

        <div class="row g-4">
            <!-- Payment with Midtrans Snap -->
            <div class="col-md-6">
                <div class="payment-container">
                    <div id="snap-container" class="mb-4"></div>
                    
                    <div class="amount-display p-3 bg-pink-50 rounded-3 mb-3">
                        <small class="text-muted">Total Pembayaran</small>
                        <h3 class="fw-bold text-pink mb-0">{{ $order->formatted_total }}</h3>
                    </div>
                    
                    <!-- Dummy Payment for Local Testing -->
                    <div class="alert alert-warning small mb-3">
                        <i class="fa-solid fa-flask me-1"></i>
                        <strong>Mode Demo:</strong> Gunakan tombol di bawah untuk simulasi pembayaran
                    </div>
                    
                    <form action="{{ route('checkout.confirm', $order) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fa-solid fa-check-circle me-2"></i> Simulasi Pembayaran Berhasil
                        </button>
                    </form>
                    
                    <hr class="my-3">
                    
                    <div class="alert alert-info small">
                        <i class="fa-solid fa-info-circle me-1"></i>
                        Atau gunakan Midtrans untuk pembayaran asli
                    </div>
                    
                    @if($order->snap_token)
                        <button id="pay-button" class="btn btn-pink btn-lg w-100">
                            <i class="fa-solid fa-credit-card me-2"></i> Bayar via Midtrans
                        </button>
                    @else
                        <button id="pay-button" class="btn btn-pink btn-lg w-100" disabled>
                            <i class="fa-solid fa-credit-card me-2"></i> Midtrans (Token tidak tersedia)
                        </button>
                    @endif
                </div>
            </div>

            <!-- Order Details -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa-solid fa-receipt me-2"></i> Detail Pesanan
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted">No. Pesanan</td>
                                <td class="text-end fw-semibold">{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal</td>
                                <td class="text-end">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td class="text-end">
                                    <span class="badge {{ $order->status_badge_class }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pembayaran</td>
                                <td class="text-end">
                                    <span class="badge {{ $order->payment_badge_class }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                        
                        <hr>
                        
                        <h6 class="fw-semibold mb-2">Item Pesanan</h6>
                        @foreach($order->items as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>
                                    {{ $item->product_name }}
                                    <small class="text-muted">x{{ $item->quantity }}</small>
                                </span>
                                <span>{{ $item->formatted_subtotal }}</span>
                            </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Subtotal</span>
                            <span>{{ $order->formatted_subtotal }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Ongkir</span>
                            <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-pink">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="card mt-3">
                    <div class="card-header">
                        <i class="fa-solid fa-truck me-2"></i> Alamat Pengiriman
                    </div>
                    <div class="card-body">
                        <p class="fw-semibold mb-1">{{ $order->customer_name }}</p>
                        <p class="text-muted mb-1">{{ $order->customer_phone }}</p>
                        <p class="text-muted mb-0">{{ $order->customer_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods Info -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fa-solid fa-wallet me-2"></i> Metode Pembayaran yang Tersedia
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="payment-method">
                            <h6 class="fw-semibold mb-2">
                                <i class="fa-solid fa-mobile me-2"></i> E-Wallet
                            </h6>
                            <ul class="mb-0 text-muted small">
                                <li>GoPay</li>
                                <li>OVO</li>
                                <li>Dana</li>
                                <li>ShopeePay</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-method">
                            <h6 class="fw-semibold mb-2">
                                <i class="fa-solid fa-building me-2"></i> Transfer Bank
                            </h6>
                            <ul class="mb-0 text-muted small">
                                <li>BCA Transfer</li>
                                <li>BNI Transfer</li>
                                <li>Mandiri Transfer</li>
                                <li>Permata Transfer</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-pink">
                <i class="fa-solid fa-box me-2"></i> Lihat Pesanan Saya
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .text-pink {
        color: var(--pink-600);
    }
    
    .bg-pink-50 {
        background: var(--pink-50);
    }
    
    .payment-method {
        padding: 1rem;
        background: #f9f9f9;
        border-radius: var(--radius-lg);
    }
</style>
@endpush

@push('scripts')
<!-- Midtrans Snap Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        const snapToken = '{{ $order->snap_token ?? "" }}';
        
        if (payButton && snapToken) {
            payButton.addEventListener('click', function() {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        // Redirect to order detail page or success page
                        window.location.href = '{{ route("orders.show", $order) }}';
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        alert('Pembayaran sedang diproses. Silakan tunggu...');
                    },
                    onError: function(result) {
                        console.error('Payment error:', result);
                        alert('Pembayaran gagal. Silakan coba lagi.');
                    },
                    onClose: function() {
                        console.log('Payment dialog closed');
                    }
                });
            });
        }
    });
</script>
