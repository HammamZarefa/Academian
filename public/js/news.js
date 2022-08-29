/**
* Template Name: Company - v2.1.0
* Template URL: https://bootstrapmade.com/company-free-html-bootstrap-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
!(function($) {
  "use strict";
  $(document).ready(function() {
      // $(".bootstrap-select").on("click", function() {
      //   if ( $(".bootstrap-select .dropdown-menu").hasClass("show")) {
      //     $(".bootstrap-select .dropdown-menu").removeClass("show");
      //   }
      //   else{
      //     $(".bootstrap-select .dropdown-menu").addClass("show");
      //   }
      //   });
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
              $(".form-en").css('position',"relative");
              $(".form-en").css('z-index',10);
              $(".form-en").css('opacity',1);
              
              $(".form-ar").css('position',"absolute");
              $(".form-ar").css('z-index',-1);
              $(".form-ar").css('opacity',0);

              $(".current").html('English');
            }
            else{
              $(".form-ar").css('position',"relative");
              $(".form-ar").css('z-index',10);
              $(".form-ar").css('opacity',1);

              $(".form-en").css('position',"absolute");
              $(".form-en").css('z-index',-1);
              $(".form-en").css('opacity',0);

              $(".current").html('عربي');
            }
            });
            // ************* this function for add and edit languages *************
            $('.deleteKey').on('click', function () {
              var modal = $('#DelModal');
              modal.find('input[name=key]').val($(this).data('key'));
              modal.find('input[name=value]').val($(this).data('value'));
          });
            $('.editModal').on('click', function () {
              var modal = $('#editModal');
              modal.find('.form-title').text($(this).data('title'));
              modal.find('input[name=key]').val($(this).data('key'));
              modal.find('input[name=value]').val($(this).data('value'));
          });


            // ************* check-coupon *************
          $("#check-coupon").click(function(event){
            event.preventDefault();
      
            let name = $("input[id=code]").val();
            let _token   = $('#coupon-form').attr('data-token');
      
            $.ajax({
              url: "/check-validity",
              type:"POST",
              data:{
                code:name,
                _token: _token
              },
              success:function(response){
                if(response.coupon) {
                  $('.success').text(response.success);
                    console.log(response.coupon);
                  $("#coupon-form")[0].reset()
                    $(".discount").show()
                    if(response.coupon.type=='fixed')
                      $("#discount").val(response.coupon.amount)
                    else if(response.coupon.type=='percent') {
                       let $total = $("input[name=total]").val();
                        $("#discount").val(response.coupon.amount*$total/100)
                    }
                }
                else console.log('Failed')
              },
              error: function(error) {
               console.log(error);
                // $('#nameError').text(response.responseJSON.errors.name);
                // $('#emailError').text(response.responseJSON.errors.email);
                // $('#mobileError').text(response.responseJSON.errors.mobile);
                // $('#messageError').text(response.responseJSON.errors.message);
              }
             });
        });
  });

  // $(window).on('load', function() {
  
      
  // });

})(jQuery);