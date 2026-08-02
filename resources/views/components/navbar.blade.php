<header>
  <nav>
    <div class="logo-group">
      <img src="{{ asset('images/Logo.jpeg') }}" alt="Bloopsie logo">
      <span>Bloopsie</span>
    </div>
    <ul class="nav-links">
      <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
      <li><a href="{{ url('/shop') }}" class="{{ request()->is('shop') ? 'active' : '' }}">Shop</a></li>
      <li><a href="{{ url('/collections') }}" class="{{ request()->is('collections') ? 'active' : '' }}">Collections</a></li>
      <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a></li>
      <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
    </ul>
    <div class="nav-icons">
        
      <!-- BAGIAN CART YANG SUDAH DIPERBARUI -->
      <a href="{{ route('cart') }}" aria-label="Cart" style="background:none; border:none; font-size:1.05rem; position:relative; padding:6px; cursor:pointer; text-decoration:none; color:inherit;">
        🛍️<span></span>
      </a>
      <!-- ================================== -->

      <div class="account-wrap">
        <button aria-label="Account" id="accountBtn" aria-haspopup="true" aria-expanded="false">👤</button>
        <div class="account-menu" id="accountMenu">
          <a href="{{ route('profile.edit') }}">👋 My Account</a>
          <a href="{{ route('orders') }}">📦 My Orders</a>
          <div class="divider"></div>
          <!-- FORM LOGOUT -->
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" id="logoutBtn" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; padding: 8px 16px; font-family: inherit; font-size: inherit; color: inherit;">
              🚪 Logout
            </button>
          </form>
        </div>
      </div>
      <button class="burger" aria-label="Menu">☰</button>
    </div>
  </nav>
</header>