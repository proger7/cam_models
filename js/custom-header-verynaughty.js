document.addEventListener("DOMContentLoaded", function () {
    function initMobileMenu() {
        const menuToggle = document.querySelector(".menu-toggle");
        const closeMenu = document.querySelector(".close-menu");
        const mobileMenu = document.querySelector("#main-nav");

        if (!menuToggle || !mobileMenu) {
            console.warn("Waiting for mobile menu elements...");
            return;
        }

        if (!menuToggle.hasAttribute("data-initialized")) {
            menuToggle.setAttribute("data-initialized", "true");

            const adminBar = document.querySelector("#wpadminbar");
            if (adminBar) {
                mobileMenu.classList.add("admin-bar");
            }

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

            document.addEventListener("click", function (event) {
                if (!mobileMenu.contains(event.target) && !menuToggle.contains(event.target) && (!closeMenu || !closeMenu.contains(event.target))) {
                    mobileMenu.classList.remove("open");
                }
            });
        }
    }

    function observeHeaderChanges() {
        const observer = new MutationObserver(() => {
            if (document.querySelector(".menu-toggle") && document.querySelector("#main-nav")) {
                initMobileMenu();
                observer.disconnect();
            }
        });

        observer.observe(document.body, { childList: true, subtree: true });
    }

    initMobileMenu();
    observeHeaderChanges();
});
