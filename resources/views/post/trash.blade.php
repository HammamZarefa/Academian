@extends('layouts.app')
@section('title', 'Blog')
@section('content')

<!-- Page Heading -->

<h1 class="h3 mb-2 text-gray-800">Posts</h1>     
   
@if (session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<!-- DataTales Example -->

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <a href="{{ route('post.create') }}" class="btn btn-success">Create Post</a>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                <thead>

                    <tr>

                        <th>No.</th>

                        <th>Title</th>

                        <th>Keyword</th>

                        <th>Status</th>

                        <th>Option</th>

                    </tr>

                </thead>

                <tbody>

                @php
                
                $no=0;
                
                @endphp
                
                @foreach ($post as $post)
                     
                    <tr> 
             
                        <td>{{ ++$no }}</td>  
                
                        <td>{{ $post->title }}</td> 
                        
                        <td>{{ $post->category->name }}</td> 

                        <td>{{ $post->status }}</td> 
                
                        <td>    
                
                            <form method="POST" action="{{route('post.restore', $post->id)}}" class="d-inline">
                                @csrf
                                <input type="submit" value="Restore" class="btn btn-success btn-sm">
                            </form>
                
                            <form method="POST" action="{{route('post.deletePermanent', $post->id)}}" class="d-inline" onsubmit="return confirm('Delete this post permanently?')">

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

<script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>

@endpush