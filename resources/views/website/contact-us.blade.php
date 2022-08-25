@extends('website.layouts.template')
@section('title')
    Blog -
@endsection

@section('content')
    <main>
        <section class="contact-us">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        @if(Session::has('message'))
                            <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{!! session('message') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <h2 class="title">@lang('Get in touch with us today to learn more.')</h2>
                    </div>
                    <div class="col-sm-6 con1">
                        <img src="{{ asset('front/img/Contact Us Page Image.jpg') }}" alt="">
                    </div>
                    <div class="col-sm-6 con2">
                        <form id="request" class="row suscribe" action="{{route('handle_email_query')}}" method="post"
                              accept-charset="utf-8">
                            {{ csrf_field()  }}
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="@lang('Name')" name="name">
                                <input type="email" class="form-control" placeholder="@lang('Email')" name="email">
                            </div>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="@lang('Message')" name="phone">
                                <div class="seclector"
                                     style="margin: 0 0 0 auto;margin-bottom: 0px;width: 401px;margin-bottom: 25px;">
                                    <div style="font-weight: bold;">Select degree program</div>
                                    <i class="fas fa-angle-down"></i>
                                    <ul class="option">
                                        <li>Select degree program</li>
                                        @foreach($work_levels as $level)
                                            <li>{{$level->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-default text-center">@lang('Submit') </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- end Slider -->
    </main>
@endsection