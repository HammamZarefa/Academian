@extends('layouts.app')
@section('title', 'Post Category')
@section('content')

<form class="detect" action="{{route('summarize.result')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <label for="exampleFormControlTextarea1"><h3>Text Befor Summarize</h3></label>
            <textarea name="text" class="form-control"
            id="exampleFormControlTextarea1" rows="4" cols="50" > {{ Request::old('text') }}
            </textarea>
            @isset($countRequest)
            <label for="exampleFormControlTextarea1"><h3>  Words Number: {{ $countRequest}}</h3></label>
            @endisset
        </div>
        <div class="col">
            @isset($countRequest)
            @isset($count)

            <label for="exampleFormControlTextarea1"><h3>Text After Summarize</h3></label>
            <textarea class="form-control" readonly
            id="exampleFormControlTextarea1" rows="4" cols="50">{{ $response['summary'] }}</textarea>
            <label for="exampleFormControlTextarea1"><h3>Words Number: {{ $count}}</h3></label>
            @endisset
            @endisset

        </div>
        </div>
        <div>
            <label for="exampleFormControlTextarea1"><h4>Select Language</h4></label>
            <select class="form-select" aria-label="Default select example" name="language">
                <option value="ar" >Arabic</option>
                <option value="en" selected >English</option>
                <option value="sp">Spanish</option>
            </select>
        </div>
        <div>
            <label for="exampleFormControlTextarea1"><h4>Select Output Sentences</h4></label>
            <select class="form-select" aria-label="Default select example" name="output_sentences">
                <option value= 1 >1</option>
                <option value= 2 selected >2</option>
                <option value= 3 >3</option>
            </select>
        </div>
            <button type="submit" class="btn btn-primary">Summarize</button>
</form>

@endsection
