@extends('setup.index')
@section('title', 'Payment Gateways')
@section('setting_page')
@include('setup.partials.action_toolbar', ['title' => 'Payment Gateways', 'hide_save_button' => true])
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @foreach($data['gateways'] as $unique_name=>$gateway)        
            <a class="nav-item nav-link {{ ($data['current_gateway'] == $unique_name) ? 'active' : '' }}" href="{{ route('settings_payment_gateways', ['gateway' => Str::slug($unique_name, '-') ]) }}">
                {{ $gateway['name'] }}
            </a>
        @endforeach
    </div>
</nav>
<div class="tab-content pl-2 pr-2 pt-3" id="nav-tabContent">
@include($data['view_name'], [
    'options' => $data['options'],
    'rec' => $data['settings']
    ])
</div>
@endsection

@section('innerPageJS')
<script>
   $(function() {      

       $('.selectPickerWithoutSearch').select2({
          theme: 'bootstrap4',
         minimumResultsForSearch: -1
      });
   
    
   });   
</script>
@endsection