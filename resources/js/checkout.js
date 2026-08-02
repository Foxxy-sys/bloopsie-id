let currentShipping = 15000;
let subtotal = 0; 

// FUNGSI BARU: Format harga dinamis menyesuaikan mata uang
function formatCurrency(angka) {
    // Ambil data dari tag <script> di HTML, fallback ke IDR jika error
    const sym = window.appSymbol || "Rp";
    const curr = window.appCurrency || "IDR";
    const rate = window.appRate || 1;

    if (curr === "IDR") {
        return sym + " " + angka.toLocaleString("id-ID");
    } else {
        const converted = angka * rate;
        // Format standar barat (2 desimal)
        return sym + " " + converted.toLocaleString("en-US", {
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2
        });
    }
}

function updateTotal() {
    const baseSubtotalEl = document.getElementById("baseSubtotal");
    if(baseSubtotalEl) {
        subtotal = parseInt(baseSubtotalEl.getAttribute("data-value")) || 0;
    }

    const total = subtotal + currentShipping;
    
    const shippingDisplay = document.getElementById("shippingDisplay");
    if(shippingDisplay) shippingDisplay.innerText = formatCurrency(currentShipping);
    
    const totalDisplay = document.getElementById("totalDisplay");
    if(totalDisplay) totalDisplay.innerText = formatCurrency(total);
}

window.selectOption = function(element, groupName, price = null) {
    const cards = document.querySelectorAll(`input[name="${groupName}"]`);
    cards.forEach((input) => {
        const card = input.closest(".selection-card");
        if(card) card.classList.remove("active");
    });

    if(element) element.classList.add("active");

    const radioBtn = element.querySelector('input[type="radio"]');
    if(radioBtn) radioBtn.checked = true;

    if (groupName === "courier" && price !== null) {
        currentShipping = parseInt(price);
        updateTotal(); // JS akan menghitung ulang dan memformat dengan mata uang yang benar
    }
}

window.handleCountryChange = function() {
    const countryEl = document.getElementById("country");
    if(!countryEl) return;
    const country = countryEl.value;

    const localCouriers = document.getElementById("local-couriers");
    const intlCouriers = document.getElementById("intl-couriers");
    const localPayments = document.getElementById("local-payments");
    const intlPayments = document.getElementById("intl-payments");

    // Jika negara = ID, tampilkan pengiriman & bayar lokal (dan sebaliknya)
    if (country === "ID") {
        if(localCouriers) localCouriers.style.display = "grid";
        if(intlCouriers) intlCouriers.style.display = "none";
        if(localPayments) localPayments.style.display = "grid";
        if(intlPayments) intlPayments.style.display = "none";

        if(localCouriers) {
            const firstLocalCourier = localCouriers.querySelector(".selection-card");
            if(firstLocalCourier) firstLocalCourier.click();
        }
        if(localPayments) {
            const firstLocalPayment = localPayments.querySelector(".selection-card");
            if(firstLocalPayment) firstLocalPayment.click();
        }
    } else {
        if(localCouriers) localCouriers.style.display = "none";
        if(intlCouriers) intlCouriers.style.display = "grid";
        if(localPayments) localPayments.style.display = "none";
        if(intlPayments) intlPayments.style.display = "grid";

        if(intlCouriers) {
            const firstIntlCourier = intlCouriers.querySelector(".selection-card");
            if(firstIntlCourier) firstIntlCourier.click();
        }
        if(intlPayments) {
            const firstIntlPayment = intlPayments.querySelector(".selection-card");
            if(firstIntlPayment) firstIntlPayment.click();
        }
    }
}

window.placeOrder = function(btn) {
    const originalText = btn.innerHTML;
    btn.innerHTML = "Processing... ⏳";
    btn.disabled = true;

    setTimeout(() => {
        btn.innerHTML = "Order Success! 🎉";
        btn.style.background = "var(--success)";
        btn.style.color = "#1b5e20";
        btn.style.boxShadow = "none";
    }, 2000);
}

document.addEventListener('DOMContentLoaded', () => {
    handleCountryChange();

    updateTotal();
    
    const accountBtn = document.getElementById("accountBtn");
    const accountMenu = document.getElementById("accountMenu");

    if (accountBtn && accountMenu) {
        accountBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            const isOpen = accountMenu.classList.toggle("open");
            accountBtn.setAttribute("aria-expanded", isOpen);
        });

        document.addEventListener("click", (e) => {
            if (!accountMenu.contains(e.target) && e.target !== accountBtn) {
                accountMenu.classList.remove("open");
                accountBtn.setAttribute("aria-expanded", "false");
            }
        });
    }
});

// Fungsi untuk memproses pesanan saat tombol Place Order diklik
window.placeOrder = function(btn) {
    // 1. Ubah tombol menjadi status loading agar terlihat profesional
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span style="display: flex; align-items: center; justify-content: center; gap: 8px;">Processing... ⏳</span>';
    btn.disabled = true;

    // 2. Cari tahu metode pembayaran apa yang sedang dipilih oleh user
    const selectedPayment = document.querySelector('input[name="payment"]:checked').value;

    // 3. Beri jeda simulasi proses ke server (1.5 detik), lalu lempar ke halaman Payment
    setTimeout(() => {
        // Redirect ke halaman payment sambil membawa data metode pembayarannya
        window.location.href = `/payment?method=${selectedPayment}`;
    }, 1500);
}