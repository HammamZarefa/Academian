<div class="sticky-top">
   <div class="card">
      <div class="card-header">Search</div>
      <div class="card-body">
         <form id="search-form" autocomplete="off">
            <div class="form-group">
               <label>Status</label>
               <?php echo form_dropdown("status", ['' => 'All', 'paid' => 'Paid', 'unpaid' => 'Unpaid' ], NULL, "class='form-control form-control-sm selectpicker' id='status'") ?>
            </div>
            <div class="form-group">
               <label>Number</label>
               <input type="text" class="form-control form-control-sm" id="number" name="number">    
            </div>
            <div class="form-group">
               <button type="submit" class="btn btn-sm btn-success btn-block mt-4">&nbsp &nbsp &nbsp <i class="fas fa-search"></i> Search &nbsp &nbsp &nbsp</button>
            </div>
         </form>
      </div>
   </div>
</div>