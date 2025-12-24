<!--
    Layout utama admin
    Semua halaman admin extend dari sini
-->

<h1>Admin Panel - Jeycookie</h1>

<nav>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> |
    <a href="{{ route('admin.products') }}">Produk</a> |
    <a href="{{ route('admin.transactions') }}">Transaksi</a>
</nav>

<hr>

<!--
    Section konten dinamis
-->
@yield('content')
