//With Credits to: https://davidwalsh.name/fullscreen

// Find the right method, call on correct element
function launchFullscreen(element) {
  if(element.requestFullscreen) {
    element.requestFullscreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  } else if(element.msRequestFullscreen) {
    element.msRequestFullscreen();
  }
}

function exitFullscreen() {
  if(document.exitFullscreen) {
    document.exitFullscreen();
  } else if(document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if(document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  }
}
jQuery(function($) {
    var images = ['clms-mainpic-1.jpg', 'clms-mainpic-2.jpg', 'clms-mainpic-3.jpg', 'our-wa-parks-bg-3.jpg', 'marupials.jpg', 'echidna.jpg', 'marsupials.jpg', 'Carolynn_Hill.jpg', 'Keith_Boombi.jpg', 'instruction.jpg', 'Ross_mead.jpg', 'snakelake.jpg', 'spraying.jpg', 'weedscourse.jpg'];
    $('.sitetopic').css({'background': 'linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)), url(https://learning-dev.dpaw.wa.gov.au/theme/dpawbs3/pix/' + images[Math.floor(Math.random() * images.length)] + ')'});
});

jQuery(function($){
    $('.dropdown').hover(function() {
        $(this).addClass('open');
    },
    function() {
        $(this).removeClass('open');
    });
});