/**
* Template Name: Company - v2.1.0
* Template URL: https://bootstrapmade.com/company-free-html-bootstrap-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
!(function($) {
  "use strict";
  $(document).ready(function() {
      $(".bootstrap-select").on("click", function() {
        if ( $(".bootstrap-select .dropdown-menu").hasClass("show")) {
          $(".bootstrap-select .dropdown-menu").removeClass("show");
        }
        else{
          $(".bootstrap-select .dropdown-menu").addClass("show");
        }
        });
        $(".seclector").on("click", function() {
          if ( $(this).hasClass("active")) {
            $(this).removeClass("active");
          }
          else{
            $(this).addClass("active");
          }
          });
          $(".change-lang li").on("click", function() {
            if ( $(this).attr("data-lang") === "en") {
              // title input
              $(".title_en").css("position","relative");
              $(".title_en").css("z-index","10");
              $(".title_en").css("opacity","1");
              $(".title_ar").css("position","absolute");
              $(".title_ar").css("z-index","-1");
              $(".title_ar").css("opacity","0");
              // Desc input
              $(".body_en").css("position","relative");
              $(".body_en").css("z-index","10");
              $(".body_en").css("opacity","1");
              $(".body_ar").css("position","absolute");
              $(".body_ar").css("z-index","-1");
              $(".body_ar").css("opacity","0");
              // keywords input
              $(".keyword_en").css("position","relative");
              $(".keyword_en").css("z-index","10");
              $(".keyword_en").css("opacity","1");
              $(".keyword_ar").css("position","absolute");
              $(".keyword_ar").css("z-index","-1");
              $(".keyword_ar").css("opacity","0");
              // meta_desc input
              $(".meta_desc_en").css("position","relative");
              $(".meta_desc_en").css("z-index","10");
              $(".meta_desc_en").css("opacity","1");
              $(".meta_desc_ar").css("position","absolute");
              $(".meta_desc_ar").css("z-index","-1");
              $(".meta_desc_ar").css("opacity","0");
             
            }
            else{
              // title input
              $(".title_ar").css("position","relative");
              $(".title_ar").css("z-index","10");
              $(".title_ar").css("opacity","1");
              $(".title_en").css("position","absolute");
              $(".title_en").css("z-index","-1");
              $(".title_en").css("opacity","0");
              // Desc input
              $(".body_ar").css("position","relative");
              $(".body_ar").css("z-index","10");
              $(".body_ar").css("opacity","1");
              $(".body_en").css("position","absolute");
              $(".body_en").css("z-index","-1");
              $(".body_en").css("opacity","0");
              // keywords input
              $(".keyword_ar").css("position","relative");
              $(".keyword_ar").css("z-index","10");
              $(".keyword_ar").css("opacity","1");
              $(".keyword_en").css("position","absolute");
              $(".keyword_en").css("z-index","-1");
              $(".keyword_en").css("opacity","0");
              // meta_desc input
              $(".meta_desc_ar").css("position","relative");
              $(".meta_desc_ar").css("z-index","10");
              $(".meta_desc_ar").css("opacity","1");
              $(".meta_desc_en").css("position","absolute");
              $(".meta_desc_en").css("z-index","-1");
              $(".meta_desc_en").css("opacity","0");
            }
            });
          
  });

  // $(window).on('load', function() {
  
      
  // });

})(jQuery);