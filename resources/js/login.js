function togglePassword() {
    const passInput = document.getElementById("password");
    const toggleBtn = document.getElementById("togglePass");

    if (passInput.type === "password") {
        passInput.type = "text";
        toggleBtn.textContent = "🙈"; // Ubah icon saat password terlihat
    } else {
        passInput.type = "password";
        toggleBtn.textContent = "👁️"; // Kembalikan icon saat tertutup
    }
}

// 2. Fitur Loading State pada Button saat Login
function handleLogin(event) {
    event.preventDefault(); // Mencegah form refresh otomatis

    const loginBtn = document.getElementById("loginBtn");
    const btnText = document.getElementById("btnText");
    const btnSpinner = document.getElementById("btnSpinner");

    // Ubah ke state "Loading..."
    loginBtn.disabled = true;
    btnText.textContent = "Loading...";

    // Setelah 600ms, ubah ke Spinner animasi
    setTimeout(() => {
        btnText.style.display = "none";
        btnSpinner.style.display = "block";
    }, 600);

    // Simulasi login sukses (setelah 2 detik redirect ke home)
    setTimeout(() => {
        window.location.href = "bloopsie-homepage-prototype.html";
    }, 2000);
}
