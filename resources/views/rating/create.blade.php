@extends('layouts.app')
@section('title', 'Your experience')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-8">
         <h4>{{ $order->number }} - Tell us about your experience</h4>
      </div>
      <div class="col-md-4">
         <div class="text-right">
            <span class="badge {{ $order->status->badge }}">{{ $order->status->name }}</span>
         </div>
      </div>
      <div class="col-md-12">
         <hr>
      </div>
      <div class="offset-md-2 col-md-8">
         <p class="bg-light text-dark p-2">
            We’ve got a short survey that we’d really appreciate you filling out. It’s so we can know what we’re doing well, and what we need to do better.
         </p>
         <form action="{{ route('ratings_store', $order->id) }}" method="POST">
            {{ csrf_field()  }}
            <div class="form-group">
               <label>Your rating</label>
               <div class="rating">
                  <input id="rating-5" type="radio" name="number" value="5"/>
                  <label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                  <input id="rating-4" type="radio" name="number" value="4" />
                  <label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                  <input id="rating-3" type="radio" name="number" value="3"/>
                  <label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                  <input id="rating-2" type="radio" name="number" value="2"/>
                  <label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                  <input id="rating-1" type="radio" name="number" value="1"/>
                  <label for="rating-1"><i class="fas fa-3x fa-star"></i></label>
               </div>

               <div class="invalid-feedback d-block">{{ showError($errors, 'number') }}</div>
            </div>
            <div class="form-group">
               <label>Your comment</label>
               <textarea class="form-control {{ showErrorClass($errors, 'comment') }}" name="comment"></textarea>

               <div class="invalid-feedback d-block">{{ showError($errors, 'comment') }}</div>
            </div>
            <button type="submit" class="btn btn-success">
            <i class="fas fa-check-circle"></i> Submit
            </button>
         </form>
      </div>
   </div>
</div>
@endsection