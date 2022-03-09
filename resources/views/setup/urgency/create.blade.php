@extends('setup.index')
@section('title', 'Service & Pricing')
@section('setting_page')

@include('setup.partials.action_toolbar', [
 'title' => (isset($urgency->id)) ? 'Edit urgency' : 'Create new urgency', 
 'hide_save_button' => TRUE,
 'back_link' => ['title' => 'back to urgencies', 'url' => route("urgencies_list")],
])
 <form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($urgency->id)) ? route( 'urgencies_update', $urgency->id) : route('urgencies_store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   @if(isset($urgency->id))
   {{ method_field('PATCH') }}
   @endif
   <div class="form-row">
      <div class="form-group col-md-6">
         <label>Duration and Type <span class="required">*</span></label>
         <div class="input-group mb-3">
            <input type="text" class="form-control" name="value" value="{{ old_set('value', NULL, $urgency) }}" placeholder="Example : 3">
            <div class="input-group-prepend">
               <?php
                  echo form_dropdown('type', $data['types'], old_set('type', NULL, $urgency) , "class='form-control'");
                  ?>
            </div>
         </div>
         <div class="invalid-feedback d-block">{{ showError($errors, 'value') }}</div>
         <div class="invalid-feedback">{{ showError($errors, 'type') }}</div>
      </div>
   </div>
   <div class="form-row">
      <div class="form-group col-md-7">
         <label> 
         <span data-toggle="tooltip" title="Enter the percentage of base price of a service that should add up with the total of an order"><i class="fas fa-question-circle"></i></span>
         Percentage of base price of a service<span class="required">*</span>
         </label>
         <div class="input-group mb-3">
            <input type="text" class="form-control {{ showErrorClass($errors, 'percentage_to_add') }}" name="percentage_to_add" value="{{ old_set('percentage_to_add', NULL, $urgency) }}">
            <div class="input-group-append">
               <span class="input-group-text">%</span>
            </div>
         </div>
         <small class="form-text text-muted">Enter the percentage of base price of a service that should add up with the total of an order</small>
         <div class="invalid-feedback d-block">{{ showError($errors, 'percentage_to_add') }}</div>
      </div>
   </div>
   <div class="form-group">
      <div class="custom-control custom-checkbox">
         <input type="checkbox" class="custom-control-input" id="inactive" name="inactive" value="1" {{ old_set('inactive', NULL, $urgency) ? 'checked="checked"' : '' }}>
         <label class="custom-control-label" for="inactive">Inactive</label>
      </div>
   </div>
   <input type="submit" name="submit" class="btn btn-success" value="Submit"/>
</form>
@endsection


@push('scripts')
<script>
    $(function(){           
      $('select').select2({
          theme: 'bootstrap4',
         minimumResultsForSearch: -1
      });     

    });      
</script>
@endpush
