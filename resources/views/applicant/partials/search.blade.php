<div class="sticky-top">
   <div class="card mb-40">
      <div class="card-header">Search</div>
      <div class="card-body">
         <form id="search-form" autocomplete="off">
            <div class="form-group">
               <label>Name/Email/Applicant Number</label>
               <input type="text" class="form-control" name="general_text_search" >    
            </div>                       
            <div class="form-group">
               <label>Status</label>
               <?php echo form_dropdown("applicant_status_id", $data['statuses'], NULL, "class='form-control form-control-sm  selectpicker'") ?>              
            </div>
            <div class="form-group">
               <label>Referrer</label>
               <?php echo form_dropdown("referral_source_id", $data['referral_sources'], NULL, "class='form-control form-control-sm  selectpicker'") ?>              
            </div>            
            <div class="form-group">
               <button type="submit" class="btn btn-success">&nbsp &nbsp &nbsp <i class="fas fa-search"></i> Search &nbsp &nbsp &nbsp</button>
            </div>
         </form>
      </div>
   </div>
</div>