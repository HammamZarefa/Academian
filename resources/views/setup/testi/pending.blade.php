@extends('setup.index')
@section('styles')

<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endsection

@section('content')

<!-- Page Heading -->

<h1 class="h3 mb-2 text-gray-800">Pending Reviews</h1>
   
@if (session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<!-- DataTales Example -->

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                <thead>

                    <tr>

                        <th>No.</th>

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

                        
                        <td>{{ $testi->name }}</td> 
                        
                        <td>{{ $testi->profession }}</td>   

                        <td>{{ substr($testi->desc,0,50) }}...</td>   

                        <td>{{ $testi->status }}</td>

                        <td>    
                
                            <a href="{{route('admin.testi.changestatus', [$testi->id,'PUBLISH'])}}" class="btn btn-info btn-sm"> Approve </a>
                            <a href="{{route('admin.testi.changestatus', [$testi->id,'DRAFT'])}}" class="btn btn-info btn-sm"> Disapprove </a>

                
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