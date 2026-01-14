# Software Requirements Specification

## Toko Roti JIYA (Jeycookie)

**Version 2.1**

**Prepared by:**
- 2310130009 - Muhammad Irfan Janur Ghifari
- 2310130007 - Muhammad Kaisar Hudayef
- 2310130011 - Tafkir Muhtadi

**Date: 14 January 2026**

---

## Revision History

| Name | Date | Reason For Changes | Version |
|------|------|-------------------|---------|
| Irfan | 03 December 2025 | Penyesuaian kebutuhan sistem | 1.0 |
| Irfan | 13 January 2025 | Update perubahan dan requirement dari owner | 2.0 |
| Tim | 14 January 2026 | Penambahan CI/CD, Midtrans, Email Automation | 2.1 |

---

## Table of Contents

1. [Pendahuluan](#1-pendahuluan)
2. [Deskripsi Keseluruhan](#2-deskripsi-keseluruhan)
3. [Kebutuhan Antarmuka Eksternal](#3-kebutuhan-antarmuka-eksternal)
4. [Functional Requirements](#4-functional-requirements)
5. [Non-Functional Requirements](#5-non-functional-requirements)
6. [CI/CD Requirements](#6-cicd-requirements)

---

## 1. Pendahuluan

### 1.1 Tujuan Penulisan Dokumen

Dokumen ini disusun untuk menjelaskan kebutuhan sistem aplikasi web Toko Roti JIYA, yang dibangun menggunakan Laravel dengan basis data SQL, dan di-deploy menggunakan layanan hosting Railway/Vercel. Dokumen ini menjadi acuan utama bagi developer, admin, pemilik toko, serta pihak-pihak terkait dalam proses pengembangan.

### 1.2 Audien yang Dituju dan Pembaca yang Disarankan

Dokumen ini ditujukan untuk:
- Developer: Sebagai pedoman implementasi sistem
- Admin Toko: Memahami alur pengelolaan produk dan pesanan
- Pemilik Toko: Memahami ruang lingkup sistem dan proses bisnis
- Dosen/Penguji: Sebagai bahan evaluasi Project

### 1.3 Batasan Produk

Sistem tidak mencakup:
- Sistem delivery otomatis (pengiriman dilakukan manual oleh pihak toko)
- Integrasi WhatsApp API

**Catatan:** Email automation sudah diimplementasikan menggunakan OrderConfirmationMail.php untuk mengirim konfirmasi pesanan ke pelanggan.

### 1.4 Definisi dan Istilah

| No | Istilah | Definisi |
|----|---------|----------|
| 1 | User | Pelanggan atau admin |
| 2 | Checkout | Proses final transaksi |
| 3 | Laravel | Framework PHP yang digunakan untuk membangun logika aplikasi dan struktur backend |
| 4 | Midtrans | Payment gateway untuk pembayaran online |
| 5 | CI/CD | Continuous Integration/Continuous Deployment |
| 6 | GitHub Actions | Platform untuk automasi CI/CD |

### 1.5 Referensi

- Dokumentasi Laravel
- Dokumentasi MySQL
- Dokumentasi Midtrans
- Modul Perkuliahan Rekayasa Perangkat Lunak
- Standard IEEE SRS

---

## 2. Deskripsi Keseluruhan

### 2.1 Deskripsi Produk

Toko Roti JIYA adalah aplikasi web untuk memesan roti secara online. Pelanggan dapat melihat katalog, memasukkan item ke keranjang, checkout, dan melakukan pembayaran melalui Midtrans. Admin dapat mengelola produk, stok, harga, dan memproses pesanan.

### 2.2 Fungsi Produk

Sistem mencakup:
- Penampilan katalog roti
- Pengelolaan keranjang
- Checkout dan pembayaran via Midtrans
- Email konfirmasi otomatis
- Manajemen produk (admin)
- Manajemen pesanan (admin)
- Tracking status pesanan

### 2.3 Penggolongan Karakteristik Pengguna

| Kategori Pengguna | Tugas | Hak Akses | Kemampuan yang Harus Dimiliki |
|-------------------|-------|-----------|-------------------------------|
| Pelanggan | Pengguna umum | Menggunakan fitur katalog, keranjang, checkout, dan status pesanan | Tidak memerlukan skill teknis |
| Admin | Memverifikasi pembayaran | Mengelola produk dan pesanan | Mampu mengoperasikan dashboard |
| Pemilik toko | Melihat data penjualan dan performa sistem | Melihat data penjualan dan performa sistem | Management yang bagus |

### 2.4 Lingkungan Operasi

| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 10+ |
| Database | MySQL |
| Payment Gateway | Midtrans (Sandbox/Production) |
| Email | Laravel Mail |
| CSS Framework | Bootstrap 5 |
| Fonts | Google Fonts (Playfair Display, Poppins) |
| Icons | Font Awesome 6 |
| CI/CD | GitHub Actions |
| Hosting | Railway / Vercel |

### 2.5 Batasan Desain dan Implementasi

- Sistem harus responsif di berbagai perangkat
- Password dienkripsi menggunakan bcrypt
- Pembayaran menggunakan Midtrans Payment Gateway
- Akses admin harus memiliki proteksi role
- CI/CD pipeline harus berjalan otomatis pada setiap push

### 2.6 Dokumentasi Pengguna

- Manual penggunaan pelanggan
- Manual admin untuk pengelolaan produk dan pesanan
- Dokumentasi CI/CD

---

## 3. Kebutuhan Antarmuka Eksternal

### 3.1 User Interfaces

| No | Halaman | Status |
|----|---------|--------|
| 1 | Halaman Home | Implemented |
| 2 | Halaman Katalog Produk | Implemented |
| 3 | Halaman Detail Produk | Implemented |
| 4 | Halaman Keranjang | Implemented |
| 5 | Halaman Checkout | Implemented |
| 6 | Halaman Midtrans Payment | Implemented |
| 7 | Dashboard Admin | Implemented |
| 8 | Halaman About Us | Implemented |
| 9 | Halaman Guest Checkout | Implemented |
| 10 | Halaman Order History | Implemented |
| 11 | Halaman Order Detail | Implemented |

### 3.2 Hardware Interface

- Client membutuhkan perangkat mobile/PC
- Server membutuhkan hosting yang mendukung PHP 8+ dan MySQL

### 3.3 Software Interface

- Browser web
- Laravel Framework
- MySQL Database
- Server-side PHP

### 3.4 Communication Interface

- Protokol HTTP/HTTPS
- Midtrans API Integration
- SMTP Email Server

---

## 4. Functional Requirements

| ID | Kebutuhan Fungsional | Penjelasan |
|----|---------------------|------------|
| FR001 | Pengelolaan Produk | Admin dapat CRUD (Create, Read, Update, Delete) data produk (Kue, Cookies, Roti) termasuk harga, deskripsi dan gambarnya |
| FR002 | Transaksi Pembelian | Pelanggan dapat Melihat Katalog, Mengelola Keranjang, Checkout (termasuk Guest Checkout), dan Melakukan Pembayaran via Midtrans |
| FR003 | Management Pesanan | Pelanggan dapat Melacak Status pesanan. Admin dapat Memverifikasi dan Mengubah Status pesanan (misalnya: diproses, dikirim, selesai) |
| FR004 | Autentikasi | Pengguna dapat Mendaftar, Login, dan Mengelola Profil (mengubah alamat dan kata sandi) |
| FR005 | Pelaporan (Admin) | Admin dapat Melihat Laporan penjualan harian, bulanan, dan produk terlaris |
| FR006 | Email Notification | Sistem mengirim email konfirmasi otomatis setelah pembayaran berhasil |
| FR007 | CI/CD Pipeline | Sistem memiliki automated testing dan deployment melalui GitHub Actions |

---

## 5. Non-Functional Requirements

Berikut adalah Non-Functional Requirements yang harus dipenuhi oleh sistem aplikasi Toko Roti JIYA. Setiap kebutuhan diuraikan dengan kalimat yang jelas dan dapat diuji untuk memastikan sistem memenuhi standar kualitas yang ditentukan.

| ID | Parameter | Kebutuhan |
|----|-----------|-----------|
| NFR001 | Performance | Sistem harus memiliki kecepatan muat halaman utama dan produk maksimal 3 detik |
| NFR002 | Security | Password pengguna harus dienkripsi menggunakan algoritma hashing. Semua form harus memiliki proteksi CSRF token |
| NFR003 | Usability | Interface harus responsif (dapat diakses di laptop, komputer, HP). Alur checkout maksimal 3 langkah |
| NFR004 | Reliability | Sistem harus mampu menangani minimal 50 pengguna aktif bersamaan tanpa penurunan performa signifikan |
| NFR005 | Technology | Backend menggunakan PHP/Laravel; Database menggunakan MySQL |
| NFR006 | Usability | Interface harus mudah dipahami dan dapat digunakan tanpa pelatihan khusus oleh Admin maupun Owner |
| NFR007 | Usability | Sistem harus menyediakan tampilan rekapitulasi yang mudah dibaca, dengan penggunaan tabel dan pemisahan kolom yang jelas |
| NFR008 | Ergonomy | Tampilan tidak terlalu nyentrik dan fokus dengan produk-produk favorit |
| NFR009 | Availability | N/A |
| NFR010 | Portability | N/A |
| NFR011 | Memory | N/A |
| NFR012 | Response Time | Halaman checkout harus menampilkan konfirmasi dalam waktu maksimal 5 detik setelah pembayaran berhasil |
| NFR013 | Safety | N/A |

---

## 6. CI/CD Requirements

### 6.1 Continuous Integration (CI)

| ID | Requirement | Description |
|----|-------------|-------------|
| CI001 | Automated Testing | Sistem harus menjalankan unit test dan feature test secara otomatis pada setiap push ke repository |
| CI002 | Build Verification | Pipeline harus memverifikasi bahwa aplikasi dapat di-build tanpa error |
| CI003 | Code Quality | Pipeline harus memeriksa kualitas kode sebelum merge |

### 6.2 Continuous Deployment (CD)

| ID | Requirement | Description |
|----|-------------|-------------|
| CD001 | Staging Deployment | Push ke branch develop harus trigger deployment otomatis ke staging environment |
| CD002 | Production Deployment | Push ke branch main harus trigger deployment otomatis ke production environment |
| CD003 | Rollback Mechanism | Sistem harus menyediakan mekanisme rollback ke versi sebelumnya jika terjadi kegagalan |

### 6.3 Branching Strategy

| Branch | Purpose |
|--------|---------|
| main | Production-ready code |
| develop | Staging and feature integration |
| feature/* | New feature development |
| bugfix/* | Bug fixes |
| hotfix/* | Urgent production fixes |

### 6.4 GitHub Actions Workflow

Workflow dijalankan secara otomatis ketika:
- Push ke branch main
- Pull request ke branch main

Steps yang dieksekusi:
1. Setup PHP 8.2 environment
2. Checkout source code
3. Install Composer dependencies
4. Generate application key
5. Setup SQLite test database
6. Execute PHPUnit/Pest tests

### 6.5 Deployment Environments

| Environment | URL | Branch | Trigger |
|-------------|-----|--------|---------|
| Production | https://jeycookie.vercel.app | main | Push to main |
| Staging | https://jeycookie-staging.vercel.app | develop | Push to develop |

---

*Document Version: 2.1*
*Last Updated: 14 January 2026*
