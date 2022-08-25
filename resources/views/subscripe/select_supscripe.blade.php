@extends('layouts.app')
@section('title')
@section('content')
    <section>
        <div style="text-align:center;">
            <h1>
                Subscription
            </h1>
        </div>
    </section>
    <section>
        <form action="{{route('subscripe',$online_service->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container py-3">
                <div class="card" style="text-align:center;">
                    <div class="card-header">
                        <h3>{{$online_service->name}}</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{format_money($online_service->price)}}/PerMonth</h4>
                        <p class="card-text">{{$online_service->desc}}</p>
                        <input id="submit" class="btn btn-primary" type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>
        $('#submit').on('click',function () {
            
        })
    </script>
@endsection
@endsection
