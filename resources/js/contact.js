const accountBtn = document.getElementById("accountBtn");
const accountMenu = document.getElementById("accountMenu");
const logoutBtn = document.getElementById("logoutBtn");

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

logoutBtn.addEventListener("click", () => {
    accountMenu.classList.remove("open");
    alert("Kamu telah logout dari Bloopsie.id 💌");
    window.location.href = "#home";
});