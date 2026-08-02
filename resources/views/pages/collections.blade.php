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
@if($currentCollection)
<section class="current-col-bg">
  <div class="wrap">
    <div class="section-head" style="margin-bottom:40px;">
      <h2>Current Collection</h2>
    </div>

    <div class="collection-card">
      <div class="collection-img">
        {{-- Ganti 'cover_image' dengan nama kolom gambar di database kamu --}}
        <img src="{{ asset('images/' . $currentCollection->banner) }}" alt="{{ $currentCollection->name }}">
        <div class="seal">
          <span class="num">{{ \Carbon\Carbon::parse($currentCollection->created_at)->format('M') }}</span>
          <span class="lbl">{{ \Carbon\Carbon::parse($currentCollection->created_at)->format('Y') }}</span>
        </div>
      </div>
      <div class="collection-body">
        <div class="countdown-badge">
            🌸 {{ \Carbon\Carbon::parse($currentCollection->created_at)->format('F Y') }}
        </div>
        
        <h3>{{ $currentCollection->name }}</h3>
        <p>{{ $currentCollection->description ?? 'Koleksi eksklusif bulan ini menghadirkan nuansa magis.' }}</p>
        
        <div class="current-col-actions">
          <button class="btn btn-primary">Explore Collection</button>
          <a href="{{ route('shop') }}" class="btn btn-outline">View All Products</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

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
  
  @forelse($archives as $year => $collections)
      <!-- Pemisah Tahun (contoh: 2026, 2025) -->
      <h2 class="year-divider">{{ $year }}</h2>
      
      <div class="archive-grid">
        @foreach($collections as $col)
            <div class="archive-card">
              <div class="archive-photo">
                <img src="{{ asset('images/' . $col->cover_image) }}" alt="{{ $col->name }}">
                
                {{-- Jika kamu punya logika untuk cek stok di model Collection, pasang di sini --}}
                <span class="status-badge instock">● Masih Tersedia</span>
              </div>
              <div class="archive-info">
                <span class="theme-badge theme-blue">{{ \Carbon\Carbon::parse($col->created_at)->format('F Y') }}</span>
                <h4>{{ $col->name }}</h4>
                <span class="product-count">{{ $col->products_count }} Products</span>
                <button class="btn btn-outline btn-sm btn-block">Shop "{{ $col->name }}"</button>
              </div>
            </div>
        @endforeach
      </div>
  @empty
      <div style="text-align: center; padding: 2rem; color: var(--muted);">
          <p>Belum ada koleksi terdahulu.</p>
      </div>
  @endforelse

</section>
@endsection