@extends('setup.index')
@section('title', 'Content Settings')
@section('setting_page')
@include('setup.partials.action_toolbar', ['title' => $content->title])
<form id="contentForm" role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('settings_update_content', $content->slug) }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}

   <input type="hidden" name="id" value="{{ $content->id }}">  
   <textarea style="display: none" id="description" name="description"></textarea>
</form>
<div class="main-content">
   <!-- Create the editor container -->
   <div id="editor">
      <?php echo $content->description; ?>
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
         
            $('#description').val(quill.container.firstChild.innerHTML);
        });


      $('#submitForm').on('click', function(e){     
         var content = quill.container.firstChild.innerHTML;

         if(content == '<p><br></p>')
         {
            content = '';
         }             
         $('#description').val(content);
         $('form#contentForm').submit();
      });   
   
   });   
   
</script>
@endsection