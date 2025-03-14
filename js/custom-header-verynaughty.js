document.addEventListener("DOMContentLoaded", function () {
    function initMobileMenu() {
        const menuToggle = document.querySelector(".menu-toggle");
        const closeMenu = document.querySelector(".close-menu");
        const mobileMenu = document.querySelector("#main-nav");

        if (!menuToggle || !mobileMenu) return;

        menuToggle.addEventListener("click", function (event) {
            event.preventDefault();
            mobileMenu.classList.toggle("open");
        });

        if (closeMenu) {
            closeMenu.addEventListener("click", function (event) {
                event.preventDefault();
                mobileMenu.classList.remove("open");
            });
        }
    }

    initMobileMenu();
});
