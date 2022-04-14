

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
$('.vid').each(function(el){
  var _this = $(this);
  var scc = _this[0].src;
  _this.on('mouseover', function(ev) {
    _this.attr('src',scc+"?autoplay=1");
    ev.preventDefault();

  });
  _this.on('mouseleave', function(ev) {

    _this.attr('src',scc);
    ev.preventDefault();

  });
});
$('.language li a').click(function(el){
  var _this = $(this);
  var len=  _this[0].href.indexOf('language/')
  var langValue = _this[0].href.slice(len+9,len+11).toLowerCase();
  localStorage.setItem('locale',langValue)
 
});
});
