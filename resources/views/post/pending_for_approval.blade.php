@extends('layouts.app')
@section('title', 'Blog')
@section('content')

    <style type="text/css">
        .toolbar {
            float: left;
        }

    </style>
    @include('setup.partials.action_toolbar', [
    'title' => 'Blog',
    'hide_save_button' => TRUE,
    'create_link' => ['title' => 'Create Post', 'url' => route("post.create")]

    ])
    <div class="container">
    <table id="table" class="table table-striped nowrap">
        <thead>
        <tr>
            <th scope="col" style="width: 40%;">@lang('Title')</th>
            <th scope="col">@lang('Keyword')</th>
            <th scope="col">@lang('Category')</th>
            <th scope="col">@lang('Status')</th>
            <th scope="col" class="text-right">@lang('Action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{$post->keyword}}</td>
                <td>{{ $post->category->name }}</td>
                <td>{{ $post->status }}</td>
                <td>
                    <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure? ?')" action="{{route('post.approve', $post->id)}}">
                        @csrf
                        <input type="hidden" value="DELETE" name="_method">
                        <button type="submit" class="btn btn-success btn-sm">
                        <i class="far fa-thumbs-up"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endsection
{{--@section('innerPageJS')--}}
{{--<script>--}}
{{--$(function(){       --}}

{{--var oTable = $('#table').DataTable({--}}
{{--responsive: true,--}}
{{--"bLengthChange": false,--}}
{{--"dom": '<"toolbar">frtip',--}}
{{--"bSort" : false,--}}
{{--processing: true,--}}
{{--serverSide: true,                           --}}
{{--"ajax": {--}}
{{--"url": "{!! route('post.datatable') !!}",--}}
{{--"type": "POST",--}}
{{--'headers': {--}}
{{--'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
{{--},--}}
{{--"data": function ( d ) {--}}
{{--if ($("#showInactive").is(":checked")) --}}
{{--{  --}}
{{--d.include_inactive_items = 1;--}}
{{--}               --}}
{{--}--}}
{{--},--}}
{{--columns: [                              --}}
{{--{data: 'title', name: 'title'},--}}
{{--{data: 'price_type', name: 'price_type'},--}}
{{--{data:'category',name:'service_category'},--}}
{{--{data: 'status', name: 'status'},--}}
{{--{data: 'action', name: 'action', className: "text-right"},--}}
{{----}}
{{--]--}}
{{--});--}}

{{--var checkbox = '<div class="form-check" style="margin-right:20px;">';--}}
{{--checkbox +='<input class="form-check-input" type="checkbox" value="1" id="showInactive">';--}}
{{--checkbox +='<label class="form-check-label" for="showInactive">';--}}
{{--checkbox +='Include Inactive items';--}}
{{--checkbox +='</label>';--}}
{{--checkbox +='</div>';--}}

{{--var createButton = '<a class="btn btn-sm btn-primary" href="{{ route("services_create") }}">New Service</a>';--}}

{{--var toolbar = '<div class="d-flex flex-row">' + checkbox  + '</div>';--}}

{{--$("div.toolbar").html(toolbar);    --}}

{{----}}
{{--$('#table').on('click', '.delete-item', function (e) {--}}
{{----}}
{{--e.preventDefault();--}}
{{--runSwal($(this).attr("href"));--}}

{{--});--}}

{{--$('#showInactive').change(function () {--}}
{{--oTable.draw();--}}
{{--});--}}

{{--});   --}}

{{--function runSwal($link_to_delete)--}}
{{--{--}}
{{--Swal.fire({--}}
{{--title: 'Are you sure?',--}}
{{--text: "You won't be able to revert this!",--}}
{{--icon: 'warning',--}}
{{--showCancelButton: true,--}}
{{--confirmButtonColor: '#3085d6',--}}
{{--cancelButtonColor: '#d33',--}}
{{--confirmButtonText: 'Yes, delete it!'--}}
{{--}).then((result) => {--}}
{{--if (result.value) {--}}
{{--window.location = $link_to_delete;--}}
{{--}--}}
{{--});--}}

{{--}   --}}
{{--</script>--}}
