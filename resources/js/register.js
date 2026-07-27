// 1. Fitur Show / Hide Password (bisa dipakai untuk beberapa input)
function togglePassword(btn) {
    // Mencari elemen input persis sebelum tombol toggle ini
    const passInput = btn.previousElementSibling;

    if (passInput.type === "password") {
        passInput.type = "text";
        btn.textContent = "🙈"; // Ubah icon saat password terlihat
    } else {
        passInput.type = "password";
        btn.textContent = "👁️"; // Kembalikan icon saat tertutup
    }
}

// 2. Fitur Loading State pada Button saat Register
function handleRegister(event) {
    event.preventDefault(); // Mencegah form refresh otomatis

    const emailValue = document.getElementById("email").value;
    const regBtn = document.getElementById("regBtn");
    const btnText = document.getElementById("btnText");
    const btnSpinner = document.getElementById("btnSpinner");
    const regError = document.getElementById("registerError");

    // Sembunyikan error sebelumnya
    regError.classList.remove("active");

    // Ubah ke state "Loading..."
    regBtn.disabled = true;
    btnText.style.display = "none";
    btnSpinner.style.display = "block";

    // Simulasi proses network
    setTimeout(() => {
        // Jika email test@gmail.com, munculkan error soft red
        if (emailValue === "test@gmail.com") {
            regError.classList.add("active");
            regBtn.disabled = false;
            btnText.style.display = "inline";
            btnSpinner.style.display = "none";
        } else {
            // Simulasi sukses register, alert dan redirect ke login
            alert(
                "Registrasi berhasil! Silakan cek email Anda untuk verifikasi.",
            );
            window.location.href = "bloopsie-login-prototype.html";
        }
    }, 1200);
}

document.addEventListener('DOMContentLoaded', function () {
    // === FITUR CHECKBOX SYARAT & KETENTUAN ===
    const termsCheckbox = document.getElementById('terms');
    const regBtn = document.getElementById('regBtn');

    if (termsCheckbox && regBtn) {
        // Cek saat pertama kali dimuat (jaga-jaga kalau habis refresh)
        updateButtonState();

        // Dengarkan perubahan saat dicentang / dihapus centangnya
        termsCheckbox.addEventListener('change', updateButtonState);

        function updateButtonState() {
            if (termsCheckbox.checked) {
                regBtn.disabled = false;
                regBtn.style.opacity = '1';
                regBtn.style.cursor = 'pointer';
            } else {
                regBtn.disabled = true;
                regBtn.style.opacity = '0.5';
                regBtn.style.cursor = 'not-allowed';
            }
        }
    }
});

// === FITUR SHOW / HIDE PASSWORD ===
// Fungsi ini dipanggil dari atribut onclick="togglePassword(this)" di HTML
window.togglePassword = function (button) {
    // Cari elemen input persis di sebelum tombol mata ini
    const input = button.previousElementSibling;
    
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = '🙈'; // Ganti icon jadi mata tertutup
    } else {
        input.type = 'password';
        button.textContent = '👁️'; // Ganti icon jadi mata terbuka
    }
};
