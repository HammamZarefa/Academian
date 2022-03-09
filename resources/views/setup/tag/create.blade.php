@extends('setup.index')
@section('title', 'Create Tag')
@section('setting_page')
@include('setup.partials.action_toolbar', [
 'title' => (isset($tag->id)) ? 'Edit tag' : 'Create new tag', 
 'hide_save_button' => TRUE,
 'back_link' => ['title' => 'back to tags', 'url' => route("tags_list")],
])

<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ (isset($tag->id)) ? route( 'tags_update', $tag->id) : route('tags_store') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   @if(isset($tag->id))
   {{ method_field('PATCH') }}
   @endif
   <div class="form-group">
      <label>Name <span class="required">*</span></label>
      <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, 'name') }}" name="name" value="{{ old_set('name', NULL, $tag) }}">
      <div class="invalid-feedback">{{ showError($errors, 'name') }}</div>
   </div>
   
   <input type="submit" name="submit" class="btn btn-success" value="Submit"/>
</form>

@endsection
