@extends('layouts.app')

@push('styles')
    @vite(['resources/css/home.css'])
@endpush

@push('scripts')
    @vite(['resources/js/home.js'])
@endpush

@section('title', 'Bloopsie.id — Handmade Happiness, Delivered')

@section('content')
<!-- ============ HERO ============ -->
<section class="hero" id="home">
  <div class="hero-inner">
    <div class="hero-copy reveal">
      <div class="hero-badge"><span class="dot"></span> August Collection — Pink Fairy is live</div>
      <h1>Handmade Happiness,<br><em>Delivered</em> To Your Mailbox.</h1>
      <p class="sub">Cute stationery, adorable stickers, and monthly collections designed to brighten your day — packed with love, one envelope at a time.</p>
      <div class="hero-ctas">
        <button class="btn btn-primary btn-ripple">Shop Collection</button>
        <button class="btn btn-outline">Explore Products</button>
      </div>
    </div>
    <div class="hero-visual reveal">
      <div class="hero-photo-frame">
        <img src="Images/Produk 1.jpeg" alt="Bloopsie August Collection">
      </div>
      <div class="sticker sticker-1"><img src="Images/Produk 3.jpeg" style="width:100%;height:100%;object-fit:cover;"></div>
      <div class="sticker sticker-2"><img src="Images/Produk 2.jpeg" style="width:100%;height:100%;object-fit:cover;"></div>
      <div class="washi" style="width:140px;top:12px;right:34%;transform:rotate(-8deg);"></div>
    </div>
  </div>
</section>
 
<div class="torn" style="background:var(--secondary);"></div>
 
<section class="collection" id="collection">
  <div class="wrap">
    <div class="collection-card reveal">
      <div class="collection-img">
        <img src="Images/Produk 1.jpeg" alt="August Collection - Pink Fairy">
        <div class="seal"><span class="num">20</span><span class="lbl">Days Left</span></div>
      </div>
      <div class="collection-body">
        <span class="eyebrow">Current Monthly Collection</span>
        <h3>August — <span>Pink Fairy</span></h3>
        <p>Setiap bulan, Bloopsie menghadirkan satu tema baru — mulai dari ilustrasi, warna, sampai packaging — supaya setiap koleksi terasa seperti surat cinta yang berbeda.</p>
        <div class="hero-ctas">
          <button class="btn btn-primary btn-ripple">Explore Collection</button>
        </div>
      </div>
    </div>
  </div>
</section>
 
<section class="about" id="about">
  <div class="about-inner">
    <div class="about-photo reveal">
      <img src="Images/Produk 3.jpeg" alt="Bloopsie Team">
    </div>
    <div class="about-text reveal">
      <span class="eyebrow">About Bloopsie</span>
      <h2>Small Things.<br><em>Big Happiness.</em></h2>
      <p>Bloopsie berawal dari mimpi sederhana: membuat setiap surat terasa lebih personal. Dari selembar sticker hingga sampul buku catatan, semuanya dirancang untuk jadi pengingat kecil bahwa seseorang memikirkanmu.</p>
      <p>Setiap paket dikemas dengan tangan, bukan mesin — karena bagi kami, cara sesuatu dikirim sama pentingnya dengan apa yang dikirim.</p>
      <div class="about-stats">
        <div><strong>12+</strong><span>Monthly Collections</span></div>
        <div><strong>3.400+</strong><span>Happy Mailboxes</span></div>
        <div><strong>18</strong><span>Negara Terjangkau</span></div>
      </div>
    </div>
  </div>
</section>
 
<section class="how">
  <div class="wrap">
    <div class="section-head reveal">
      <span class="eyebrow">How It Works</span>
      <h2>Dari Klik Sampai Amplop</h2>
    </div>
    <div class="steps">
      <div class="step reveal">
        <div class="step-icon">🛒</div>
        <h4>Choose</h4>
        <p>Pilih produk favoritmu dari koleksi bulan ini.</p>
      </div>
      <div class="step reveal">
        <div class="step-icon">💳</div>
        <h4>Checkout</h4>
        <p>Bayar dengan aman lewat berbagai metode pembayaran.</p>
      </div>
      <div class="step reveal">
        <div class="step-icon">🎀</div>
        <h4>Packed with Love</h4>
        <p>Setiap pesanan dikemas tangan dengan detail kecil.</p>
      </div>
      <div class="step reveal">
        <div class="step-icon">🌍</div>
        <h4>Delivered Worldwide</h4>
        <p>Sampai ke mailbox-mu, di mana pun kamu berada.</p>
      </div>
    </div>
  </div>
</section>
 
<section class="why">
  <div class="wrap">
    <div class="section-head reveal">
      <span class="eyebrow">Why Choose Bloopsie</span>
      <h2>Dibuat Dengan Perhatian</h2>
    </div>
    <div class="why-grid">
      <div class="why-card reveal"><div class="icon">📦</div><h4>Carefully Packed</h4><p>Setiap paket dibungkus tangan dengan washi tape dan kartu ucapan kecil.</p></div>
      <div class="why-card reveal"><div class="icon">🌎</div><h4>Worldwide Shipping</h4><p>Bloopsie sudah terbang ke lebih dari 18 negara di dunia.</p></div>
      <div class="why-card reveal"><div class="icon">🎨</div><h4>Original Artwork</h4><p>Semua ilustrasi digambar sendiri oleh tim kecil kami.</p></div>
      <div class="why-card reveal"><div class="icon">💖</div><h4>Made With Love</h4><p>Bukan sekadar produk — tapi cerita kecil di setiap kemasan.</p></div>
    </div>
  </div>
</section>
 
<section id="reviews">
  <div class="wrap">
    <div class="section-head reveal">
      <span class="eyebrow">Customer Reviews</span>
      <h2>Cerita Dari Mailbox Mereka</h2>
    </div>
  </div>
  <div class="wrap">
    <div class="reviews-track reveal">
      <div class="review-card">
        <div class="review-top"><div class="avatar">A</div><div><strong>Aline P.</strong><span>🇮🇩 Indonesia</span></div></div>
        <p>"Packaging-nya bikin aku senyum-senyum sendiri pas buka paketnya. Detailnya luar biasa!"</p>
        <div class="stars">★★★★★</div>
      </div>
      <div class="review-card">
        <div class="review-top"><div class="avatar">M</div><div><strong>Mei L.</strong><span>🇸🇬 Singapore</span></div></div>
        <p>"Setiap bulan aku selalu nunggu koleksi barunya. Selalu beda dan selalu lucu."</p>
        <div class="stars">★★★★★</div>
      </div>
      <div class="review-card">
        <div class="review-top"><div class="avatar">R</div><div><strong>Raka S.</strong><span>🇮🇩 Indonesia</span></div></div>
        <p>"Kualitas kertasnya premium banget, worth it buat koleksi stationery-ku."</p>
        <div class="stars">★★★★★</div>
      </div>
      <div class="review-card">
        <div class="review-top"><div class="avatar">J</div><div><strong>Julia T.</strong><span>🇲🇾 Malaysia</span></div></div>
        <p>"Pengiriman internasionalnya cepat dan aman. Bakal repeat order terus!"</p>
        <div class="stars">★★★★★</div>
      </div>
    </div>
  </div>
</section>
 
<section id="instagram" style="padding-top:0;">
  <div class="wrap">
    <div class="section-head reveal">
      <span class="eyebrow">@bloopsie.id</span>
      <h2>Instagram Gallery</h2>
    </div>
  </div>
  <div class="insta-grid reveal">
    <div class="insta-item"><img src="images/Produk 1.jpeg" alt="Instagram post 1"></div>
    <div class="insta-item"><img src="images/Produk 2.jpeg" alt="Instagram post 2"></div>
    <div class="insta-item"><img src="images/Produk 3.jpeg" alt="Instagram post 3"></div>
    <div class="insta-item"><img src="images/Produk 4.jpeg" alt="Instagram post 4"></div>
    <div class="insta-item"><img src="images/Produk 5.jpeg" alt="Instagram post 5"></div>
  </div>
</section>
 
<section>
  <div class="wrap">
    <div class="newsletter reveal">
      <h2>Join Our Happy Mail 💌</h2>
      <p>Dapatkan kabar setiap ada koleksi bulanan baru — langsung ke inbox-mu.</p>
      <form class="nl-form" onsubmit="return false;">
        <input type="email" placeholder="nama@email.com" required aria-label="Email">
        <button class="btn btn-primary" type="submit">Subscribe</button>
      </form>
    </div>
  </div>
</section>
 
<section id="faq">
  <div class="wrap">
    <div class="section-head reveal">
      <span class="eyebrow">FAQ</span>
      <h2>Pertanyaan Yang Sering Ditanyakan</h2>
    </div>
    <div class="faq-list reveal">
      <details open>
        <summary>Apakah Bloopsie kirim ke luar negeri?</summary>
        <p>Ya! Bloopsie sudah mengirim ke lebih dari 18 negara. Ongkos kirim dihitung otomatis saat checkout.</p>
      </details>
      <details>
        <summary>Kapan koleksi bulanan baru dirilis?</summary>
        <p>Setiap tanggal 1, koleksi baru akan tayang di halaman utama beserta tema dan countdown-nya.</p>
      </details>
      <details>
        <summary>Apakah aku bisa custom packaging?</summary>
        <p>Untuk saat ini packaging mengikuti tema bulan berjalan, tapi kamu bisa tambahkan pesan personal saat checkout.</p>
      </details>
      <details>
        <summary>Metode pembayaran apa saja yang tersedia?</summary>
        <p>Transfer bank, e-wallet, QRIS, dan kartu kredit/debit — semua diproses aman melalui payment gateway.</p>
      </details>
    </div>
  </div>
</section>
 
<section>
  <div class="wrap">
    <div class="cta-banner reveal">
      <h2>Ready To Start Collecting?</h2>
      <p>Explore this month's collection sebelum koleksinya habis.</p>
      <button class="btn btn-primary btn-ripple">Shop Now</button>
    </div>
  </div>
</section>
@endsection