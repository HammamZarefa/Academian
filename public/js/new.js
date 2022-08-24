/**
* Template Name: Company - v2.1.0
* Template URL: https://bootstrapmade.com/company-free-html-bootstrap-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
!(function($) {
  "use strict";
  $(document).ready(function() {
    setTimeout(() => {
      AOS.init();
    }, 500);
    $(".dropdown-content .category-name:first-child").addClass("active");
    $(".dropdown-content .category-name").on("mouseover", function() {
      $(".dropdown-content .category-name").removeClass("active");
      $(this).addClass("active");
      });
      // *********************************************************
      $(".navbar-toggle").on("click", function() {
        $(".collapse").toggle("show in");
        });
      // *********************************************************
        $("#more-about .item").on("click", function() {
          if ( $(this).hasClass("active")) {
            $(this).removeClass("active");
          }
          else{
            $(this).addClass("active");
          }
          
          });
          // *****************************************************
          $(".seclector").on("click", function() {
            if ( $(this).hasClass("active")) {
              $(this).removeClass("active");
            }
            else{
              $(this).addClass("active");
            }
            });
            // ***************************************************
            $("#add-review").on("click", function() {
              if ( $(".form-cover").hasClass("active")) {
                $(".form-cover").removeClass("active");
                $(".form-review").removeClass("active");
              }
              else{
                $(".form-cover").addClass("active");
                $(".form-review").addClass("active");
              }
              });
              
            // ***************************************************
              $(".form-cover").on("click", function() {
                if ( $(".form-cover").hasClass("active")) {
                  $(".form-cover").removeClass("active");
                  $(".form-review").removeClass("active");
                }
                else{
                  $(".form-cover").addClass("active");
                  $(".form-review").addClass("active");
                }
                });
            // ***************************************************
            $("#shapes span").on("click", function() {
              $("#shapes span").removeClass("active");
              $(this).addClass("active");
              $("#siteLoader").css("display", "block");
              setTimeout(() => {
	              $("#siteLoader").css("display", "none");
               }, 1500);
              });
              $("#shapes #All").on("click", function() {
                $(".gallery-video [data-type='0']").fadeIn(1500);
                $(".gallery-video [data-type='1']").fadeIn(1500);
                $(".empty-video").fadeOut(1500);
                });
              $("#shapes #Videos").on("click", function() {
                $(".gallery-video [data-type='0']").fadeOut(1500);
                  $(".gallery-video [data-type='1']").fadeIn(1500);
                  $(".empty-video").fadeOut(1500);
                  if($(".gallery-video [data-type='1']").length == 0){
                    $(".empty-video").fadeIn(1500);
                  }
                });
              $("#shapes #Images").on("click", function() {
                $(".gallery-video [data-type='0']").fadeIn(1500);
                $(".gallery-video [data-type='1']").fadeOut(1500);
                $(".empty-video").fadeOut(1500);
                if($(".gallery-video [data-type='0']").length == 0){
                  $(".empty-video").fadeIn(1500);
                }
              
                });

                $(window).scroll(function(){
                  if($(window).width() > 767){
                    if($(window).scrollTop() > 102){
                      $("#sidebar-blog").css("position","fixed");
                      $("#sidebar-blog").css("width","360px");
                      $("#sidebar-blog").css("top","20px");
                     }
                     if($(window).scrollTop() < 102){
                      $("#sidebar-blog").css("position","relative");
                      $("#sidebar-blog").css("top","0");
                      $("#sidebar-blog").css("width","100%");

                     }
                  }
               
                });
                $("#sortBynew").on("click", function() {
                  $("#rev-sorting .rev").sort(function(a,b){
                    return new Date($(a).attr("data-date")) < new Date($(b).attr("data-date"));
                }).each(function(){
                    $("#rev-sorting").prepend(this);
                })
                });
                $("#sortByold").on("click", function() {
                  $("#rev-sorting .rev").sort(function(a,b){
                    return new Date($(a).attr("data-date")) > new Date($(b).attr("data-date"));
                }).each(function(){
                    $("#rev-sorting").prepend(this);
                })
                });
                // console.log($("#sidebar-blog").outerHeight());
                // console.log($(window).scrollTop());
    
  });

  // $(window).on('load', function() {
  
      
  // });

})(jQuery);