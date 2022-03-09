@extends('setup.index')
@section('title', 'Upload Logo')
@section('setting_page') 
   @include('setup.partials.action_toolbar', ['title' => 'Upload Logo', 'hide_save_button' => TRUE])
   <div class="row">
      <div class="col-md-6">
         <div class="form-group">
            <div class="custom-file">
               <input type="file" class="custom-file-input" id="file" name="company_logo">
               <label class="custom-file-label" for="file">Choose file</label>
            </div>
            <div class="invalid-feedback d-block">{{ showError($errors, 'company_logo')}}</div>
         </div>
        
      </div>
      <div class="col-md-6 text-right">
         <small class="form-text text-muted">
         <br> Suggested image dimension: 154x36 pixel</small>
      </div>
   </div>


<div id="uploadimageModal" class="modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload & Crop Logo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-8 text-center">
                  <div id="image_demo" class="upload-image-container"></div>
               </div>
               <div class="col-md-4">
                  <br />
                  <div class="uploading_spinner text-center form-text text-muted" style="display: none;">Uploading ...</div>
                  <br />
                  <br/>
                  <button class="btn btn-success crop_image">Crop & Upload Logo</button>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

@endsection

@section('innerPageJS')
<script>
   $(function() {    

    $('.upload_photo').on("click", function(e) {
        e.preventDefault();
        $('#file').focus().trigger("click");
    });


    $image_crop = $('#image_demo').croppie({
        enableExif: true,
    
        viewport: {
            width: 154,
            height: 36,
            type: 'rectangle' //circle
        },
        boundary: {
            width: 200,
            height: 200
        }
    });

    var fileTypes = ['jpg', 'jpeg', 'png'];

    $('#file').on('change', function() {
        var reader = new FileReader();
        var file = this.files[0]; // Get your file here
        var fileExt = file.type.split('/')[1]; // Get the file extension

        if (fileTypes.indexOf(fileExt) !== -1) 
        {

          reader.onload = function(event) {
              $image_crop.croppie('bind', {
                  url: event.target.result
              }).then(function() {
                  // console.log('jQuery bind complete');
              });
          }
          reader.readAsDataURL(this.files[0]);
          $('#uploadimageModal').modal('show');
        
        } 
        else 
        {
          alert('File not supported');
        }
    });

    $('.crop_image').on("click", function(event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response) {

            response = response.replace("data:image/png;base64,", "");
            upload(response);

        })
    });


    function upload($image) {


        var data = {
            '_token': "{{ csrf_token() }}",
            'file': $image
        }

        $('.uploading_spinner').show();
        $('.crop_image').hide();


        // AJAX request

        $.post('{{ route("update_logo") }}', data)
            .done(function(response) {
               $('input[name="company_logo"]').val("");
                $('.crop_image').show();
                $('.uploading_spinner').hide();
                $('#uploadimageModal').modal('hide');
                $('.logo').attr("src", response.file_url);
                

            })
            .fail(function($xhr) {
                var response = $xhr.responseJSON;
                $('.uploading_spinner').hide();
                $('.crop_image').show();
                Swal.fire(response.msg);
            });

    }




});
</script>
@endsection