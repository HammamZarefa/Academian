<form id="search-form" autocomplete="off">
   <div class="form-row">
      <div class="form-group col-md-2">
         <label>Bill Number</label>
         <input type="text" class="form-control" id="number" name="number">    
      </div>
      <div class="form-group col-md-2">
         <label>From</label>
         <?php echo form_dropdown("from", $data['staff_list'], NULL, "class='form-control form-control-sm  selectpicker'") ?>              
      </div>
      <div class="form-group col-md-2">
         <label>Status</label>
         <?php echo form_dropdown("bill_status_list", $data['bill_status_list'], NULL, "class='form-control form-control-sm  selectpicker'") ?>              
      </div>
      <div class="form-group col-md-2 pt-32">
         <button type="submit" class="btn btn-success">&nbsp &nbsp &nbsp <i class="fas fa-search"></i> Search &nbsp &nbsp &nbsp</button>
      </div>
   </div>
</form>