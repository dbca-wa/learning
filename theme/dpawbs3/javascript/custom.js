function goFullscreen(id) {
        var element = document.getElementById(id);
        if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
        }
}
jQuery(function($) {
    var images = ['clms-mainpic-1.jpg', 'clms-mainpic-2.jpg', 'clms-mainpic-3.jpg'];
    $('.sitetopic').css({'background': 'linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)), url(http://learning-uat.dpaw.wa.gov.au/theme/dpawbs3/pix/' + images[Math.floor(Math.random() * images.length)] + ')'});
});

jQuery(function($){
    $('.dropdown').hover(function() {
        $(this).addClass('open');
    },
    function() {
        $(this).removeClass('open');
    });
});