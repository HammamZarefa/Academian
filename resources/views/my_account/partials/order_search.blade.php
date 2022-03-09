<div class="sticky-top">
   <div class="card mb-40">
      <div class="card-header">Search</div>
      <div class="card-body">
         <form id="search-form" autocomplete="off">   
            <div class="form-group">
               <label>Due Date</label>             
               <?php echo form_dropdown("dead_line", $data['dead_line_list'], NULL, "class='form-control form-control-sm  selectpicker'") ?>              
            </div>          
            <div class="form-group">
               <label>Status</label>
               <?php echo form_dropdown("order_status_id", $data['order_status_list'], NULL, "class='form-control form-control-sm  selectpicker'") ?>              
            </div>
            <div class="form-group">
               <label>Order Number</label>
               <input type="text" class="form-control form-control-sm" id="order_number" name="order_number">
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="show_by_nearest_due_date" class="custom-control-input" id="show_by_nearest_due_date">
                  <label class="custom-control-label" for="show_by_nearest_due_date">Display by nearest due date</label>
                </div>             
            </div>      
            <div class="form-group">
               <button type="submit" class="btn btn-success btn-sm btn-block mt-4">&nbsp &nbsp &nbsp <i class="fas fa-search"></i> Search &nbsp &nbsp &nbsp</button>
            </div>
         </form>
      </div>
   </div>
</div>