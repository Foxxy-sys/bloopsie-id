@extends('layouts.app')

@push('styles')
    @vite(['resources/css/profile.css'])
@endpush

@push('scripts')
    @vite(['resources/js/profile.js'])
@endpush

@section('title', 'My Profile — Bloopsie.id')

@section('content')

<!-- TOAST NOTIFICATION -->
<div class="toast" id="toastBox">
  <span style="font-size: 1.2rem;">✔</span> Profile Updated Successfully
</div>

<div class="wrap">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> / <span>My Account</span>
  </div>

  <div class="profile-wrapper">
    
    <!-- SIDEBAR KIRI -->
    <aside class="sidebar-card">
      <div class="user-brief">
        <div class="avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            @else
                {{ substr(Auth::user()->name, 0, 1) }}
            @endif
        </div>
        <div class="info">
          <h3>{{ Auth::user()->name }}</h3>
        </div>
      </div>
      
      <div class="sidebar-menu">
        <a href="{{ route('profile.edit') }}" class="active"><span class="icon">👤</span> Profile</a>
        <a href="#"><span class="icon">🤍</span> Wishlist</a>
        <a href="#"><span class="icon">📍</span> Addresses</a>
        <a href="#"><span class="icon">⚙️</span> Settings</a>
        
        <!-- LOGOUT LINK -->
        <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
            <span class="icon">🚪</span> Logout
        </a>
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
    </aside>

    <!-- KONTEN KANAN -->
    <main class="content-card">
      <div class="content-header">
        <div>
          <h2>My Profile</h2>
          <p>Manage your personal information.</p>
        </div>
        <div class="header-meta">
          <span>🕒 Last Updated {{ Auth::user()->updated_at->diffForHumans() }}</span>
        </div>
      </div>

      <form class="profile-form" id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" onsubmit="handleSave(event)">
        @csrf
        @method('PATCH')

        <div class="form-group full" style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <div class="avatar-preview" style="width: 72px; height: 72px; border-radius: 50%; background: var(--secondary); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--primary-dark); overflow: hidden; flex-shrink: 0; box-shadow: var(--shadow-sm);">
                @if(Auth::user()->avatar)
                    <img id="avatarImgPreview" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <span id="avatarTextPreview">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    <img id="avatarImgPreview" src="" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                @endif
            </div>
            <div>
                <label for="avatar" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem;">Pilih Foto Baru</label>
                <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;" onchange="previewImage(event)">
                <p style="font-size: 0.75rem; color: var(--muted); margin-top: 6px;">Format JPG, PNG. Maksimal 2MB.</p>
            </div>
        </div>
        
        <div class="form-group">
          <label for="firstName">Nama Depan</label>
          <input type="text" id="firstName" name="first_name" value="{{ explode(' ', Auth::user()->name)[0] }}" required>
        </div>
        
        <div class="form-group">
          <label for="lastName">Nama Belakang</label>
          <input type="text" id="lastName" name="last_name" value="{{ count(explode(' ', Auth::user()->name)) > 1 ? explode(' ', Auth::user()->name, 2)[1] : '' }}">
        </div>
        
        <div class="form-group full">
          <div class="email-header-row">
            <label for="email">
              Email 
              <span class="badge-verified">🔒 Verified</span>
            </label>
            <button type="button" class="btn-link">Change Email</button>
          </div>
          <input type="email" id="email" value="{{ Auth::user()->email }}" disabled style="opacity:0.6; cursor:not-allowed;" title="Silakan klik Change Email untuk mengubah">
        </div>
        
        <div class="form-group">
          <label for="phone">Nomor Telepon</label>
          <div class="phone-wrapper">
            <span class="phone-prefix">+62</span>
            <input type="tel" id="phone" name="phone" placeholder="81234567890" value="{{ ltrim(Auth::user()->phone ?? '', '062+') }}">
          </div>
        </div>
        
        <div class="form-group">
          <label for="birth_date">Tanggal Lahir</label>
          <input type="date" id="birth_date" name="birth_date" value="{{ Auth::user()->birth_date ? date('Y-m-d', strtotime(Auth::user()->birth_date)) : '' }}">
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary" id="saveBtn">
            <span id="btnText">Save Changes</span>
            <div class="spinner" id="btnSpinner"></div>
          </button>
        </div>

      </form>
    </main>

  </div>
</div>

@if (session('status') === 'profile-updated')
    <script>
        // 2. Fungsi untuk memunculkan Toast setelah Save
        document.addEventListener('DOMContentLoaded', function() {
            const toastBox = document.getElementById("toastBox");
            if (toastBox) {
                toastBox.classList.add("show");
                setTimeout(() => {
                    toastBox.classList.remove("show");
                }, 3000);
            }
        });
    </script>
@endif

@endsection