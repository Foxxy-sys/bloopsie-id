@extends('layouts.app')

@push('styles')
    @vite(['resources/css/checkout.css'])
@endpush

@push('scripts')
    @vite(['resources/js/checkout.js'])
@endpush

@section('title', 'Checkout — Bloopsie.id')

@section('content')

<!-- ========================================== -->
<!-- SISTEM KONVERSI MATA UANG (DYNAMIC CURRENCY) -->
<!-- ========================================== -->
@php
    $currency = session('currency', 'IDR');
    
    $rates = [
        'IDR' => 1, 'USD' => 0.000064, 'SGD' => 0.000085, 'MYR' => 0.00030, 'AUD' => 0.00010,
    ];
    $symbols = [
        'IDR' => 'Rp', 'USD' => '$', 'SGD' => 'S$', 'MYR' => 'RM', 'AUD' => 'A$',
    ];

    $currentRate = $rates[$currency] ?? 1;
    $currentSymbol = $symbols[$currency] ?? 'Rp';

    // Helper fungsi untuk format harga di blade
    if (!function_exists('formatPrice')) {
        function formatPrice($price, $currency, $currentRate, $currentSymbol) {
            if ($currency === 'IDR') {
                return $currentSymbol . ' ' . number_format($price, 0, ',', '.');
            }
            return $currentSymbol . ' ' . number_format($price * $currentRate, 2, '.', ',');
        }
    }
@endphp
<!-- ========================================== -->

<!-- Kirim data mata uang ke Javascript -->
<script>
    window.appCurrency = "{{ $currency }}";
    window.appSymbol = "{{ $currentSymbol }}";
    window.appRate = {{ $currentRate }};
</script>

<div class="wrap">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> / <a href="{{ route('cart') }}">Cart</a> / <span>Checkout</span>
    </div>

    <div class="page-header">
        <h1>Checkout</h1>
        <div style="margin-top: 10px; font-size: 0.85rem; color: var(--muted); background: var(--secondary); display: inline-block; padding: 4px 12px; border-radius: 20px;">
            Prices displayed in: <strong>{{ $currency }}</strong>
        </div>
    </div>

    <div class="checkout-wrapper">
      
      <!-- KOLOM KIRI (FORMS) -->
      <div class="checkout-form-container">
        
        <!-- SECTION 1: Shipping Address -->
        <div class="checkout-section">
          <h2><span class="step">1</span> Shipping Address</h2>
          
          <div class="form-group full">
            <label for="country">Country / Region</label>
            @php $userCountry = session('country_code', 'ID'); @endphp
            <select id="country" name="country" onchange="handleCountryChange()">
              <option value="ID" {{ $userCountry == 'ID' ? 'selected' : '' }}>Indonesia</option>
              <option value="SG" {{ $userCountry == 'SG' ? 'selected' : '' }}>Singapore</option>
              <option value="MY" {{ $userCountry == 'MY' ? 'selected' : '' }}>Malaysia</option>
              <option value="US" {{ $userCountry == 'US' ? 'selected' : '' }}>United States</option>
              <option value="AU" {{ $userCountry == 'AU' ? 'selected' : '' }}>Australia</option>
            </select>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="fname">First Name</label>
              <input type="text" id="fname" name="first_name" value="{{ explode(' ', Auth::user()->name ?? '')[0] }}" placeholder="Jane">
            </div>
            <div class="form-group">
              <label for="lname">Last Name</label>
              <input type="text" id="lname" name="last_name" value="{{ (Auth::check() && count(explode(' ', Auth::user()->name)) > 1) ? explode(' ', Auth::user()->name, 2)[1] : '' }}" placeholder="Doe">
            </div>
          </div>

          <div class="form-group full">
            <label for="address">Street Address</label>
            <input type="text" id="address" name="address" placeholder="Jl. Sudirman No. 123, Apartemen Ceria">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="city">City</label>
              <input type="text" id="city" name="city" placeholder="Jakarta Selatan">
            </div>
            <div class="form-group">
              <label for="zip">Postal Code</label>
              <input type="text" id="zip" name="postal_code" placeholder="12190">
            </div>
          </div>

          <div class="form-group full">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="+62 812 3456 7890">
          </div>
        </div>

        <!-- SECTION 2: Courier / Shipping Method -->
        <div class="checkout-section">
          <h2><span class="step">2</span> Shipping Method</h2>
          
          <!-- Kurir Lokal -->
          <div class="selection-grid" id="local-couriers">
            <label class="selection-card active" onclick="selectOption(this, 'courier', 15000)">
              <input type="radio" name="courier" value="reguler" checked>
              <div class="sc-content">
                <div class="sc-icon">📦</div>
                <div class="sc-details">
                  <span class="sc-title">Reguler Shipping</span>
                  <span class="sc-desc">2-3 Business Days</span>
                </div>
              </div>
              <span class="sc-price">{{ formatPrice(15000, $currency, $currentRate, $currentSymbol) }}</span>
              <div class="check-circle"></div>
            </label>

            <label class="selection-card" onclick="selectOption(this, 'courier', 25000)">
              <input type="radio" name="courier" value="express">
              <div class="sc-content">
                <div class="sc-icon">⚡</div>
                <div class="sc-details">
                  <span class="sc-title">Express Shipping</span>
                  <span class="sc-desc">1 Business Day</span>
                </div>
              </div>
              <span class="sc-price">{{ formatPrice(25000, $currency, $currentRate, $currentSymbol) }}</span>
              <div class="check-circle"></div>
            </label>
          </div>

          <!-- Kurir Internasional -->
          <div class="selection-grid" id="intl-couriers" style="display: none;">
            <label class="selection-card" onclick="selectOption(this, 'courier', 250000)">
              <input type="radio" name="courier" value="dhl">
              <div class="sc-content">
                <div class="sc-icon">✈️</div>
                <div class="sc-details">
                  <span class="sc-title">International Standard</span>
                  <span class="sc-desc">5-10 Business Days</span>
                </div>
              </div>
              <span class="sc-price">{{ formatPrice(250000, $currency, $currentRate, $currentSymbol) }}</span>
              <div class="check-circle"></div>
            </label>
          </div>
        </div>

        <!-- SECTION 3: Payment Method -->
        <div class="checkout-section">
          <h2><span class="step">3</span> Payment Method</h2>
          <p style="font-size:0.9rem; color:var(--muted); margin-bottom: 16px; margin-top:-10px;">All transactions are secure and encrypted.</p>
          
          <!-- Pembayaran Lokal -->
          <div class="selection-grid" id="local-payments">
            <label class="selection-card active" onclick="selectOption(this, 'payment')">
              <input type="radio" name="payment" value="qris" checked>
              <div class="sc-content">
                <div class="sc-icon">📱</div>
                <div class="sc-details">
                  <span class="sc-title">QRIS</span>
                  <span class="sc-desc">Scan with any e-wallet or banking app</span>
                </div>
              </div>
              <div class="check-circle"></div>
            </label>

            <label class="selection-card" onclick="selectOption(this, 'payment')">
              <input type="radio" name="payment" value="gopay">
              <div class="sc-content">
                <div class="sc-icon" style="color: #00AED6; font-weight: 800; font-size:0.9rem;">G</div>
                <div class="sc-details">
                  <span class="sc-title">Gopay</span>
                  <span class="sc-desc">Pay instantly using Gojek app</span>
                </div>
              </div>
              <div class="check-circle"></div>
            </label>

            <label class="selection-card" onclick="selectOption(this, 'payment')">
              <input type="radio" name="payment" value="va">
              <div class="sc-content">
                <div class="sc-icon">🏦</div>
                <div class="sc-details">
                  <span class="sc-title">Virtual Account (VA)</span>
                  <span class="sc-desc">BCA, Mandiri, BNI, BRI</span>
                </div>
              </div>
              <div class="check-circle"></div>
            </label>
            
            <label class="selection-card" onclick="selectOption(this, 'payment')">
              <input type="radio" name="payment" value="transfer">
              <div class="sc-content">
                <div class="sc-icon">🏧</div>
                <div class="sc-details">
                  <span class="sc-title">Manual Bank Transfer</span>
                  <span class="sc-desc">Upload proof of payment required</span>
                </div>
              </div>
              <div class="check-circle"></div>
            </label>
          </div>

          <!-- Pembayaran Internasional & PayPal -->
          <div class="selection-grid" id="intl-payments" style="display: none;">
            <label class="selection-card" onclick="selectOption(this, 'payment')">
              <input type="radio" name="payment" value="paypal">
              <div class="sc-content">
                <div class="sc-icon" style="color: #003087; font-weight: 800; font-style: italic;">P</div>
                <div class="sc-details">
                  <span class="sc-title">PayPal</span>
                  <span class="sc-desc">Pay safely with your PayPal account</span>
                </div>
              </div>
              <div class="check-circle"></div>
            </label>
          </div>

        </div>
      </div>

      <!-- SIDEBAR KANAN (SUMMARY) -->
      <aside class="summary-card">
        <h3>Order Summary</h3>
        
        <!-- LOOPING DATA DARI DATABASE -->
        @foreach($cartItems as $item)
        <div class="mini-cart-item">
          <img src="{{ $item->product->cover_image ? asset('images/' . $item->product->cover_image) : 'https://picsum.photos/seed/'.$item->product->id.'/150/150' }}" alt="{{ $item->product->name }}" class="mini-item-img">
          <div class="mini-item-details">
            <div class="mini-item-title">{{ $item->product->name }}</div>
            <div class="mini-item-meta">
              <span>Qty: {{ $item->quantity }}</span>
              <span class="mini-item-price">{{ formatPrice($item->product->price, $currency, $currentRate, $currentSymbol) }}</span>
            </div>
          </div>
        </div>
        @endforeach

        <div style="margin-top: 24px;">
          <div class="summary-row">
            <span>Subtotal</span>
            <!-- Biarkan data-value dalam Rupiah asli untuk dihitung JS -->
            <span class="val" id="baseSubtotal" data-value="{{ $subtotal }}">
                {{ formatPrice($subtotal, $currency, $currentRate, $currentSymbol) }}
            </span>
          </div>
          <div class="summary-row">
            <span>Shipping</span>
            <!-- Default Reguler (15000), ini akan dioverride oleh JS -->
            <span class="val" id="shippingDisplay">
                {{ formatPrice(15000, $currency, $currentRate, $currentSymbol) }}
            </span>
          </div>
          
          <div class="summary-row total">
            <span>Total</span>
            <span class="val" id="totalDisplay">
                {{ formatPrice($subtotal + 15000, $currency, $currentRate, $currentSymbol) }}
            </span>
          </div>
          
          <button class="btn btn-primary btn-block" style="font-size:1.05rem;" onclick="placeOrder(this)">
            Place Order
          </button>
          
          <p style="text-align:center; font-size:0.75rem; color:var(--muted); margin-top:20px; line-height: 1.4;">
            By placing your order, you agree to Bloopsie's <br><a href="#" style="text-decoration: underline;">Terms of Service</a> and <a href="#" style="text-decoration: underline;">Privacy Policy</a>.
          </p>
        </div>
      </aside>

    </div>
</div>
@endsection