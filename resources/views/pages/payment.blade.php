@extends('layouts.app')

@push('styles')
    <!-- Panggil app.css & home.css agar Navbar, Footer, dan Warna Tema Bloopsie ikut terload -->
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/css/payment.css'])
@endpush

@section('title', 'Payment — Bloopsie.id')

@section('content')
<!-- ... sisa kode di bawahnya tetap sama ... -->
<div class="wrap">
    <div class="payment-wrapper">
        
        <div class="payment-header">
            <div class="payment-icon">💌</div>
            <h1>Pesanan Berhasil Dibuat!</h1>
            <p>Selesaikan pembayaranmu agar kami bisa segera menyiapkan pesananmu.</p>
        </div>

        <div class="invoice-box">
            <!-- Asumsikan data ini dikirim dari Controller -->
            <div class="invoice-row">
                <span style="color: var(--muted);">Order ID</span>
                <strong>#BLP-{{ rand(10000, 99999) }}</strong>
            </div>
            <div class="invoice-row">
                <span style="color: var(--muted);">Payment Method</span>
                <strong style="text-transform: uppercase;">{{ request('method', 'QRIS') }}</strong>
            </div>
            <div class="invoice-row total">
                <span>Total Amount</span>
                <span>Rp {{ number_format(session('grand_total', 290000), 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- LOGIKA TAMPILAN BERDASARKAN METODE PEMBAYARAN -->
        <div class="payment-instructions">
            
            @if(in_array(strtolower(request('method', 'qris')), ['qris', 'gopay', 'paypal']))
                <h3 style="font-family: var(--sans); font-size: 1.1rem; margin-bottom: 16px;">Scan to Pay</h3>
                <!-- Placeholder untuk gambar Barcode/QRIS -->
                <div class="qr-placeholder">
                    QR CODE HERE
                </div>
                <p style="font-size: 0.85rem; color: var(--muted);">Buka aplikasi e-wallet atau m-banking kamu, lalu scan QR Code di atas.</p>
            
            @else
                <h3 style="font-family: var(--sans); font-size: 1.1rem; margin-bottom: 8px;">Transfer ke Rekening Berikut</h3>
                <p style="font-size: 0.85rem; color: var(--muted);">Virtual Account / Bank Transfer</p>
                
                <!-- Placeholder untuk Nomor VA -->
                <div class="va-number">8801 2345 6789</div>
                
                <p style="font-size: 0.85rem; color: var(--muted);">Atas Nama: <strong>Bloopsie Indonesia</strong></p>
            @endif

        </div>

        <div class="payment-actions">
            <!-- Tombol simulasi konfirmasi pembayaran -->
            <a href="{{ route('orders') }}" class="btn btn-primary" style="width: 100%;">Saya Sudah Bayar</a>
            <a href="{{ route('home') }}" class="btn btn-outline" style="width: 100%; border: none;">Kembali ke Beranda</a>
        </div>

    </div>
</div>
@endsection