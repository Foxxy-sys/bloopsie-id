@extends('layouts.app')

@push('styles')
    @vite(['resources/css/shop.css'])
@endpush

@push('scripts')
    @vite(['resources/js/shop.js'])
@endpush

@section('title', 'Shop All Products — Bloopsie.id')

@section('content')

<!-- ========================================== -->
<!-- SISTEM KONVERSI MATA UANG (DYNAMIC CURRENCY) -->
<!-- ========================================== -->
@php
    // 1. Ambil mata uang dari session (Default IDR jika tidak ada)
    $currency = session('currency', 'IDR');
    
    // 2. Buat kurs konversi sederhana (Berdasarkan IDR)
    // Catatan: Ini adalah kurs statis perkiraan.
    $rates = [
        'IDR' => 1,
        'USD' => 0.000064, // Asumsi $1 = Rp 15.600
        'SGD' => 0.000085, // Asumsi S$1 = Rp 11.700
        'MYR' => 0.00030,  // Asumsi RM1 = Rp 3.300
        'AUD' => 0.00010,  // Asumsi A$1 = Rp 10.000
    ];

    // 3. Simbol Mata Uang
    $symbols = [
        'IDR' => 'Rp',
        'USD' => '$',
        'SGD' => 'S$',
        'MYR' => 'RM',
        'AUD' => 'A$',
    ];

    // 4. Set Nilai Kurs & Simbol Aktif
    $currentRate = $rates[$currency] ?? 1;
    $currentSymbol = $symbols[$currency] ?? 'Rp';
@endphp
<!-- ========================================== -->

<div class="wrap">
  <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> / <span>Shop</span></div>

  <section class="shop-hero">
    <span class="eyebrow">Bloopsie Store</span>
    <h1>Shop All Products</h1>
    <p>Semua koleksi handmade Bloopsie ada di sini — stickers, journal goodies, sampai paket kejutan bulanan.</p>
    
    <!-- INDIKATOR MATA UANG AKTIF (Opsional, agar pembeli tahu) -->
    <div style="margin-top: 15px; font-size: 0.85rem; color: var(--muted); background: var(--secondary); display: inline-block; padding: 4px 12px; border-radius: 20px;">
        Prices displayed in: <strong>{{ $currency }}</strong>
    </div>

  </section>
  <div class="torn-sm"></div>

  <form method="GET" action="{{ route('shop') }}" id="shopFilterForm">

    <div class="shop-toolbar">
      <div class="search-box">
        <span>🔍</span>
        <input type="text" name="q" id="searchInput" placeholder="Search produk..." value="{{ request('q') }}">
      </div>
      <div class="toolbar-actions">
        <button type="button" class="toolbar-btn" id="filterToggle">
          <span>⚙️</span> Filter <span class="count-pill" id="filterCount">0</span>
        </button>
        <span class="result-count" id="resultCount">{{ $products->total() }} produk ditemukan</span>
      </div>
    </div>

    <div class="shop-layout">

      <!-- ===== FILTER SIDEBAR ===== -->
      <aside class="filters" id="filtersPanel">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
          <h3 style="font-size:1.1rem;">Filter</h3>
          <span class="clear-filters" id="clearFilters">Reset</span>
        </div>

        <!-- Filter Berdasarkan Bulan Rilis -->
        <div class="filter-group">
          <div class="filter-head"><h4>Release Month</h4><span>▾</span></div>
          @foreach ($months as $m)
            <label class="filter-option">
              <input type="checkbox" name="month[]" value="{{ $m['value'] }}"
                {{ in_array($m['value'], request('month', [])) ? 'checked' : '' }}>
              {{ $m['label'] }}<span class="opt-count">({{ $m['count'] }})</span>
            </label>
          @endforeach
        </div>

        <!-- Filter Berdasarkan Kategori -->
        <div class="filter-group">
          <div class="filter-head"><h4>Category</h4><span>▾</span></div>
          @foreach ($categories as $cat)
            <label class="filter-option">
              <input type="checkbox" name="category[]" value="{{ $cat->id }}"
                {{ in_array($cat->id, request('category', [])) ? 'checked' : '' }}>
              {{ $cat->name }}<span class="opt-count">({{ $cat->products_count ?? $cat->products()->count() }})</span>
            </label>
          @endforeach
        </div>

        <!-- Filter Ketersediaan -->
        <div class="filter-group">
          <div class="filter-head"><h4>Availability</h4><span>▾</span></div>
          <label class="filter-option">
            <input type="checkbox" name="availability[]" value="in_stock"
              {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}>
            Stok Tersedia
          </label>
          <label class="filter-option">
            <input type="checkbox" name="availability[]" value="sold_out"
              {{ in_array('sold_out', request('availability', [])) ? 'checked' : '' }}>
            Sold Out
          </label>
        </div>

        <button type="submit" class="btn btn-primary btn-ripple" style="width:100%;">Terapkan Filter</button>
      </aside>

      <!-- ===== PRODUCT GRID ===== -->
      <div>
        <div class="grid-head">
          <div class="sort-wrap">
            <select class="sort-select" name="sort" id="sortSelect">
              <option value="newest" {{ request('sort','newest')=='newest'?'selected':'' }}>Newest</option>
              <option value="bestseller" {{ request('sort')=='bestseller'?'selected':'' }}>Best Seller</option>
              <option value="price-asc" {{ request('sort')=='price-asc'?'selected':'' }}>Price: Low to High</option>
              <option value="price-desc" {{ request('sort')=='price-desc'?'selected':'' }}>Price: High to Low</option>
              <option value="az" {{ request('sort')=='az'?'selected':'' }}>A–Z</option>
            </select>
          </div>
          <div class="view-toggle">
            <button type="button" class="active" aria-label="Grid 4 kolom">▦</button>
            <button type="button" aria-label="Grid 2 kolom">▥</button>
          </div>
        </div>

        <div class="products-grid" id="productsGrid">
          @forelse ($products as $p)
            
            <a href="{{ route('product.detail', $p->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit;">
              <div class="product-photo">
                
                <img src="{{ $p->cover_image ? asset('images/'.$p->cover_image) : 'https://picsum.photos/seed/'.$p->id.'/400/400' }}" alt="{{ $p->name }}">
                
                @if ($p->featured)
                  <span class="product-badge">New</span>
                @elseif ($p->stock <= 0)
                  <span class="product-badge sale">Sold Out</span>
                @endif
                
                <button class="wishlist-mini" aria-label="Wishlist" data-id="{{ $p->id }}" onclick="event.preventDefault();">🤍</button>
              
              </div>
              <div class="product-info-sm">
                <span class="cat">{{ $p->category->name ?? '-' }}</span>
                <h4>{{ $p->name }}</h4>
                <div class="product-row">
                  <span>
                    <!-- PENGHITUNGAN & FORMAT MATA UANG OTOMATIS -->
                    <span class="price">
                        {{ $currentSymbol }} 
                        {{ $currency === 'IDR' 
                            ? number_format($p->price, 0, ',', '.') 
                            : number_format($p->price * $currentRate, 2, '.', ',') 
                        }}
                    </span>
                  </span>
                </div>
              </div>
            </a>
            
          @empty
            <p>Belum ada produk yang cocok dengan filter ini.</p>
          @endforelse
        </div>

        <div class="pagination" id="pagination">
          {{ $products->onEachSide(1)->links('pagination.custom') }}
        </div>
      </div>

    </div>
  </form>
</div>
@endsection