@extends('setup.index')
@section('title', 'Website SEO')
@section('setting_page')
<form role="form" class="form-horizontal" enctype="multipart/form-data" action="{{ route('patch_seo') }}" method="post" autocomplete="off" >
   {{ csrf_field()  }}
   {{ method_field('PATCH') }}
   @include('setup.partials.action_toolbar', ['title' => 'Website SEO'])
	
	@foreach($data as $pageName=>$metas)
	<h4>{{ ucfirst(str_replace('_', ' ', $pageName)) }}</h4>
    	@foreach($metas as $meta)
    		<div class="form-group">
               <label>{{ ucwords(str_replace('_', ' ', str_replace(['_'.$pageName],'', $meta))) }}</label>               
               <input type="text" class="form-control form-control-sm {{ showErrorClass($errors, $meta) }}" name="{{ $meta }}" value="{{ old_set($meta, NULL, $record)  }}">
               <div class="invalid-feedback d-block">{{ showError($errors, $meta) }}</div>
            </div>
    	@endforeach
    
    @endforeach
    
     
    
</form>
@endsection