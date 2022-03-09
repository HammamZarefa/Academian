@extends('setup.index')
@section('title', 'Recruitment Settings')
@section('setting_page')
<form id="settingsForm" role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ 
   route('patch_settings_recruitment') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Recruitment'])
   <?php
      $disable_writer_application = (old_set('disable_writer_application', NULL, $rec)) ? 'checked' : '';
       ?>
   <div class="form-group">
      <div class="custom-control custom-checkbox">
         <input type="checkbox" class="custom-control-input" id="disable_writer_application"  name="disable_writer_application" value="1"
         {{ $disable_writer_application }}
         >
         <label class="custom-control-label" for="disable_writer_application">Disable "Writer's Application"</label>
      </div>
   </div>

   <?php
   $show_writer_application_link_website_top_menu = (old_set('show_writer_application_link_website_top_menu', NULL, $rec)) ? 'checked' : '';
    ?>
   <div class="form-group">
      <div class="custom-control custom-checkbox">
         <input type="checkbox" class="custom-control-input" id="show_writer_application_link_website_top_menu"  name="show_writer_application_link_website_top_menu" value="1"
         {{ $show_writer_application_link_website_top_menu }}
         >
         <label class="custom-control-label" for="show_writer_application_link_website_top_menu">Show link to Writer's Application page, on website's top menu</label>
      </div>
   </div>

   <div class="form-group">
      <label>Writer's application page link - Menu Title <span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors,'writer_application_page_link_title') }}" name="writer_application_page_link_title" value="{{ old_set('writer_application_page_link_title', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors,'writer_application_page_link_title') }}</div>
   </div>

   <div class="form-group">
      <label>Writer's application page title <span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors,'writer_application_page_title') }}" name="writer_application_page_title" value="{{ old_set('writer_application_page_title', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors,'writer_application_page_title') }}</div>
   </div>

   <div class="form-group">
      <label>Writer's application Form title <span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors,'writer_application_form_title') }}" name="writer_application_form_title" value="{{ old_set('writer_application_form_title', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors,'writer_application_form_title') }}</div>
   </div>

   <div class="form-group">
      <label>Writer's application Form subtitle <span class="text-muted">(Optional)</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors,'writer_application_form_subtitle') }}" name="writer_application_form_subtitle" value="{{ old_set('writer_application_form_subtitle', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors,'writer_application_form_subtitle') }}</div>
   </div>

   <div class="form-group">
      <label>Message to show after after successful form submission <span class="required">*</span></label>
      <input type="text" class="form-control {{ showErrorClass($errors,'writer_application_form_success_message') }}" name="writer_application_form_success_message" value="{{ old_set('writer_application_form_success_message', NULL, $rec) }}">
      <div class="invalid-feedback d-block">{{ showError($errors,'writer_application_form_success_message') }}</div>
   </div> 

   <textarea style="display: none" id="writer_application_page_content" name="writer_application_page_content"></textarea>   

</form>

<div class="form-group">
   <label>Content for Writer's application page</label>
 <!-- Create the editor container -->
 <div id="editor">
   <?php echo old_set('writer_application_page_content', NULL, $rec); ?>
</div>
</div>
@endsection
@section('innerPageJS')
<script>
   $(function() {    
  
      var toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction 

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme  
      ];

      var quill = new Quill('#editor', {
        modules: {
          toolbar: toolbarOptions
        },
        theme: 'snow'
      });


      quill.on('text-change', function(delta, oldDelta, source) {
         
            $('#writer_application_page_content').val(quill.container.firstChild.innerHTML);
        });


      $('#submitForm').on('click', function(e){     
         var content = quill.container.firstChild.innerHTML;

         if(content == '<p><br></p>')
         {
            content = '';
         }             
         $('#writer_application_page_content').val(content);
         $('form#settingsForm').submit();
      });   
  
   });
   
</script>
@endsection