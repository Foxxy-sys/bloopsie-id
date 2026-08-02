window.handleSave = function (event) {
    event.preventDefault();

    const form = event.target; // Tangkap form-nya
    const saveBtn = document.getElementById("saveBtn");
    const btnText = document.getElementById("btnText");
    const btnSpinner = document.getElementById("btnSpinner");

    // 1. Ubah tombol jadi loading
    saveBtn.disabled = true;
    btnText.style.display = "none";
    btnSpinner.style.display = "block";

    // 2. Beri jeda animasi setengah detik, lalu kirim data ke Laravel!
    setTimeout(() => {
        form.submit();
    }, 500);
};

document.addEventListener("DOMContentLoaded", () => {
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

// FUNGSI PREVIEW IMAGE (Ditambahkan window. agar terbaca HTML)
window.previewImage = function(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imgPreview = document.getElementById("avatarImgPreview");
            const textPreview = document.getElementById("avatarTextPreview");

            imgPreview.src = e.target.result;
            imgPreview.style.display = "block";
            if (textPreview) textPreview.style.display = "none";
        };
        reader.readAsDataURL(input.files[0]);
    }
};