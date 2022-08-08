@extends('layouts.app')
@section('title', 'Post Category')
@section('content')
    <div class="container Summarize">
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
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="col-md-4 p-0">
                        <select class="form-select" aria-label="Default select example" name="language">
                            <option value="ar" >Arabic</option>
                            <option value="en" selected >English</option>
                            <option value="sp">Spanish</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="col-md-4 p-0">
                        <div class="form-check form-switch d-flex align-items-center">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   id="flexSwitchCheckDefault" name="scrapeSources">
                            <label class="form-check-label" for="flexSwitchCheckDefault">scrape Sources</label>
                        </div>
                    </div>
                    <div class="col-md-4 p-0">
                        <div class="form-check form-switch d-flex align-items-center">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   id="flexSwitchCheckDefault" name="includeCitations" >
                            <label class="form-check-label" for="flexSwitchCheckDefault" >include Citations</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-group" >
                        <label for="exampleFormControlTextarea1"><h3>Write Your Text To Detect Plgiarism Percent</h3></label>
                        <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-Create">Send Your Text</button>
                </div>
            </div>

        </form>
    </div>
@endsection