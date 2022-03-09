<div class="card">
   <div class="card-body">
      <div class="card-title">Change password</div>
      <hr>
      <form autocomplete="off" class="form-horizontal" method="post" action="{{ route('change_password') }}">
         {{ csrf_field()  }}
         {{ method_field('PATCH') }}          
         <div class="form-group">
            <label>Current Password <span class="required">*</span></label>
            <input type="password" class="form-control form-control-sm {{ showErrorClass($errors, 'current_password') }}" name="current_password" value="">
            <div class="invalid-feedback d-block">
               {{ showError($errors, 'current_password') }}
            </div>
         </div>
         <div class="form-group">
            <label>New password <span class="required">*</span></label>
            <input type="password" class="form-control form-control-sm {{ showErrorClass($errors, 'password') }}" name="password" value="">
            <div class="invalid-feedback d-block">{{ showError($errors, 'password') }}</div>
         </div>
         <div class="form-group">
            <label>Retype Password <span class="required">*</span></label>
            <input type="password" class="form-control form-control-sm {{ showErrorClass($errors, 'password_confirmation') }}" name="password_confirmation" value="">
            <div class="invalid-feedback d-block">{{ showError($errors, 'password_confirmation') }}</div>
         </div>
         <button type="submit" class="btn btn-success">Submit</button>
      </form>
   </div>
</div>