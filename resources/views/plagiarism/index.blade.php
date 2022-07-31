@extends('layouts.app')
@section('title', 'Post Category')
@section('content')

<form class="detect" action="{{route('detect')}}" method="post">
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
        <div class="form-group" >
        <label for="exampleFormControlTextarea1"><h3>Write Your Text To Detect Plgiarism Percent</h3></label>
        <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div>
            <select class="form-select" aria-label="Default select example" name="language">
                <option value="ar" >Arabic</option>
                <option value="en" selected >English</option>
                <option value="sp">Spanish</option>
            </select>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch"
            id="flexSwitchCheckDefault" name="scrapeSources">
            <label class="form-check-label" for="flexSwitchCheckDefault">scrape Sources</label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch"
            id="flexSwitchCheckDefault" name="includeCitations" >
            <label class="form-check-label" for="flexSwitchCheckDefault" >include Citations</label>
        </div>
            <button type="submit" class="btn btn-primary">Send Your Text</button>
</form>
@endsection
