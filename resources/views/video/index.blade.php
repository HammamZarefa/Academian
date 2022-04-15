@extends('layouts.app')
@section('title', 'Video')
@section('content')

<style type="text/css">
   .toolbar {
    float: left;
}

</style>
 @include('setup.partials.action_toolbar', [
 'title' => 'Video',
 'hide_save_button' => TRUE,
 'create_link' => ['title' => 'Create video', 'url' => route("video.create")]

 ])
<table id="table" class="table table-striped nowrap">
  <thead>
     <tr>
        <th scope="col" style="width: 40%;">@lang('Title')</th>
        <th scope="col">@lang('Url')</th>
        <th scope="col" class="text-right">@lang('Action')</th>
     </tr>
  </thead>
    <tbody>
    @foreach ($videos as $video)
        <tr>
            <td>{{ $video->title }}</td>
            <td>{{$video->url}}</td>
            <td>
                <a href="{{route('video.edit', [$video->id])}}" class="btn btn-info btn-sm">@lang('Edit')  </a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Move Video to trash ?')" action="{{route('video.destroy', $video->id)}}">
                    @csrf
                    <input type="hidden" value="DELETE" name="_method">
                    <input type="submit" value="Trash" class="btn btn-danger btn-sm">
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
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
