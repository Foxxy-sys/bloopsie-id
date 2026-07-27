@extends('layouts.app')

@push('styles')
    @vite(['resources/css/contact.css'])
@endpush

@push('scripts')
    @vite(['resources/js/contact.js'])
@endpush

@section('title', 'Contact Us — Bloopsie.id')

@section('content')
<div class="wrap">
  <div class="breadcrumb"><a href="{{ route('home') }}">Home</a> / <span>Contact</span></div>
  
  <section class="contact-hero">
    <span class="eyebrow">Let's Connect</span>
    <h1>Say Hello To <em>Bloopsie!</em></h1>
    <p>Punya pertanyaan tentang produk, kolaborasi, atau sekadar ingin menyapa? Kami selalu senang membaca pesan darimu.</p>
  </section>
</div>

<div class="torn-sm"></div>

<section class="contact-section">
  <div class="wrap contact-layout">
    
    <!-- LEFT COLUMN: Info Cards -->
    <div class="contact-info">
      
      <div class="info-card">
        <div class="info-icon">✉️</div>
        <div class="info-text">
          <h4>Email Kami</h4>
          <p>Untuk pertanyaan umum & kolaborasi</p>
          <a href="mailto:hello@bloopsie.id">hello@bloopsie.id</a>
        </div>
      </div>

      <div class="info-card">
        <div class="info-icon">📷</div>
        <div class="info-text">
          <h4>Instagram</h4>
          <p>Tag kami di jurnalmu!</p>
          <a href="#">@bloopsie.id</a>
        </div>
      </div>

      <div class="info-card">
        <div class="info-icon">🛍️</div>
        <div class="info-text">
          <h4>Shopee Store</h4>
          <p>Tersedia juga via e-commerce</p>
          <a href="#">Shopee.co.id/bloopsie</a>
        </div>
      </div>

      <!-- Optional Map Aesthetic Placeholder -->
      <div class="map-container">
        <!-- Placeholder map image -->
        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&q=80&w=800" alt="Map Location">
        <div class="map-overlay">
          <span>📍 Bandung, Indonesia</span>
          <span style="font-size:0.8rem; font-weight:500; color:var(--text); opacity:0.8;">(Online Store Only)</span>
        </div>
      </div>

    </div>

    <!-- RIGHT COLUMN: Form -->
    <div class="contact-form-card">
      <h3>Kirim Pesan</h3>
      <p>Isi form di bawah ini dan tim Bloopsie akan membalas pesanmu dalam 1-2 hari kerja.</p>
      
      <form onsubmit="event.preventDefault(); alert('Pesan berhasil dikirim! Terima kasih.');">
        <div class="form-group">
          <label for="name">Nama Lengkap</label>
          <input type="text" id="name" placeholder="Misal: Anya" required>
        </div>
        
        <div class="form-group">
          <label for="email">Alamat Email</label>
          <input type="email" id="email" placeholder="nama@email.com" required>
        </div>
        
        <div class="form-group">
          <label for="subject">Subjek / Topik</label>
          <input type="text" id="subject" placeholder="Misal: Pertanyaan Pengiriman" required>
        </div>
        
        <div class="form-group">
          <label for="message">Pesanmu</label>
          <textarea id="message" placeholder="Tulis pesanmu di sini..." required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block" style="margin-top:10px;">Kirim Pesan 💌</button>
      </form>
    </div>

  </div>
</section>

<!-- FAQ -->
<section class="faq" id="faq">
    <div class="wrap">
        <div class="section-head">
            <h2>FAQ</h2>
        </div>
        <div class="faq-list">
            @include('components.faq-items')
        </div>
    </div>
</section>
@endsection