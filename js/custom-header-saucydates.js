document.addEventListener("DOMContentLoaded", function () {
    function initMobileMenu() {
        const menuToggle = document.querySelector(".menu-toggle");
        const closeMenu = document.querySelector(".close-menu");
        const mobileMenu = document.querySelector("#mobile-menu");
        const body = document.body;

        if (!menuToggle || !closeMenu || !mobileMenu) {
            console.warn("Waiting for mobile menu elements...");
            return;
        }

        if (!menuToggle.hasAttribute("data-initialized")) {
            menuToggle.setAttribute("data-initialized", "true");

            const adminBar = document.querySelector("#wpadminbar");
            if (adminBar) {
                body.classList.add("admin-bar");
            }

            menuToggle.addEventListener("click", function (event) {
                event.preventDefault(); 
                body.classList.toggle("menu-open");
            });

            closeMenu.addEventListener("click", function (event) {
                event.preventDefault();
                body.classList.remove("menu-open");
            });
        }
    }

    function observeHeaderChanges() {
        const observer = new MutationObserver(() => {
            if (document.querySelector(".menu-toggle") && document.querySelector("#mobile-menu")) {
                initMobileMenu();
                observer.disconnect();
            }
        });

        observer.observe(document.body, { childList: true, subtree: true });
    }

    initMobileMenu();  
    observeHeaderChanges(); 
});
