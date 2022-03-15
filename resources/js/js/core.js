

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
  $("#gallery-images video").click(function() {
       const srcvideo = $(this).children('.sc').prop("src");
       
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