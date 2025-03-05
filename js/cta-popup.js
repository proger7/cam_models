jQuery(document).ready(function($) {
    function showPopup() {
        $('#cta-popup, #cta-popup-overlay').fadeIn();
    }

    setTimeout(showPopup, 2000);

    $('.cta-popup-no, #cta-popup-overlay').on('click', function() {
        $('#cta-popup, #cta-popup-overlay').fadeOut();
    });
});
