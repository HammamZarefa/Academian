@extends('setup.index')
@section('styles')

<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endsection

@section('content')

<!-- Page Heading -->

<h1 class="h3 mb-2 text-gray-800">Testimonial</h1>     
   
@if (session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<!-- DataTales Example -->

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <a href="{{ route('admin.testi.create') }}" class="btn btn-success">Create Testi</a>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                <thead>

                    <tr>

                        <th>No.</th>

                        <th>Photo</th>

                        <th>Name</th>

                        <th>Profession</th>

                        <th>Testimonial</th>

                        <th>Status</th>

                        <th>Option</th>

                    </tr>

                </thead>

                <tbody>

                @php
                
                $no=0;
                
                @endphp
                
                @foreach ($testi as $testi)
                     
                    <tr> 
             
                        <td>{{ ++$no }}</td>  
                
                        <td>
                            @if (!empty($testi->photo))
                            <img src="{{ asset('storage/'.$testi->photo) }}" alt="" style="height: 100px; width: 100px">
                            @else
                            <img src="{{ asset('storage/images/testi/avatar.png') }}" alt="" style="height: 100px; width: 100px">
                            @endif       

                        </td> 
                        
                        <td>{{ $testi->name }}</td> 
                        
                        <td>{{ $testi->profession }}</td>   

                        <td>{{ substr($testi->desc,0,50) }}...</td>   

                        <td>{{ $testi->status }}</td>

                        <td>    
                
                            <a href="{{route('admin.testi.edit', [$testi->id])}}" class="btn btn-info btn-sm"> Edit </a>
                
                            <form method="POST" action="{{route('admin.testi.destroy', [$testi->id])}}" class="d-inline" onsubmit="return confirm('Delete this testi permanently?')">
                
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