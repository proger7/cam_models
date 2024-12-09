function showPopup() {
    const popup = document.querySelector('#__nuxt');
    if (popup) {
        popup.style.display = 'block';
    }
}

function removeLogo() {
    const logo = document.querySelector('.logo');
    if (logo) {
        logo.remove();
    }
}

function closePopup() {
    const popup = document.querySelector('#__nuxt');
    if (popup) {
        popup.style.display = 'none';
        window.popupClosed = true;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const popup = document.querySelector('#__nuxt');
    if (popup) {
        popup.style.display = 'none';
        window.popupClosed = false;

        setTimeout(() => {
            if (!window.popupClosed) {
                showPopup();
            }
        }, 3000);

        window.addEventListener('scroll', () => {
            const scrollPosition = window.scrollY + window.innerHeight;
            const scrollThreshold = document.body.scrollHeight * 0.5;

            if (scrollPosition >= scrollThreshold && !window.popupClosed) {
                showPopup();
            }
        });

        const closeButton = document.querySelector('.close');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                closePopup();
            });
        }

        removeLogo();
    }
});
