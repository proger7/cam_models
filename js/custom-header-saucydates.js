document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const closeMenu = document.querySelector(".close-menu");
    const mobileMenu = document.querySelector("#mobile-menu");
    const body = document.body;

    if (!menuToggle || !closeMenu || !mobileMenu) {
        console.error("Menu elements not found");
        return;
    }

    const adminBar = document.querySelector("#wpadminbar");
    if (adminBar) {
        body.classList.add("admin-bar");
    }

    menuToggle.addEventListener("click", function () {
        body.classList.toggle("menu-open");
    });

    closeMenu.addEventListener("click", function () {
        body.classList.remove("menu-open");
    });
});
