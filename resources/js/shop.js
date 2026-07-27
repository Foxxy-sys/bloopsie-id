// --- SHOP SCRIPT (server-rendered version) ---

// Auto-submit form saat sort berubah
document.getElementById("sortSelect")?.addEventListener("change", () => {
    document.getElementById("shopFilterForm").submit();
});

// Search: submit saat tekan Enter
document.getElementById("searchInput")?.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("shopFilterForm").submit();
    }
});

// Mobile filter toggle
document.getElementById("filterToggle")?.addEventListener("click", () => {
    document.getElementById("filtersPanel").classList.toggle("open");
});

// Filter count badge (checkbox yang dicentang)
const filterInputs = document.querySelectorAll(".filter-option input[type=checkbox]");
function updateFilterCount() {
    const checked = document.querySelectorAll(".filter-option input[type=checkbox]:checked").length;
    const el = document.getElementById("filterCount");
    if (el) el.textContent = checked;
}
filterInputs.forEach((cb) => cb.addEventListener("change", updateFilterCount));
updateFilterCount(); // set awal berdasarkan yang sudah checked dari server

document.getElementById("clearFilters")?.addEventListener("click", () => {
    filterInputs.forEach((cb) => (cb.checked = false));
    updateFilterCount();
    document.getElementById("shopFilterForm").submit();
});

// View toggle (4 kolom / 2 kolom) — tetap murni tampilan, tidak perlu backend
const viewButtons = document.querySelectorAll(".view-toggle button");
viewButtons.forEach((btn, idx) => {
    btn.addEventListener("click", () => {
        viewButtons.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        document.getElementById("productsGrid").style.gridTemplateColumns =
            idx === 0 ? "repeat(4,1fr)" : "repeat(2,1fr)";
    });
});

// Account dropdown menu
document.addEventListener('DOMContentLoaded', function () {
    const accountBtn = document.getElementById('accountBtn');
    const accountMenu = document.getElementById('accountMenu');
    if (accountBtn && accountMenu) {
        accountBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            accountMenu.classList.toggle('open');
        });
        document.addEventListener('click', function (e) {
            if (!accountMenu.contains(e.target) && !accountBtn.contains(e.target)) {
                accountMenu.classList.remove('open');
            }
        });
    }
});