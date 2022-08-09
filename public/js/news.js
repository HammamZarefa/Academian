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
  });

  // $(window).on('load', function() {
  
      
  // });

})(jQuery);