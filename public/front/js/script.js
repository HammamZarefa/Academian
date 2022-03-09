// site loader
 window.onload = function() {
   document.getElementById("siteLoader").style.display = "none";
   document.getElementById("loader").style.visibility = "visible";
   $('#loader_helper').empty();
}

 $(document).ready(function() {

/*---------------------------------------------------------------- One Page Navigation ----------------------------*/
	$('.nav').onePageNav({
	filter: ':not(.external)',
	scrollThreshold: 0.25,
	scrollOffset: 0,
	});

/*---------------------------------------------------------------- Fixed menu ----------------------------*/
	$('header').scrollToFixed();


/*---------------------------------------------------------------- animation1 ----------------------------*/
	$('.features .item').hover(function() {
		$(this).addClass('animated pulse')
	}, function() {
		$(this).removeClass('animated pulse')
	});      

	$('.table .table-list').hover(function() {
		$(this).addClass('animated tada')
	}, function() {
		$(this).removeClass('animated tada')
	});  

	
/*---------------------------------------------------------------- Video ----------------------------*/
    $(".player").mb_YTPlayer();


/*--------------------------------------------------------------------------- Tooltip-------------------------------*/
	$('.tooltips').tooltip();



/*--------------------------------------------------------------- Responsive Video plugin ------------------*/
	$(".video").fitVids();
	

/*--------------------------------------------------------------------------- ToTop -------------------------*/
	 $(window).scroll(function(){
		 if ($(this).scrollTop() > 100) {
			 $('.scrollup').fadeIn();
		 } else {
			 $('.scrollup').fadeOut();
		 }
	 }); 
 
	 $('.scrollup').click(function(){
		 $("html, body").animate({ scrollTop: 0 }, 600);
		 return false;
	 });


/*----------------------------------------------------- contact Form -------------------------*/
	$("#request").submit(function() {
		var elem = $(this);
		var urlTarget = $(this).attr("action");
		$.ajax({
			type : "POST",
			url : urlTarget,
			dataType : "html",
			data : $(this).serialize(),
			beforeSend : function() {
				elem.prepend("<div class='loading alert'>" + "<a class='close' data-dismiss='alert'>×</a>" + "Loading" + "</div>");
				//elem.find(".loading").show();
			},
			success : function(response) {
				elem.prepend(response);
				//elem.find(".response").html(response);
				elem.find(".loading").hide();
				elem.find("input[type='text'],input[type='email'],textarea").val("");
			}
		});
		return false;
	});

/*---------------------------------------------------------------- Cta Button Set Interval ----------------------------*/
	setInterval(function(){$('.cta a').toggleClass('animated shake')}, 2000);





});

$('.gotowizrd').on('click', function() {
	window.location.replace('wizard.html','index.html')
});

 function goto(i) {
	localStorage.setItem('selected', `${i}`);
	window.location.replace(`wizard.html`,'index.html')
  }
  function gotoProjects() {
	window.location.replace(`email.html`,'index.html')
  }
  
// index