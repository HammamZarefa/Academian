@extends('setup.index')
@section('content')

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<form action="{{ route('admin.testi.update',$testi->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="container">

        <div class="form-group ml-5">

            <label for="Photo" class="col-sm-2 col-form-label">Photo</label>

            <div class="col-sm-7">

                <input type="file" name='photo' class="form-control {{$errors->first('photo') ? "is-invalid" : "" }} " value="{{old('photo') ? old('photo') : $testi->photo}}" id="photo">

                <div class="invalid-feedback">
                    {{ $errors->first('photo') }}    
                </div>   

            </div>

        </div>

        <div class="form-group ml-5">

            <label for="name" class="col-sm-2 col-form-label">Name</label>

            <div class="col-sm-7">

                <input type="text" name='name' class="form-control {{$errors->first('name') ? "is-invalid" : "" }} " value="{{old('name') ? old('name') : $testi->name}}" id="name">

                <div class="invalid-feedback">
                    {{ $errors->first('name') }}    
                </div>    

            </div>

        </div>

        <div class="form-group ml-5">

            <label for="profession" class="col-sm-2 col-form-label">Profession</label>

            <div class="col-sm-7">

                <input type="text" name='profession' class="form-control {{$errors->first('profession') ? "is-invalid" : "" }} " value="{{old('profession') ? old('profession') : $testi->profession}}" id="profession">

                <div class="invalid-feedback">
                    {{ $errors->first('profession') }}    
                </div>    

            </div>

        </div>

        <div class="form-group ml-5">

            <label for="desc" class="col-sm-2 col-form-label">Testi</label>

            <div class="col-sm-7">

                <textarea name="desc" class="form-control {{$errors->first('desc') ? "is-invalid" : "" }} "  id="" cols="30" rows="10">{{old('desc') ? old('desc') : $testi->desc}}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('desc') }}    
                </div>   

            </div>

        </div>


        <div class="form-group ml-5">

            <label for="status" class="col-sm-2 col-form-label">Status</label>

            <div class="col-sm-7">

                <select name='status' class="form-control {{$errors->first('status') ? "is-invalid" : "" }} " id="status">
                    <option {{$testi->status == 'PUBLISH' ? 'selected' : ''}} value="PUBLISH">PUBLISH</option>
 
                    <option {{$testi->status == 'DRAFT' ? 'selected' : ''}} value="DRAFT">DRAFT</option>
                </select>

                <div class="invalid-feedback">
                    {{ $errors->first('status') }}    
                </div>   

            </div>

        </div>
   
        <div class="form-group ml-5">
   
            <div class="col-sm-3">
   
                <button type="submit" class="btn btn-primary">Update</button>
   
            </div>
   
        </div>

    </div>      

  </form>
@endsection
