@extends('layouts.app')

@section('content')

<!-- Hero -->
<div class="text-center p-5 bg-light rounded">
    <h1 class="fw-bold">Jeycookie 🍪</h1>
    <p class="text-muted">Fresh homemade cookies for your sweet moment</p>
</div>

<!-- Kategori -->
<h3 class="mt-5 mb-3">Kategori</h3>

<div class="row">
    @foreach ($categories as $category)
        <div class="col-md-4">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $category }}</h5>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
