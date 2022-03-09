@extends('layouts.app')
@section('title', $order->number)
@section('content')
@php
    $route_name = Route::currentRouteName();
    $group_name = app('request')->input('group');
    $sub_group_name = app('request')->input('subgroup');
@endphp
<section class="header-account-page d-flex align-items-end navbar-background pt-80" data-offset-top="#header-main">
    <div class="container pt-4 pt-lg-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between">
                    <div><span class="h2 mb-0 text-white d-block">{{ $order->number }}</span></div>
                    <div>
                        <h5>Status: <span
                                class="badge {{ $order->status->badge }}">{{ $order->status->name }}</span></h5>
                    </div>
                </div>
                <!-- Salute + Small stats -->
                <div class="row align-items-center mb-4">
                    <div class="col-lg-8 col-xl-5 mb-4 mb-md-0">
                    </div>
                    <div class="col-auto flex-fill d-none d-xl-block">
                        <!-- Add content here -->
                    </div>
                </div>
                <!-- Account navigation -->
                <div class="d-flex">
                    @include('order.partials.navigation')
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container mb-p20">
    <br>
    @if($group_name == '')
        @include('order.partials.details')
    @elseif($group_name == 'messages')
        @include('order.partials.messages')
    @elseif($group_name == 'submitted-works')
        @include('order.partials.submitted_works')
    @elseif($group_name == 'financial')
        @include('order.partials.financial')
    @endif
</div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('select').select2({
                theme: 'bootstrap4'
            });
        });

        $('#delete_order').on('click', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            swal(href, 'Yes, Delete');
        });

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        function swal(url, $confirmButtonText) {
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: $confirmButtonText,
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    window.location.href = url;
                }
            })

        }

    </script>
    @yield('innerPageJs')
@endpush
