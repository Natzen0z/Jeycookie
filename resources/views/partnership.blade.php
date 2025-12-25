@extends('layouts.app')

@section('content')

<div class="container py-5">

    <!-- Title -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">Partnership Program</h1>
        <p class="text-muted">
            Kami membuka peluang kerja sama untuk reseller, event organizer, coffee shop,
            hingga perusahaan yang membutuhkan snack dalam jumlah besar.
        </p>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <h4 class="mb-4 fw-semibold">Apply Partnership</h4>

            <form action="{{ route('partnership.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <!-- Nama -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                    </div>

                    <!-- Perusahaan -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Perusahaan / Toko</label>
                        <input type="text" name="perusahaan" class="form-control" placeholder="Nama perusahaan/toko" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Deskripsi Kebutuhan</label>
                        <textarea name="deskripsi"
                            rows="3"
                            class="form-control"
                            placeholder="Jelaskan kebutuhan Anda..."
                            required></textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="col-md-12 text-end">
                        <button class="btn btn-pink px-4 py-2 rounded-pill" style="background:#ff5b93; color:white;">
                            Submit
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection