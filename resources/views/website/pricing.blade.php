@extends('website.layouts.template')
@section('title', 'Pricing')
@section('content')
<div class="bradcam_area breadcam_bg overlay2">
   <h3>Pricing</h3>
</div>
<div class="about_area">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <pricing 
               :services="{{ json_encode($data['services']) }}"
               :work_levels="{{ json_encode($data['work_levels']) }}"
               :pricings="{{ json_encode($data['pricings']) }}"
               :currency_symbol="'{{ Purifier::clean(settings('currency_symbol')) }}'"
               ></pricing>
         </div>
      </div>
   </div>
</div>
@endsection
