

// ************************ //
// Gallery Images
// ************************ //
$(document).ready(function() {
 "use strict"; 
  $("#gallery-images").owlCarousel({
    itemsDesktop : [2000,3],
    itemsDesktopSmall : [1200,2],
    itemsTablet: [769,1],
    itemsMobile : [350,1],
    navigation : true,
    slideSpeed : 600,
    mouseDrag: true,
    pagination : true,
    navigationText : ["&#xf190;","&#xf18e;"]
});
$(function () {
  $("#gallery-images iframe").hover(function() {
    var player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    height: '390',
    width: '640',
    videoId: 'M4Xrh8OP1Jk'
  });
}
$(this).on('mouseover', function() {
  player.playVideo();
});
$(this).on('mouseout',  function() {
  player.pauseVideo();
});
  
});
  $("#gallery-images iframe").click(function() {
       const srcvideo = $(this).prop("src");
       
       $("#gallery-images").fadeOut();
       $("#overlay").fadeIn();
       $("#show_videos").fadeIn();
       $("#video").attr("src",srcvideo);
       console.log($("#video").attr("src"));
  });
  $("#overlay").click(function() {
    $("#overlay").fadeOut();
    $("#show_videos").fadeOut();
    $("#gallery-images").fadeIn();

});
});

});
