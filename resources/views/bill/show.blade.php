@extends('layouts.app')
@section('title', $bill->number)
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-12">
         <h4>{{ $bill->number }}</h4>
         <hr>
      </div>
      <div class="col-md-9">
         @include('bill.partials.details')
      </div>
      <div class="col-md-3">
         @role('admin') 
            @if($bill->paid)
            <form action="{{ route('bill_mark_as_unpaid', $bill->id) }}" method="POST" autocomplete="off">
               {{ csrf_field()  }}  
               <button type="submit" class="btn btn-light btn-lg btn-block">
               <i class="far fa-check-circle"></i> Mark as unpaid</button>
            </form>
            <div class="text-center form-text text-muted">
               Payment Date: <br>
               {{ $bill->paid->format('d-M-Y') }}
            </div>
            @else
            <form action="{{ route('bill_mark_as_paid', $bill->id) }}" method="POST" autocomplete="off">
               {{ csrf_field()  }}  
               <button type="submit" class="btn btn-success btn-lg btn-block">
               <i class="far fa-check-circle"></i> Mark as paid</button>
            </form>
            @endif
         @endrole
      </div>
   </div>
</div>
@endsection

