@extends('layouts.auth')

@push('styles')
    @vite(['resources/css/register.css'])
@endpush

@push('scripts')
    @vite(['resources/js/register.js'])
@endpush

@section('title', 'Register — Bloopsie')

@section('content')
<!-- DEKORASI BACKGROUND (Super Tipis 6% & Blur) -->
<div class="bg-decor">
  <div class="bg-icon icon-1">⭐</div>
  <div class="bg-icon icon-2">🌸</div>
  <div class="bg-icon icon-3">❤️</div>
  <div class="bg-icon icon-4">✉️</div>
  <div class="bg-icon icon-5">🌸</div>
  <div class="bg-icon icon-6">⭐</div>
</div>

<!-- REGISTER SECTION -->
<section class="auth-section">
  <div class="auth-card">
    
    <div class="auth-logo">
      <a href="{{ route('home') }}">
        <img src="{{ asset('images/Logo.jpeg') }}" alt="Bloopsie Logo">
      </a>
    </div>
    
    <h2>Join Bloopsie Club</h2>
    <p class="subtitle">Dapatkan akses ke koleksi bulanan, wishlist, dan riwayat pesananmu.</p>
    
    <!-- UPDATE: Menggunakan form standar Laravel -->
    <form method="POST" action="{{ route('register') }}" class="auth-form" id="regForm">
      @csrf

      <!-- 1. Nama Lengkap -->
      <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <div class="input-wrapper">
          <span class="input-icon-left">👤</span>
          <input type="text" id="name" name="name" placeholder="Misal: Anya" value="{{ old('name') }}" required autofocus>
        </div>
        @error('name')
            <span style="color: red; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
      </div>

      <!-- 2. Email -->
      <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrapper">
          <span class="input-icon-left">📧</span>
          <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
        </div>
        @error('email')
            <span style="color: red; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
      </div>

      <!-- 3. Nomor HP (Opsional menyesuaikan tabel database) -->
      <div class="form-group">
        <label for="phone">Nomor HP (Opsional)</label>
        <div class="input-wrapper">
          <span class="input-icon-left">📱</span>
          <input type="text" id="phone" name="phone" placeholder="0812..." value="{{ old('phone') }}">
        </div>
        @error('phone')
            <span style="color: red; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
      </div>
      
      <!-- 4. Password -->
      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
          <span class="input-icon-left">🔒</span>
          <!-- name harus 'password' -->
          <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
          <button type="button" class="btn-show-pass" onclick="togglePassword(this)" aria-label="Tampilkan password">👁️</button>
        </div>
        @error('password')
            <span style="color: red; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
      </div>

      <!-- 5. Confirm Password -->
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <div class="input-wrapper">
          <span class="input-icon-left">🔒</span>
          <!-- name harus 'password_confirmation' agar validasi confirmed Laravel bekerja -->
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
          <button type="button" class="btn-show-pass" onclick="togglePassword(this)" aria-label="Tampilkan password">👁️</button>
        </div>
      </div>
      
      <!-- 6. Checkbox -->
      <div class="auth-actions">
        <label class="remember">
          <!-- Tambahkan id="terms" -->
          <input type="checkbox" id="terms" name="terms" required> Saya setuju dengan Syarat & Ketentuan
        </label>
      </div>
      
      <!-- 7. Register Button -->
      <!-- Tambahkan atribut disabled secara default -->
      <button type="submit" class="btn btn-primary btn-block" id="regBtn" disabled style="opacity: 0.5; cursor: not-allowed; transition: 0.3s;">
        <span id="btnText">Register 🌸</span>
        <div class="spinner" id="btnSpinner"></div>
      </button>
    </form> 
    
    <div class="auth-divider">
      <span>atau</span>
    </div>
    
    <button type="button" class="btn btn-outline btn-block btn-google">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20px">
        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
      </svg>
      Daftar dengan Google
    </button>
    
    <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    
  </div>
</section>

<!-- FOOTER MINI -->
<footer>
  <div class="footer-links">
    <a href="#">Privacy Policy</a>
    <span class="footer-dot">•</span>
    <a href="#">Terms of Service</a>
    <span class="footer-dot">•</span>
    <span>© 2026 Bloopsie.id</span>
  </div>
</footer>
@endsection