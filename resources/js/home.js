const revealEls = document.querySelectorAll(".reveal");
const io = new IntersectionObserver(
    (entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                e.target.classList.add("in");
                io.unobserve(e.target);
            }
        });
    },
    { threshold: 0.15 },
);
revealEls.forEach((el) => io.observe(el));

document.querySelectorAll(".btn-ripple").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        const rect = this.getBoundingClientRect();
        const span = document.createElement("span");
        span.className = "ripple";
        const size = Math.max(rect.width, rect.height);
        span.style.width = span.style.height = size + "px";
        span.style.left = e.clientX - rect.left - size / 2 + "px";
        span.style.top = e.clientY - rect.top - size / 2 + "px";
        this.appendChild(span);
        setTimeout(() => span.remove(), 650);
    });
});

function updateCountdown() {
    const target = new Date("2026-08-31T23:59:59");
    const now = new Date();
    const diff = Math.max(0, Math.ceil((target - now) / (1000 * 60 * 60 * 24)));
    document
        .querySelectorAll(".seal .num")
        .forEach((n) => (n.textContent = diff));
}
updateCountdown();

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
