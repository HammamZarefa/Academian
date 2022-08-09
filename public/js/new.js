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
              });

    
  });

  // $(window).on('load', function() {
  
      
  // });

})(jQuery);