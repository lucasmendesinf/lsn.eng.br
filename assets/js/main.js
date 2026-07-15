const header = document.querySelector("[data-header]");
const menu = document.querySelector("[data-menu]");
const menuToggle = document.querySelector("[data-menu-toggle]");
const cookieConsent = document.querySelector("[data-cookie-consent]");
const cookieAccept = document.querySelector("[data-cookie-accept]");

function syncHeader() {
  header.classList.toggle("is-scrolled", window.scrollY > 20);
}

menuToggle.addEventListener("click", () => {
  const isOpen = menu.classList.toggle("is-open");
  header.classList.toggle("is-open", isOpen);
  menuToggle.setAttribute("aria-expanded", String(isOpen));
});

menu.querySelectorAll("a").forEach((link) => {
  link.addEventListener("click", () => {
    menu.classList.remove("is-open");
    header.classList.remove("is-open");
    menuToggle.setAttribute("aria-expanded", "false");
  });
});

syncHeader();
window.addEventListener("scroll", syncHeader, { passive: true });

if (cookieConsent && cookieAccept) {
  const cookieKey = "lsnCookieAccepted";

  if (localStorage.getItem(cookieKey) !== "true") {
    cookieConsent.hidden = false;
  }

  cookieAccept.addEventListener("click", () => {
    localStorage.setItem(cookieKey, "true");
    cookieConsent.hidden = true;
  });
}
