@extends('layouts.app')

@push('styles')
    @vite(['resources/css/cart.css'])
@endpush

@push('scripts')
    @vite(['resources/js/cart.js'])
@endpush

@section('title', 'Your Cart — Bloopsie.id')

@section('content')

<!-- ========================================== -->
<!-- SISTEM KONVERSI MATA UANG (DYNAMIC CURRENCY) -->
<!-- ========================================== -->
@php
    // 1. Ambil mata uang dari session
    $currency = session('currency', 'IDR');
    
    // 2. Kurs statis
    $rates = [
        'IDR' => 1,
        'USD' => 0.000064,
        'SGD' => 0.000085,
        'MYR' => 0.00030,
        'AUD' => 0.00010,
    ];

    // 3. Simbol Mata Uang
    $symbols = [
        'IDR' => 'Rp',
        'USD' => '$',
        'SGD' => 'S$',
        'MYR' => 'RM',
        'AUD' => 'A$',
    ];

    // 4. Set Nilai
    $currentRate = $rates[$currency] ?? 1;
    $currentSymbol = $symbols[$currency] ?? 'Rp';

    // 5. Hitung Subtotal Base (IDR)
    $subtotal = 0;
    foreach($cartItems as $item) {
        if($item->product) {
            $subtotal += $item->product->price * $item->quantity;
        }
    }
@endphp
<!-- ========================================== -->

<!-- TOAST NOTIFICATION -->
<div class="toast" id="toastBox">
    <span style="font-size: 1.2rem">✔</span> Voucher applied successfully!
</div>

<div class="wrap">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> / <span>Cart</span>
    </div>

    <div class="page-header">
        <h1>
            Your Cart <span class="item-count" id="itemCount">{{ $cartItems->count() }} Items</span>
        </h1>
        <!-- INDIKATOR MATA UANG -->
        <div style="margin-top: 10px; font-size: 0.85rem; color: var(--muted); background: var(--secondary); display: inline-block; padding: 4px 12px; border-radius: 20px;">
            Prices displayed in: <strong>{{ $currency }}</strong>
        </div>
    </div>

    <div class="cart-wrapper">
        <!-- KOLOM KIRI (ITEMS & VOUCHER) -->
        <div class="cart-items-container">
            <!-- Cart Items List -->
            <div class="cart-card" id="cartList">
                
                @forelse($cartItems as $item)
                    <!-- Dynamic Item -->
                    <div class="cart-item" id="item-{{ $item->id }}">
                        <img 
                            src="{{ $item->product->cover_image ? asset('images/' . $item->product->cover_image) : 'https://picsum.photos/seed/'.$item->product->id.'/800/800' }}" 
                            alt="{{ $item->product->name }}" 
                            class="item-img"
                        >
                        <div class="item-details">
                            <span class="item-cat">{{ $item->product->category?->name ?? 'Produk' }}</span>
                            <div class="item-title">{{ $item->product->name }}</div>
                            <div class="item-price">
                                <!-- HARGA PRODUK DIKONVERSI -->
                                {{ $currentSymbol }} 
                                {{ $currency === 'IDR' 
                                    ? number_format($item->product->price, 0, ',', '.') 
                                    : number_format($item->product->price * $currentRate, 2, '.', ',') 
                                }}
                            </div>
                        </div>
                        <div class="item-actions">
                            <div class="qty-control">
                                <!-- Pastikan logic updateQty di JS mendukung format angka baru ini jika perlu -->
                                <button
                                    aria-label="Decrease"
                                    onclick="updateQty('qty-{{ $item->id }}', -1, {{ $item->product->price }})"
                                >
                                    −
                                </button>
                                <span id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                <button
                                    aria-label="Increase"
                                    onclick="updateQty('qty-{{ $item->id }}', 1, {{ $item->product->price }})"
                                >
                                    +
                                </button>
                            </div>
                            <button
                                class="btn-delete"
                                aria-label="Delete Item"
                                onclick="removeItem('item-{{ $item->id }}')"
                            >
                                🗑️
                            </button>
                        </div>
                    </div>
                @empty
                    <!-- Tampilan Jika Keranjang Kosong -->
                    <div style="text-align: center; padding: 2rem;">
                        <h3 style="color: var(--muted); margin-bottom: 15px;">Keranjang kamu masih kosong</h3>
                        <a href="{{ route('shop') }}" class="btn btn-primary">Belanja Sekarang</a>
                    </div>
                @endforelse

            </div>

            <!-- Voucher Section -->
            @if($cartItems->count() > 0)
                <div class="cart-card">
                    <h3 style="font-size: 1.1rem; font-family: var(--sans); font-weight: 700; margin-bottom: 8px;">
                        Punya Kode Voucher?
                    </h3>
                    <p style="font-size: 0.9rem; color: var(--muted)">
                        Masukkan kodemu di sini untuk diskon spesial.
                    </p>
                    <div class="voucher-section">
                        <input
                            type="text"
                            id="voucherCode"
                            placeholder="Misal: BLOOP10"
                        />
                        <button class="btn btn-outline" onclick="applyVoucher()">
                            Apply
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- SIDEBAR KANAN (SUMMARY) -->
        <aside class="summary-card">
            <h3>Order Summary</h3>

            <div class="summary-row">
                <span>Subtotal</span>
                <span class="val" id="subtotalDisplay">
                    <!-- SUBTOTAL DIKONVERSI -->
                    {{ $currentSymbol }} 
                    {{ $currency === 'IDR' 
                        ? number_format($subtotal, 0, ',', '.') 
                        : number_format($subtotal * $currentRate, 2, '.', ',') 
                    }}
                </span>
            </div>
            
            <div class="summary-row">
                <span>Shipping</span>
                <span class="val">Calculated at checkout</span>
            </div>
            
            <div class="summary-row" id="discountRow" style="display: none; color: #2e7d32">
                <span>Voucher Discount</span>
                <span class="val" id="discountDisplay">- {{ $currentSymbol }} 0</span>
            </div>

            <div class="summary-row total">
                <span>Total</span>
                <span class="val" id="totalDisplay">
                    <!-- TOTAL DIKONVERSI -->
                    {{ $currentSymbol }} 
                    {{ $currency === 'IDR' 
                        ? number_format($subtotal, 0, ',', '.') 
                        : number_format($subtotal * $currentRate, 2, '.', ',') 
                    }}
                </span>
            </div>

            <button
                class="btn btn-primary btn-block"
                style="font-size: 1.05rem"
                onclick="window.location.href = '{{ route('checkout') }}'"
                {{ $cartItems->count() == 0 ? 'disabled' : '' }}
            >
                Checkout 🛍️
            </button>

            <p style="text-align: center; font-size: 0.75rem; color: var(--muted); margin-top: 20px;">
                Taxes and shipping calculated at checkout.
            </p>
        </aside>
    </div>
</div>
@endsection