@extends('layouts.app')

@section('title', 'Checkout - Guest')

@section('content')

<h1 class="fw-bold text-gradient mb-4">
    <i class="fa-solid fa-credit-card me-2"></i> Checkout
</h1>

<form action="{{ route('checkout.guest.process') }}" method="POST">
    @csrf
    
    <div class="row g-4">
        <!-- Customer Details Form -->
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-user me-2"></i> Informasi Pengiriman
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('customer_name') is-invalid @enderror" 
                                   id="customer_name" 
                                   name="customer_name" 
                                   value="{{ old('customer_name') }}"
                                   placeholder="Nama lengkap Anda"
                                   required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control @error('customer_phone') is-invalid @enderror" 
                                   id="customer_phone" 
                                   name="customer_phone" 
                                   value="{{ old('customer_phone') }}"
                                   placeholder="08xxxxxxxxxx"
                                   required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('customer_email') is-invalid @enderror" 
                                   id="customer_email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email') }}"
                                   placeholder="email@contoh.com"
                                   required>
                            <small class="text-muted">Email untuk menerima konfirmasi pesanan dan status pembayaran</small>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="customer_address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                      id="customer_address" 
                                      name="customer_address" 
                                      rows="3"
                                      placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos"
                                      required>{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="notes" class="form-label">Catatan (opsional)</label>
                            <textarea class="form-control" 
                                      id="notes" 
                                      name="notes" 
                                      rows="2"
                                      placeholder="Catatan khusus untuk pesanan Anda (misal: alamat rumah dekat masjid)">{{ old('notes') }}</textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="alert alert-info" role="alert">
                                <i class="fa-solid fa-circle-info me-2"></i>
                                <strong>Tips:</strong> Jika sudah memiliki akun, silakan <a href="{{ route('login') }}" class="alert-link">login</a> terlebih dahulu untuk pengalaman belanja yang lebih baik.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-box me-2"></i> Detail Pesanan
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        @endif
                                        <div>
                                            <strong>{{ $item['name'] }}</strong>
                                            @if(!$item['in_stock'])
                                                <br><span class="badge bg-danger">Stok Habis</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item['quantity'] }}</td>
                                <td class="text-end">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="text-end"><strong>Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-5">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header">
                    <i class="fa-solid fa-receipt me-2"></i> Ringkasan Pesanan
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>Rp{{ number_format($totals['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkir:</span>
                            <span>Rp{{ number_format($totals['delivery_fee'], 0, ',', '.') }}</span>
                        </div>
                        @if($totals['discount'] > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span>Diskon:</span>
                            <span class="text-success">-Rp{{ number_format($totals['discount'], 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total:</strong>
                        <strong class="fs-5 text-danger">Rp{{ number_format($totals['total'], 0, ',', '.') }}</strong>
                    </div>

                    <button type="submit" class="btn btn-pink btn-lg w-100 mb-2">
                        <i class="fa-solid fa-credit-card me-2"></i> Lanjut ke Pembayaran
                    </button>

                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="fa-solid fa-arrow-left me-2"></i> Lanjut Belanja
                    </a>
                </div>

                <!-- Order Summary Items Preview -->
                <div class="card-footer bg-light">
                    <small class="text-muted d-block mb-2"><strong>Anda akan membeli:</strong></small>
                    @foreach($cartItems as $item)
                    <small class="d-block">
                        {{ $item['quantity'] }}x {{ $item['name'] }}
                        <br>
                        <span class="text-muted">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                    </small>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
