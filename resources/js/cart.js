// 1. Ambil data dari Local Storage, jika kosong, gunakan nilai default (2 dan 1)
let item1Qty = localStorage.getItem('item1Qty') ? parseInt(localStorage.getItem('item1Qty')) : 2;
let item2Qty = localStorage.getItem('item2Qty') ? parseInt(localStorage.getItem('item2Qty')) : 1;

const item1Price = 35000;
const item2Price = 62000;
let isVoucherApplied = false;
let discountAmount = 0;

function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString("id-ID");
}

window.recalculateTotals = function() {
    let subtotal = 0;
    let itemCount = 0;

    if (document.getElementById("item-1")) {
        subtotal += item1Qty * item1Price;
        itemCount++;
    }
    if (document.getElementById("item-2")) {
        subtotal += item2Qty * item2Price;
        itemCount++;
    }

    document.getElementById("itemCount").innerText =
        `${itemCount} Item${itemCount !== 1 ? "s" : ""}`;
    document.getElementById("subtotalDisplay").innerText =
        formatRupiah(subtotal);

    if (isVoucherApplied && subtotal > 0) {
        discountAmount = subtotal * 0.1;
        document.getElementById("discountDisplay").innerText =
            "- " + formatRupiah(discountAmount);
    } else {
        discountAmount = 0;
        document.getElementById("discountRow").style.display = "none";
        isVoucherApplied = false;
    }

    let finalTotal = subtotal - discountAmount;
    document.getElementById("totalDisplay").innerText =
        formatRupiah(finalTotal);

    if (itemCount === 0) {
        document.getElementById("cartList").innerHTML =
            '<p style="text-align:center; color:var(--muted); padding: 40px 0;">Keranjang belanjamu kosong. Yuk <a href="/shop" style="color:var(--primary-dark); font-weight:700;">belanja sekarang!</a></p>';
    }
}

window.updateQty = function(elementId, change, price) {
    let qtySpan = document.getElementById(elementId);
    let currentQty = parseInt(qtySpan.innerText);
    let newQty = currentQty + change;

    if (newQty >= 1) {
        qtySpan.innerText = newQty;
        
        // Simpan perubahan Qty ke Local Storage
        if (elementId === "qty-1") {
            item1Qty = newQty;
            localStorage.setItem('item1Qty', newQty);
        }
        if (elementId === "qty-2") {
            item2Qty = newQty;
            localStorage.setItem('item2Qty', newQty);
        }
        
        window.recalculateTotals();
    }
}

window.removeItem = function(itemId) {
    let itemEl = document.getElementById(itemId);
    itemEl.style.opacity = "0";
    setTimeout(() => {
        itemEl.remove();
        
        // 2. Simpan status bahwa item ini sudah dihapus ke Local Storage
        localStorage.setItem(itemId + '_deleted', 'true');
        
        window.recalculateTotals();
    }, 300);
}

window.applyVoucher = function() {
    const code = document.getElementById("voucherCode").value;
    if (code.trim() !== "") {
        isVoucherApplied = true;
        document.getElementById("discountRow").style.display = "flex";
        window.recalculateTotals();

        const toastBox = document.getElementById("toastBox");
        toastBox.classList.add("show");
        setTimeout(() => {
            toastBox.classList.remove("show");
        }, 3000);

        document.getElementById("voucherCode").value = "";
    }
}

// 3. Saat halaman dimuat, cek apakah item pernah dihapus sebelumnya
document.addEventListener('DOMContentLoaded', () => {
    
    // Cek Item 1
    if (localStorage.getItem('item-1_deleted') === 'true') {
        let el = document.getElementById('item-1');
        if(el) el.remove();
    } else {
        let qtyEl = document.getElementById('qty-1');
        if(qtyEl) qtyEl.innerText = item1Qty;
    }

    // Cek Item 2
    if (localStorage.getItem('item-2_deleted') === 'true') {
        let el = document.getElementById('item-2');
        if(el) el.remove();
    } else {
        let qtyEl = document.getElementById('qty-2');
        if(qtyEl) qtyEl.innerText = item2Qty;
    }

    window.recalculateTotals();
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