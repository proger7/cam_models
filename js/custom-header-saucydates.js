document.addEventListener("DOMContentLoaded", function () {
    function initMobileMenu() {
        const menuToggle = document.querySelector(".menu-toggle");
        const closeMenu = document.querySelector(".close-menu");
        const mobileMenu = document.querySelector("#mobile-menu");
        const body = document.body;

        if (!menuToggle || !closeMenu || !mobileMenu) return;

        menuToggle.addEventListener("click", function (event) {
            event.preventDefault();
            body.classList.toggle("menu-open");
        });

        closeMenu.addEventListener("click", function (event) {
            event.preventDefault();
            body.classList.remove("menu-open");
        });
    }

    initMobileMenu();
});
