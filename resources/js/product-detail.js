// --- PRODUCT DETAIL SCRIPT ---
window.swapImg = function (el, src) {
    document.getElementById("mainImg").src = src;
    document
        .querySelectorAll(".gallery-thumbs img")
        .forEach((i) => i.classList.remove("active"));
    el.classList.add("active");
};

// --- PERUBAHAN ADA DI BAGIAN INI ---
let qty = 1;
window.changeQty = function (delta) {
    qty = Math.max(1, qty + delta); // Minimal qty adalah 1
    
    // 1. Update teks angka di layar (HTML)
    document.getElementById("qtyVal").textContent = qty;
    
    // 2. Update nilai di dalam hidden input form agar ikut terkirim ke sistem
    let qtyInput = document.getElementById("qtyInput");
    if(qtyInput) {
        qtyInput.value = qty;
    }
};
// ------------------------------------

document.querySelectorAll(".tab-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        document
            .querySelectorAll(".tab-btn")
            .forEach((b) => b.classList.remove("active"));
        document
            .querySelectorAll(".tab-panel")
            .forEach((p) => p.classList.remove("active"));
        btn.classList.add("active");
        document.getElementById(btn.dataset.tab).classList.add("active");
    });
});

// --- NAVBAR SCRIPT (PROFIL & MENU) ---
document.addEventListener('DOMContentLoaded', () => {
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