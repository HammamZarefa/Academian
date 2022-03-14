<div class="card">
   <div class="card-header">
       @lang('Assignee')
   </div>
   <div class="card-body">
      <form action="{{ route('assign_task', $order->id) }}" method="POST" autocomplete="off">
            {{ csrf_field()  }}
         <div class="form-group">
            <label>@lang('Name')</label>
            <?php echo form_dropdown("staff_id", $data['staff_list'], old('staff_id', $order->staff_id), "class='form-control form-control-sm  selectpicker'") ?>

            <div class="invalid-feedback d-block">{{ showError($errors, 'staff_id') }}</div>
         </div>
         <div class="form-group">
            <label>@lang('Payment Amount')</label>
            <input type="text" class="form-control form-control-sm" name="staff_payment_amount" value="{{ old('staff_payment_amount', $order->staff_payment_amount) }}">
            <div class="invalid-feedback d-block">{{ showError($errors, 'staff_payment_amount') }}</div>
         </div>
         <button type="submit" class="btn btn-success btn-sm btn-block">@lang('Submit')</button>
      </form>
   </div>
</div>
