@extends('layouts.app')

@push('styles')
    @vite(['resources/css/product-detail.css'])
@endpush

@push('scripts')
    @vite(['resources/js/product-detail.js'])
@endpush

@section('title', 'Fairy Garden Stickers — Bloopsie.id')

@section('content')
<div class="wrap">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> / <a href="{{ route('shop') }}">Shop</a> / <span>Fairy Garden Stickers</span>
  </div>

  <div class="product-main">
    <div class="gallery">
      <div class="gallery-main">
        <div class="gallery-badge">Best Seller</div>
        <img id="mainImg" src="{{ asset('Images/Produk 1.jpeg') }}" alt="Fairy Garden Sticker">
      </div>
      <div class="gallery-thumbs">
        <img src="{{ asset('Images/Produk 2.jpeg') }}" alt="Sticker Sheet 2" onclick="swapImg(this, '{{ asset('Images/Produk 2.jpeg') }}')">
        <img src="{{ asset('Images/Produk 3.jpeg') }}" alt="Sticker Sheet 3" onclick="swapImg(this, '{{ asset('Images/Produk 3.jpeg') }}')">
        <img src="{{ asset('Images/Produk 4.jpeg') }}" alt="Sticker Sheet 4" onclick="swapImg(this, '{{ asset('Images/Produk 4.jpeg') }}')">
        <img src="{{ asset('Images/Produk 5.jpeg') }}" alt="Sticker Sheet 5" onclick="swapImg(this, '{{ asset('Images/Produk 5.jpeg') }}')">
      </div>
    </div>

    <div class="product-info">
      <span class="cat">Sticker Sheet · August Collection</span>
      <h1>Fairy Garden Stickers</h1>
      <div class="rating-row">
        <span class="stars">★★★★★</span>
        <span>4.9 dari 5 · 218 ulasan · 1.2k terjual</span>
      </div>
      <div class="price-block">
        <span class="price-now">Rp 35.000</span>
        <span class="price-old">Rp 42.000</span>
      </div>
      <p class="desc">Sticker sheet A6 dengan tema Pink Fairy — glitter laminated, kiss cut, vinyl waterproof. Cocok untuk journaling, hadiah kecil, atau menghias mailbox favoritmu.</p>

      <div class="qty-row">
        <div class="qty-control">
          <button onclick="changeQty(-1)">−</button>
          <span id="qtyVal">1</span>
          <button onclick="changeQty(1)">+</button>
        </div>
        <button class="wishlist-btn" aria-label="Wishlist">🤍</button>
      </div>

      <div class="action-row">
        <button class="btn btn-outline">Add To Cart</button>
        <button class="btn btn-primary">Buy Now</button>
      </div>

      <div class="meta-list">
        <div><span>SKU</span><strong>BLP-STK-0142</strong></div>
        <div><span>Ukuran</span><strong>A6 (10.5 × 14.8 cm)</strong></div>
        <div><span>Material</span><strong>Vinyl, Glossy Laminated</strong></div>
        <div><span>Pengiriman</span><strong>Domestik & Internasional</strong></div>
      </div>
    </div>
  </div>

  <div class="tabs">
    <button class="tab-btn active" data-tab="desc">Description</button>
    <button class="tab-btn" data-tab="shipping">Shipping Info</button>
    <button class="tab-btn" data-tab="reviews">Reviews (218)</button>
  </div>

  <div class="tab-panel active" id="desc">
    <p>Setiap sticker digambar tangan oleh tim ilustrasi Bloopsie, terinspirasi dari tema koleksi bulan berjalan.</p>
    <ul>
      <li>Kiss cut — mudah dilepas</li>
      <li>Glitter laminated finishing</li>
      <li>Waterproof & tahan lama</li>
    </ul>
  </div>
  <div class="tab-panel" id="shipping">
    <p>Pesanan diproses dalam 1–2 hari kerja setelah pembayaran dikonfirmasi.</p>
  </div>
  <div class="tab-panel" id="reviews">
     <!-- Review Items -->
  </div>
</div>

<section class="related">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow">You May Also Like</span>
      <h2>Produk Terkait</h2>
    </div>
    <div class="products-grid" id="relatedGrid"></div>
  </div>
</section>
@endsection