<div class="card bg-gradient-warning hover-shadow-lg">
   <div class="card-body py-3">
      <div class="row row-grid align-items-center">
         <div class="col-lg-12">
            <div class="media align-items-center">
               <a href="#" class="upload_photo">
               <img class="avatar avatar-lg rounded-circle mr-3 user-avatar" alt="Image placeholder" src="{{ $photo_url }}">
               </a>
               <div>
                  <a href="#" class="upload_photo"><span class="text-white">Change photo</span></a>
                  <div style="display: none;">
                     <form>
                        <input type="file" id='file' name="file" >
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<br>
<div class="card">
   <div class="card-body">
      <form autocomplete="off" class="form-horizontal" method="post" action="{{ route('users_update', $user->id) }}">
         {{ csrf_field()  }}
         {{ method_field('PATCH') }} 
         <div class="form-row">
            <div class="form-group col-md-6">
               <label>First Name <span class="required">*</span></label>
               <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'first_name') }}" name="first_name" value="{{ old('first_name', $user->first_name) }}">
               <div class="invalid-feedback d-block">
                  {{ showError($errors, 'first_name') }}
               </div>
            </div>
            <div class="form-group col-md-6">
               <label>Last Name <span class="required">*</span></label>
               <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'last_name') }}" name="last_name" value="{{ old('last_name', $user->last_name) }}">
               <div class="invalid-feedback d-block">
                  {{ showError($errors, 'last_name') }}
               </div>
            </div>
         </div>
         <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'email') }}" name="email" value="{{ old('email', $user->email) }}">
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'email') }}
            </div>
         </div>
         <div class="form-group">
            <label>Bio (Max character: 500)</label>
            <textarea class="form-control form-control-sm {{ showErrorClass($errors, 'bio') }}" name="bio">{{ old('bio', optional($user->meta)->bio) }}</textarea>
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'bio') }}
            </div>
         </div>
         <div class="form-group">
            <label>Timzeone</label>
            <?php echo form_dropdown("timezone", $data['timezones'], old('timezone', $user->timezone ), "class='form-control form-control-sm  selectpicker'") ?>
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'timezone') }}
            </div>
         </div>
         @if($user->hasRole('staff'))
         <div class="form-group">
            <label>Address (Max character: 500)</label>
            <textarea class="form-control form-control-sm {{ showErrorClass($errors, 'address') }}" name="address">{{ old('address', optional($user->meta)->address) }}</textarea>
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'address') }}
            </div>
         </div>
         @endif
         <div class="form-group">
            <label>Country</label>
            <?php echo form_dropdown("country", $data['countries'], old('country', optional($user->meta)->country ), "class='form-control form-control-sm  selectpicker'") ?>
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'country') }}
            </div>
         </div>
         @if($user->hasRole('staff'))      
         <div class="form-group">
            <label>Area of expertise</label>
            <?php echo form_dropdown("tag_id[]", $data['tag_id_list'], old('tag_id', $user->tags()->pluck('tag_id')->toArray()), "class='form-control form-control-sm  multSelectpicker' multiple='multiple'") ?>
         </div>
         <div class="form-group">
            <label>Preferred method for receiving payment</label>
            <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'preferred_payment_method') }}" name="preferred_payment_method" value="{{ old('preferred_payment_method', optional($user->meta)->preferred_payment_method ) }}" placeholder="example: paypal">
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'preferred_payment_method') }}
            </div>
         </div>
         <div class="form-group">
            <label>Payment method details</label>
            <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'payment_method_details') }}" name="payment_method_details" value="{{ old('payment_method_details', optional($user->meta)->payment_method_details ) }}">
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'payment_method_details') }}
            </div>
         </div>         
         @endif
         <div class="form-group">
            <label>Referral Source</label>
            <?php echo form_dropdown("referral_source", $data['referral_sources'], old('referral_source', optional($user->meta)->referral_source ), "class='form-control form-control-sm  selectpicker'") ?>
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'referral_source') }}
            </div>
         </div>   
         <div class="form-group">
            <label>Roles</label>
            <?php echo form_dropdown("role_id[]", $data['role_id_list'], old('role_id', $data['attached_roles']), "class='form-control form-control-sm  multSelectpicker' multiple='multiple'") ?>
         </div>
         <div class="form-group">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="1" id="inactive" name="inactive" {{ ($user->inactive) ? 'checked' : '' }}>
               <label class="form-check-label" for="inactive">
               Inactive
               </label>
            </div>
         </div>
         <button type="submit" class="btn btn-success">Submit</button>
      </form>
   </div>
</div>
<div id="uploadimageModal" class="modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload & Crop Image</h5>
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
                  <button class="btn btn-success crop_image">Crop & Upload Image</button>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

@section('innerJs')
<script>
   $(function() {

    $('.multSelectpicker').select2({
        theme: 'bootstrap4',
    });

    $('.selectpicker').select2({
        theme: 'bootstrap4',
    });
   

    $('.upload_photo').on("click", function(e) {
        e.preventDefault();
        $('#file').focus().trigger("click");
    });


    $image_crop = $('#image_demo').croppie({
        enableExif: true,
    
        viewport: {
            width: 360,
            height: 360,
            type: 'square' //circle
        },
        boundary: {
            width: 400,
            height: 400
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

        $.post('{{ route("users_change_photo", $user->id) }}', data)
            .done(function(response) {
                $('.crop_image').show();
                $('.uploading_spinner').hide();
                $('#uploadimageModal').modal('hide');
                $('.user-avatar').attr("src", response.file_url);
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