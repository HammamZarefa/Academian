@extends('layouts.app')
@section('title', $data['title'])
@section('content')
<div class="container page-container" id="app">
 <h2>{{ $data['title'] }}</h2>
 <br>
  <order :services="{{ json_encode($data['service_id_list']) }}"
         :service_categories="{{json_encode($data['service_category_id_list']) }}"
:levels="{{ json_encode($data['work_level_id_list']) }}"
:urgencies="{{ json_encode($data['urgency_id_list']) }}"
:spacings="{{ json_encode($data['spacings_list']) }}"
:user_id="{{ (!Auth::guest()) ? auth()->user()->id : 'false' }}"
:add_to_cart_url="'{{ route('add_to_cart') }}'"
:restricted_order_page_url="'{{ route('order_page') }}'"
:create_account_url="'{{ route('register') }}'"
:upload_attachment_url="'{{ route('order_upload_attachment') }}'"
:additional_services_by_service_id_url= "'{{ route('additional_services_by_service_id') }}'"
:term_and_condition_url="'{{ route('terms_and_conditions') }}'"
:privacy_policy_url= "'{{ route('privacy_policy') }}'"
 ></order>
</div>
@endsection
