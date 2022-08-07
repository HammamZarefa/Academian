@extends('layouts.app')
@section('title', 'Post Category')
@section('content')


<form class="detect" action="{{route('paraphrase.result')}}" method="post" enctype="multipart/form-data">
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
            <label for="exampleFormControlTextarea1"><h3>Text Befor Paraphrasing</h3></label>
            <textarea name="text" class="form-control"
            id="exampleFormControlTextarea1" rows="4" cols="50" > {{ Request::old('text') }}
            </textarea>
            <label for="exampleFormControlTextarea1"><h3>Words Number: @isset($countRequest){{ $countRequest}}@endisset</h3></label>

        </div>
        <div class="col">
            <label for="exampleFormControlTextarea1"><h3>Text After Paraphrasing</h3></label>
            <textarea class="form-control" readonly
            id="exampleFormControlTextarea1" rows="4" cols="50">@isset($response){{ $response['rewrite'] }}@endisset</textarea>
            <label for="exampleFormControlTextarea1"><h3>Words Number: @isset($count){{ $count}}@endisset</h3></label>

        </div>
        </div>
    @isset($response)
    <label class="form-check-label" for="flexSwitchCheckDefault"><h3>Similarity</h3></label>
    <div class="form-group">
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ $response['similarity'] * 100}}%;" aria-valuenow="0" aria-valuemin="25" aria-valuemax="100">{{ $response['similarity'] }}%</div>
        </div>
    </div>
    @endisset
        <div>
            <label for="exampleFormControlTextarea1"><h4>Select Language</h4></label>
            <select class="form-select" aria-label="Default select example" name="language">
                <option value="ar" >Arabic</option>
                <option value="en" selected >English</option>
                <option value="sp">Spanish</option>
            </select>
        </div>
        <div>
            <label for="exampleFormControlTextarea1"><h4>Select Strength</h4></label>
            <select class="form-select" aria-label="Default select example" name="strength">
                <option value="1" >1</option>
                <option value="2" selected >2</option>
                <option value="3">3</option>
            </select>
        </div>
            <button type="submit" class="btn btn-primary">Paraphrase</button>
</form>
@endsection
