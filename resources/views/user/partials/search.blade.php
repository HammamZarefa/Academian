<div class="sticky-top">
   <div class="card mb-40">
      <div class="card-header">@lang('Search')</div>
      <div class="card-body">
         <form id="search-form" autocomplete="off">
            <div class="form-group">
               <label>@lang('Name or Email')</label>
               <input type="text" class="form-control" id="search" name="search">
            </div>
            <div class="form-group">
               <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" value="1" id="inactive">
                  <label class="custom-control-label" for="inactive">@lang('Inactive Users')</label>
                </div>

            </div>
            @if($data['type'] == 'staff')
            <div class="form-group">
               <label>@lang('Area of expertise')</label>
               <?php echo form_dropdown("tag_id[]", $data['tag_id_list'], NULL, "class='form-control form-control-sm  multSelectpicker' multiple='multiple' id='tag_id'") ?>
            </div>
            @endif
            <div class="form-group">
               <button type="submit" class="btn btn-success btn-sm btn-block mt-4">@lang('&nbsp &nbsp &nbsp') <i class="fas fa-search"></i>@lang('Search &nbsp &nbsp &nbsp') </button>
            </div>
         </form>
      </div>
   </div>
</div>
