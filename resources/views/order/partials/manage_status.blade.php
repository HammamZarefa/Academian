<div class="card">
   <div class="card-header">
      Status
   </div>
   <div class="card-body">
      <form action="{{ route('order_change_status', $order->id) }}" method="POST" autocomplete="off">
            {{ csrf_field()  }}   
         <div class="form-group">
            <label>Name</label>
            <?php echo form_dropdown("order_status_id", $data['order_status_list'], old('order_status_id', $order->order_status_id), "class='form-control form-control-sm  selectpicker'") ?>
            <div class="invalid-feedback d-block">{{ showError($errors, 'order_status_id') }}</div>  
         </div>         
         <button type="submit" class="btn btn-secondary btn-sm btn-block">Change</button>
      </form>
   </div>
</div>