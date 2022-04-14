@extends('website.layouts.template1')
@section('content')
    {{--@include('website.partials.home_page_section_1')--}}
    {{--@include('website.partials.home_page_section_2')--}}
    {{--@include('website.partials.home_page_section_3')--}}
    {{--@include('website.partials.home_page_section_4')--}}
    @include('website.partials.home_page_section_5')
    @include('website.partials.home_page_section_6')
    <div class="text-center mb-100">
        <a href="{{ route('instant_quote') }}" class="boxed_btn">@lang('Calculate your order')</a>
    </div>
    @include('website.partials.home_page_section_7')
    @include('website.partials.home_page_section_10')
    @include('website.partials.home_page_section_8')
    @include('website.partials.home_page_section_9')
    @include('website.partials.home_page_section_12')
    @include('website.partials.home_page_section_11')
@endsection


