jQuery(document).ready(function($) {
    if (sessionStorage.getItem('ctaPopupShown')) {
        return;
    }
    
    function showPopup() {
        $('#cta-popup').css({'display': 'block', 'opacity': '0'}).animate({opacity: 1}, 300);
        sessionStorage.setItem('ctaPopupShown', 'true');
        setTimeout(function() {
            $('#cta-popup').animate({opacity: 0}, 300, function() {
                $(this).css('display', 'none');
            });
        }, 10000);
    }

    setTimeout(showPopup, 1500);

    $('.cta-popup-no, #cta-popup-overlay').on('click', function() {
        $('#cta-popup').animate({opacity: 0}, 300, function() {
            $(this).css('display', 'none');
        });
    });
});