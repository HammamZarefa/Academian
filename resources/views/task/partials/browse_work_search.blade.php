<div class="sticky-top">
   <div class="card">
      <div class="card-header">@lang('Search')</div>
      <div class="card-body">
         <form id="search-form" autocomplete="off">
            <div class="form-group">
               <label>@lang('Service Type')</label>
               <?php echo form_dropdown("service_id", $data['services_list'], NULL, "class='form-control form-control-sm  selectpicker'") ?>
            </div>
            <div class="form-group">
               <button type="submit" class="btn btn-sm btn-success btn-block mt-4">@lang('&nbsp &nbsp &nbsp') <i class="fas fa-search"></i>@lang('Search &nbsp &nbsp &nbsp') </button>
            </div>
         </form>
      </div>
   </div>
</div>
