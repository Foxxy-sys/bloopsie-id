@extends('layouts.app')

@push('styles')
    @vite(['resources/css/about.css'])
@endpush

@push('scripts')
    @vite(['resources/js/about.js'])
@endpush

@section('title', 'About Bloopsie — Our Story')

@section('content')
<div class="wrap">
  <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> / <span>About</span></div>

<section class="about-hero">
  <div class="wrap hero-inner">
    <div class="hero-text">
      <span class="eyebrow">About Bloopsie</span>
      <h1>Made With Love,<br>Created For <em>Happy Mail.</em></h1>
      <p>Setiap ilustrasi kami dimulai dari secarik ide, lalu berubah menjadi karya kecil yang siap menghiasi harimu.</p>
      <a href="{{ route('home') }}#collection" class="btn btn-primary btn-ripple">Explore Collections</a>
    </div>
    <div class="hero-img">
      <img src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&q=80&w=800" alt="Workspace">
    </div>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="timeline">
      <div class="tl-flow">
        <div class="tl-item">
          <div class="tl-year">2023</div>
          <div class="tl-desc">Awal mula mimpi Bloopsie dimulai</div>
        </div>
        <div class="tl-arrow">↓</div>
        <div class="tl-item">
          <div class="tl-year">2024</div>
          <div class="tl-desc">Koleksi pertama resmi rilis!</div>
        </div>
        <div class="tl-arrow">↓</div>
        <div class="tl-item">
          <div class="tl-year">2025</div>
          <div class="tl-desc">Stiker kita mulai keliling dunia (Worldwide Shipping)</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="creator">
  <div class="wrap creator-inner">
    <div class="creator-photo">
      <img src="https://images.unsplash.com/photo-1544717302-de2939b7ef71?auto=format&fit=crop&q=80&w=800" alt="Meet the creator">
    </div>
    <div class="creator-text">
      <span class="eyebrow">Hai, Salam Kenal!</span>
      <h2>Meet The Creator</h2>
      <p>Halo semuanya! Aku Anya, si pemimpi dan tangan di balik setiap coretan Bloopsie. Kalau tidak sedang menggambar di iPad dengan segelas matcha hangat di sebelahku, aku biasanya sibuk menata ulang buku jurnalku.</p>
      <p>Terima kasih sudah mengadopsi karya-karyaku. Setiap pesanan yang masuk selalu membuatku tersenyum lebar. <em>You guys are the best!</em></p>
    </div>
  </div>
</section>

<section class="process">
  <div class="wrap">
    <div class="section-head">
      <h2>Behind The Design</h2>
      <p>Penasaran gimana caranya sebuah ide abstrak berubah menjadi stiker lucu di tanganmu?</p>
    </div>
    <div class="process-list">
      <!-- Step 01 -->
      <div class="process-step">
        <div class="step-img"><img src="{{ asset('Images/spring.jpeg') }}" alt="Sketching"></div>
        <div class="step-text"><div class="step-num">01</div><h3>✏️ Sketch</h3><p>Dimulai dari mencari inspirasi warna dan moodboard bulanan.</p></div>
      </div>
      <!-- Step 02 -->
      <div class="process-step">
        <div class="step-img"><img src="{{ asset('Images/print.jpeg') }}" alt="Printing"></div>
        <div class="step-text"><div class="step-num">02</div><h3>🖨️ Printing</h3><p>Dicetak di atas kertas khusus dengan presisi mesin potong tinggi.</p></div>
      </div>
      <!-- Step 03 -->
      <div class="process-step">
        <div class="step-img"><img src="{{ asset('Images/package.jpeg') }}" alt="Packaging"></div>
        <div class="step-text"><div class="step-num">03</div><h3>📦 Packaging</h3><p>Dibungkus manual dengan kartu ucapan personal.</p></div>
      </div>
    </div>
  </div>
</section>

<section class="faq" id="faq">
  <div class="wrap">
    <div class="section-head">
      <h2>Yang Sering Ditanyain</h2>
    </div>
    <div class="faq-list">
       <!-- FAQ Details sama seperti prototipe -->
       @include('components.faq-items')
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="wrap">
    <div class="cta-banner">
      <h2>Ready To Discover This Month's Collection?</h2>
      <a href="{{ route('shop') }}"><button class="btn btn-primary">Explore Collection</button></a>
    </div>
  </div>
</section>
@endsection