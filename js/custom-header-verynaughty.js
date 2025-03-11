document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const closeMenu = document.querySelector(".close-menu");
    const mobileMenu = document.querySelector("#main-nav");

    if (!menuToggle || !mobileMenu || !closeMenu) {
        console.error("Mobile menu elements not found");
        return;
    }

    const adminBar = document.querySelector("#wpadminbar");
    if (adminBar) {
        mobileMenu.classList.add("admin-bar");
    }

    menuToggle.addEventListener("click", function () {
        mobileMenu.classList.toggle("open");
    });

    closeMenu.addEventListener("click", function () {
        mobileMenu.classList.remove("open");
    });

    document.addEventListener("click", function (event) {
        if (!mobileMenu.contains(event.target) && !menuToggle.contains(event.target) && !closeMenu.contains(event.target)) {
            mobileMenu.classList.remove("open");
        }
    });
});
