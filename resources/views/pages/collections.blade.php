@extends('layouts.app')

@push('styles')
    @vite(['resources/css/collections.css'])
@endpush

@push('scripts')
    @vite(['resources/js/collections.js'])
@endpush

@section('title', 'Collections — Bloopsie')

@section('content')
<div class="wrap">
  <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> / <span>Collections</span></div>
  
  <section class="shop-hero">
    <span class="eyebrow">The Heart of Bloopsie</span>
    <h1>Monthly <em>Collections</em></h1>
    <p>Setiap bulan, kami merilis tema baru yang eksklusif dan penuh cerita.</p>
  </section>
</div>

<div class="torn-sm"></div>

<!-- CURRENT COLLECTION -->
<section class="current-col-bg">
  <div class="wrap">
    <div class="section-head" style="margin-bottom:40px;">
      <h2>Current Collection</h2>
    </div>

    <div class="collection-card">
      <div class="collection-img">
        <img src="{{ asset('images/Produk 1.jpeg') }}" alt="Pink Fairy Collection">
        <div class="seal">
          <span class="num">AUG</span>
          <span class="lbl">2026</span>
        </div>
      </div>
      <div class="collection-body">
        <div class="countdown-badge">🌸 August 2026 <span>• Ends in 12 Days</span></div>
        <h3>Pink <span>Fairy</span></h3>
        <p>Bawa keajaiban kecil ke dalam jurnalmu! Koleksi Pink Fairy bulan Agustus menghadirkan nuansa magis.</p>
        <div class="current-col-actions">
          <button class="btn btn-primary">Explore Collection</button>
          <button class="btn btn-outline">View All Products</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STORY DIVIDER -->
<div class="wrap story-divider-wrap">
  <div class="story-divider">
    <hr>
    <h3>Every Month Tells A New Story</h3>
    <p>Setiap koleksi dibuat eksklusif dengan tema, warna, ilustrasi, dan packaging yang berbeda. Ketika bulan berganti, tema baru akan hadir, namun koleksi sebelumnya tetap tersedia selama stok masih ada.</p>
    <hr>
  </div>
</div>

<!-- ARCHIVE SECTION -->
<section class="archive wrap">
  <h2 class="year-divider">2026</h2>
  <div class="archive-grid">
    <!-- Di Phase Backend nanti, ini bakal kita looping dari Database -->
    <div class="archive-card">
      <div class="archive-photo">
        <img src="https://images.unsplash.com/photo-1490735891913-40897cdaafd1?auto=format&fit=crop&q=80&w=600" alt="Blue Memories">
        <span class="status-badge instock">● Masih Bisa Dibeli</span>
      </div>
      <div class="archive-info">
        <span class="theme-badge theme-blue">July 2026</span>
        <h4>Blue Memories</h4>
        <span class="product-count">12 Products</span>
        <button class="btn btn-outline btn-sm btn-block">Shop "Blue Memories"</button>
      </div>
    </div>
    <!-- ... tambahkan archive-card lainnya ... -->
  </div>
</section>
@endsection