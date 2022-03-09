<div class="actions-toolbar py-2 mb-1">
   <div class="row">
      <div class="col-md-6">
         <h5 class="mb-1">{{ $title }}</h5>
      </div>
      <div class="col-md-6 text-right">
         @if(!isset($hide_save_button))
         <button type="submit" name="submit" class="btn btn-sm btn-success" id="submitForm">
         <i class="fas fa-save"></i> Save record
         </button>
         @endif
         @if(isset($create_link))
         <a href="{{ $create_link['url'] }}" class="btn btn-sm btn-primary">
         <i class="fas fa-plus"></i> {{ $create_link['title'] }}
         </a>
         @endif
         @if(isset($back_link))
         <a href="{{ $back_link['url'] }}" class="btn btn-sm btn-light">
         {{ $back_link['title'] }}
         </a>
         @endif
      </div>
   </div>
   <hr>
</div>