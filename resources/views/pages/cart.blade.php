@extends('layouts.app')

@push('styles')
    @vite(['resources/css/cart.css'])
@endpush

@push('scripts')
    @vite(['resources/js/cart.js'])
@endpush

@section('title', 'Your Cart — Bloopsie.id')

@section('content')
<!-- TOAST NOTIFICATION -->
<div class="toast" id="toastBox">
    <span style="font-size: 1.2rem">✔</span> Voucher applied successfully!
</div>

    <div class="wrap">
        <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> / <span>Shop</span></div>

    <div class="page-header">
        <h1>
        Your Cart <span class="item-count" id="itemCount">2 Items</span>
        </h1>
    </div>

    <div class="cart-wrapper">
        <!-- KOLOM KIRI (ITEMS & VOUCHER) -->
        <div class="cart-items-container">
        <!-- Cart Items List -->
        <div class="cart-card" id="cartList">
            <!-- Item 1 -->
            <div class="cart-item" id="item-1">
            <img
                src="images/Produk 1.jpeg"
                alt="Fairy Garden Stickers"
                class="item-img"
            />
            <div class="item-details">
                <span class="item-cat">Sticker Sheet</span>
                <div class="item-title">Fairy Garden Stickers</div>
                <div class="item-price">Rp 35.000</div>
            </div>
            <div class="item-actions">
                <div class="qty-control">
                <button
                    aria-label="Decrease"
                    onclick="updateQty('qty-1', -1, 35000)"
                >
                    −
                </button>
                <span id="qty-1">2</span>
                <button
                    aria-label="Increase"
                    onclick="updateQty('qty-1', 1, 35000)"
                >
                    +
                </button>
                </div>
                <button
                class="btn-delete"
                aria-label="Delete Item"
                onclick="removeItem('item-1')"
                >
                🗑️
                </button>
            </div>
            </div>

            <!-- Item 2 -->
            <div class="cart-item" id="item-2">
            <img
                src="images/Produk 3.jpeg"
                alt="Little Dreamer Journal"
                class="item-img"
            />
            <div class="item-details">
                <span class="item-cat">Notebook</span>
                <div class="item-title">Little Dreamer Journal</div>
                <div class="item-price">Rp 62.000</div>
            </div>
            <div class="item-actions">
                <div class="qty-control">
                <button
                    aria-label="Decrease"
                    onclick="updateQty('qty-2', -1, 62000)"
                >
                    −
                </button>
                <span id="qty-2">1</span>
                <button
                    aria-label="Increase"
                    onclick="updateQty('qty-2', 1, 62000)"
                >
                    +
                </button>
                </div>
                <button
                class="btn-delete"
                aria-label="Delete Item"
                onclick="removeItem('item-2')"
                >
                🗑️
                </button>
            </div>
            </div>
        </div>

        <!-- Voucher Section -->
        <div class="cart-card">
            <h3
            style="
                font-size: 1.1rem;
                font-family: var(--sans);
                font-weight: 700;
                margin-bottom: 8px;
            "
            >
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
        </div>

        <!-- SIDEBAR KANAN (SUMMARY) -->
        <aside class="summary-card">
        <h3>Order Summary</h3>

        <div class="summary-row">
            <span>Subtotal</span>
            <span class="val" id="subtotalDisplay">Rp 132.000</span>
        </div>
        <div class="summary-row">
            <span>Shipping</span>
            <span class="val">Calculated at checkout</span>
        </div>
        <div
            class="summary-row"
            id="discountRow"
            style="display: none; color: #2e7d32"
        >
            <span>Voucher Discount</span>
            <span class="val" id="discountDisplay">- Rp 0</span>
        </div>

        <div class="summary-row total">
            <span>Total</span>
            <span class="val" id="totalDisplay">Rp 132.000</span>
        </div>

        <button
            class="btn btn-primary btn-block"
            style="font-size: 1.05rem"
            onclick="window.location.href = '#'"
        >
            Checkout 🛍️
        </button>

        <p
            style="
            text-align: center;
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 20px;
            "
        >
            Taxes and shipping calculated at checkout.
        </p>
        </aside>
    </div>
    </div>
@endsection