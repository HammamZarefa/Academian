@extends('setup.index')
@section('title', 'Post Tag')
@section('setting_page')

<style type="text/css">
   .toolbar {
    float: left;
}

</style>
@include('setup.partials.action_toolbar', [
 'title' => 'Post Tag',
 'hide_save_button' => TRUE,
 'create_link' => ['title' => 'Create Post Tag', 'url' => route("post_tag.create")]

 ])
<table id="table" class="table table-striped">
  <thead>
     <tr>
        <th scope="col" >@lang('Name')</th>
        <th scope="col" >@lang('Slug')</th>
        <th scope="col">@lang('Keywords')</th>
         <th scope="col">@lang('Meta Desc')</th>
        <th scope="col" class="text-right">@lang('Action')</th>
     </tr>
  </thead>


{{--<script>--}}
    {{--$(function(){       --}}

        {{--var oTable = $('#table').DataTable({--}}
          {{--"bLengthChange": false,--}}
            {{--"dom": '<"toolbar">frtip',--}}
            {{--"bSort" : false,--}}
            {{--processing: true,--}}
            {{--serverSide: true,                           --}}
            {{--"ajax": {--}}
                    {{--"url": "{!! route('datatable_service_category') !!}",--}}
                    {{--"type": "POST",--}}
                    {{--'headers': {--}}
                        {{--'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
                    {{--},--}}
                    {{--"data": function ( d ) {--}}

                    {{--}--}}
            {{--},--}}
            {{--columns: [                              --}}
                {{--{data: 'name', name: 'name'},                                   --}}
                {{--{data: 'desc', name: 'desc', className: "text-right"},--}}
                {{--{data: 'image', name: 'image'},--}}
                {{--{data: 'action', name: 'action', className: "text-right"},                --}}
                {{----}}
            {{--]--}}
        {{--});--}}

        {{--// var checkbox = '<div class="form-check" style="margin-right:20px;">';--}}
        {{--// checkbox +='<input class="form-check-input" type="checkbox" value="1" id="showInactive">';--}}
        {{--// checkbox +='<label class="form-check-label" for="showInactive">';--}}
        {{--// checkbox +='Include Inactive items';--}}
        {{--// checkbox +='</label>';--}}
        {{--// checkbox +='</div>';--}}

        {{--// var createButton = '<a class="btn btn-sm btn-primary" href="{{ route("service_category_create") }}">New Service Category</a>';--}}

        {{--// var toolbar = '<div class="d-flex flex-row">' + checkbox + '</div>';--}}

        {{--$("div.toolbar").html(toolbar);--}}
      {{----}}
        {{--$('#table').on('click', '.delete-item', function (e) {--}}
               {{----}}
            {{--e.preventDefault();--}}
            {{--runSwal($(this).attr("href"));--}}

        {{--});--}}

        {{--// $('#showInactive').change(function () {--}}
        {{--//     oTable.draw();--}}
        {{--// });--}}

       {{----}}


        {{----}}

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
{{--@endpush--}}
<tbody>
@php

    $no=0;

@endphp
@foreach ($tags as $tag)

    <tr>
        <td>{{ $tag->name }}</td>

        <td>{{ $tag->slug }}</td>

        <td>{{ $tag->keyword }}</td>

        <td>{{ $tag->meta_desc }}</td>

        <td>

            <a href="{{route('post_tag.edit', [$tag->id])}}" class="btn btn-info btn-sm">@lang('Edit')  </a>

            <form method="POST" action="{{route('post_tag.destroy', [$tag->id])}}" class="d-inline" onsubmit="return confirm('Delete this tag permanently?')">

                @csrf

                <input type="hidden" name="_method" value="DELETE">

                <input type="submit" value="Delete" class="btn btn-danger btn-sm">

            </form>

        </td>

    </tr>

@endforeach
</tbody>

</table>

</div>

</div>

</div>
@endsection
@push('scripts')
