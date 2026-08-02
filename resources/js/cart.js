let isVoucherApplied = false;

function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString("id-ID");
}

// 1. Fungsi dinamis untuk menghitung ulang semua elemen yang ada di layar
window.recalculateTotals = function() {
    let subtotal = 0;
    
    // Cari semua elemen produk di keranjang
    const items = document.querySelectorAll('.cart-item');
    
    items.forEach(item => {
        let priceText = item.querySelector('.item-price').innerText.replace(/[^0-9]/g, '');
        let price = parseInt(priceText);
        
        let qtyText = item.querySelector('.qty-control span').innerText;
        let qty = parseInt(qtyText);

        subtotal += price * qty;
    });

    // Update jumlah item di header
    let itemCountEl = document.getElementById("itemCount");
    if(itemCountEl) {
        itemCountEl.innerText = `${items.length} Item${items.length !== 1 ? "s" : ""}`;
    }

    // Update text Subtotal
    let subtotalEl = document.getElementById("subtotalDisplay");
    if(subtotalEl) {
        subtotalEl.innerText = formatRupiah(subtotal);
    }

    // Hitung Voucher Diskon
    let discountAmount = 0;
    if (isVoucherApplied && subtotal > 0) {
        discountAmount = subtotal * 0.1; 
        document.getElementById("discountRow").style.display = "flex";
        document.getElementById("discountDisplay").innerText = "- " + formatRupiah(discountAmount);
    } else {
        let discountRow = document.getElementById("discountRow");
        if(discountRow) discountRow.style.display = "none";
        isVoucherApplied = false;
    }

    // Update Total Akhir
    let totalEl = document.getElementById("totalDisplay");
    if(totalEl) {
        let finalTotal = subtotal - discountAmount;
        totalEl.innerText = formatRupiah(finalTotal);
    }

    // Jika keranjang benar-benar kosong
    if (items.length === 0) {
        let cartList = document.getElementById("cartList");
        if(cartList) {
            cartList.innerHTML = '<div style="text-align: center; padding: 2rem;"><h3 style="color: var(--muted); margin-bottom: 15px;">Keranjang kamu masih kosong</h3><a href="/shop" class="btn btn-primary">Belanja Sekarang</a></div>';
        }
        let checkoutBtn = document.querySelector('.summary-card button.btn-primary');
        if(checkoutBtn) checkoutBtn.disabled = true;
    }
}

// 2. Fungsi merubah Qty (Diperbarui dengan AJAX)
window.updateQty = function(elementId, change, price) {
    let qtySpan = document.getElementById(elementId);
    if(!qtySpan) return;

    let currentQty = parseInt(qtySpan.innerText);
    let newQty = currentQty + change;

    if (newQty >= 1) {
        // Update angka di layar
        qtySpan.innerText = newQty;
        window.recalculateTotals();
        
        // Ambil ID CartItem (Contoh: "qty-5" jadi "5")
        let cartItemId = elementId.replace('qty-', '');
        
        // Ambil token keamanan Laravel
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Kirim data ke database tanpa reload halaman
        fetch(`/cart/update/${cartItemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ quantity: newQty })
        }).catch(error => console.error('Error updating quantity:', error));
    }
}

// 3. Fungsi menghapus Item dari layar (Diperbarui dengan AJAX)
window.removeItem = function(itemIdString) {
    let itemEl = document.getElementById(itemIdString);
    if(!itemEl) return;

    // Ambil ID CartItem (Contoh: "item-5" jadi "5")
    let cartItemId = itemIdString.replace('item-', '');
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    itemEl.style.opacity = "0";
    setTimeout(() => {
        // Hapus elemen dari HTML
        itemEl.remove();
        window.recalculateTotals();
        
        // Hapus data dari database tanpa reload halaman
        fetch(`/cart/remove/${cartItemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token
            }
        }).catch(error => console.error('Error removing item:', error));
    }, 300);
}

// 4. Fungsi Voucher
window.applyVoucher = function() {
    const code = document.getElementById("voucherCode").value;
    if (code.trim() !== "") {
        isVoucherApplied = true;
        window.recalculateTotals();

        const toastBox = document.getElementById("toastBox");
        if(toastBox) {
            toastBox.classList.add("show");
            setTimeout(() => {
                toastBox.classList.remove("show");
            }, 3000);
        }
        document.getElementById("voucherCode").value = "";
    }
}

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