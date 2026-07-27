@extends('layouts.auth')

@push('styles')
    @vite(['resources/css/login.css'])
@endpush

@push('scripts')
    @vite(['resources/js/login.js'])
@endpush

@section('title', 'Login — Bloopsie')

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

<!-- LOGIN SECTION -->
<section class="auth-section">
  <div class="auth-card">
    
    <div class="auth-logo">
      <a href="{{ url('/') }}">
        <img src="{{ asset('images/Logo.jpeg') }}" alt="Bloopsie Logo">
      </a>
    </div>
    
    <h2>Welcome Back!</h2>
    <p class="subtitle">Senang melihatmu lagi. Yuk masuk ke akunmu.</p>
    
    <!-- 1. PERBAIKAN FORM (Gunakan method POST & arahkan ke route login) -->
    <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
      @csrf <!-- WAJIB ADA: Keamanan Laravel -->

      <!-- Input Email -->
      <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrapper">
          <span class="input-icon-left">📧</span>
          <!-- Tambahkan name="email" -->
          <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
        </div>
        @error('email')
            <span style="color: red; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
      </div>
      
      <!-- Input Password -->
      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
          <span class="input-icon-left">🔒</span>
          <!-- Tambahkan name="password" -->
          <input type="password" id="password" name="password" placeholder="••••••••" required>
          <button type="button" class="btn-show-pass" id="togglePass" onclick="togglePassword(this)" aria-label="Tampilkan password">👁️</button>
        </div>
        @error('password')
            <span style="color: red; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
        @enderror
      </div>
      
      <div class="auth-actions">
        <label class="remember">
          <input type="checkbox" name="remember"> Remember Me
        </label>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot">Lupa Password?</a>
        @endif
      </div>
      
      <button type="submit" class="btn btn-primary btn-block" id="loginBtn">
        <span id="btnText">Login 🌸</span>
        <div class="spinner" id="btnSpinner"></div>
      </button>
    </form>
    
    <div class="auth-divider">
      <span>atau</span>
    </div>
    
    <!-- 2. PERBAIKAN TOMBOL GOOGLE (Ubah jadi <a> href) -->
    <a href="{{ route('google.login') }}" class="btn btn-outline btn-block btn-google" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20px">
        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
      </svg>
      Lanjutkan dengan Google
    </a>
    
    <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
    
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