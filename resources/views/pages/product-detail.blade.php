@extends('layouts.app')

@push('styles')
    @vite(['resources/css/product-detail.css'])
@endpush

@push('scripts')
    @vite(['resources/js/product-detail.js'])
@endpush

@section('title', $product->name . ' — Bloopsie.id')

@section('content')
<div class="wrap">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> / <a href="{{ route('shop') }}">Shop</a> / <span>{{ $product->name }}</span>
  </div>

  <div class="product-main">
    <div class="gallery">
      <div class="gallery-main">
        @if ($product->featured)
            <div class="gallery-badge">Best Seller</div>
        @endif
        
        <!-- Menampilkan gambar produk dari database -->
        <img id="mainImg" src="{{ $product->cover_image ? asset('storage/'.$product->cover_image) : 'https://picsum.photos/seed/'.$product->id.'/800/800' }}" alt="{{ $product->name }}">
      </div>
      
      <!-- Bagian Thumbnail (Jika kamu belum punya banyak gambar di DB, biarkan statis dulu atau gunakan loop jika sudah ada) -->
      <div class="gallery-thumbs">
        <img src="{{ asset('Images/Produk 2.jpeg') }}" class="active" alt="Thumb 1" onclick="swapImg(this, '{{ asset('Images/Produk 2.jpeg') }}')">
        <img src="{{ asset('Images/Produk 3.jpeg') }}" alt="Thumb 2" onclick="swapImg(this, '{{ asset('Images/Produk 3.jpeg') }}')">
      </div>
    </div>

    <div class="product-info">
      <span class="cat">{{ $product->category->name ?? 'Bloopsie Collection' }}</span>
      
      <!-- Nama Produk Dinamis -->
      <h1>{{ $product->name }}</h1>
      
      <div class="rating-row">
        <span class="stars">★★★★★</span>
        <span>4.9 dari 5 · 218 ulasan</span>
      </div>
      
      <div class="price-block">
        <!-- Harga Dinamis -->
        <span class="price-now">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
      </div>
      
      <!-- Deskripsi Dinamis -->
      <p class="desc">{{ $product->description ?? 'Produk handmade eksklusif dari Bloopsie.id yang dikemas dengan penuh cinta.' }}</p>

      <div class="qty-row">
        <div class="qty-control">
          <button onclick="changeQty(-1)">−</button>
          <span id="qtyVal">1</span>
          <button onclick="changeQty(1)">+</button>
        </div>
        <button class="wishlist-btn" aria-label="Wishlist">🤍</button>
      </div>

      <div class="action-row">
        <!-- Jika stok habis, nonaktifkan tombol -->
        @if($product->stock > 0)
            <button class="btn btn-outline">Add To Cart</button>
            <button class="btn btn-primary">Buy Now</button>
        @else
            <button class="btn btn-primary" style="background: var(--muted); cursor: not-allowed;" disabled>Sold Out</button>
        @endif
      </div>

      <div class="meta-list">
        <div><span>SKU</span><strong>BLP-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
        <div><span>Stok</span><strong>{{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}</strong></div>
        <div><span>Pengiriman</span><strong>Domestik & Internasional</strong></div>
      </div>
    </div>
  </div>

  <div class="tabs">
    <button class="tab-btn active" data-tab="desc">Description</button>
    <button class="tab-btn" data-tab="shipping">Shipping Info</button>
  </div>

  <div class="tab-panel active" id="desc">
    <!-- Menggunakan nl2br agar enter di deskripsi database terbaca -->
    <p>{!! nl2br(e($product->description)) !!}</p>
  </div>
  <div class="tab-panel" id="shipping">
    <p>Pesanan diproses dalam 1–2 hari kerja setelah pembayaran dikonfirmasi.</p>
  </div>
</div>

<section class="related">
  <div class="wrap">
    <div class="section-head">
      <span class="eyebrow">You May Also Like</span>
      <h2>Produk Terkait</h2>
    </div>
    <div class="products-grid" id="relatedGrid">
        <!-- Biarkan JS yang merender atau bisa kamu ganti pakai loop dari Controller nantinya -->
    </div>
  </div>
</section>
@endsection