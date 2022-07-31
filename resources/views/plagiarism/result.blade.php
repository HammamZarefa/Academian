@extends('layouts.app')
@section('title', 'Post Category')
@section('content')
    <form role="form" class="form-horizontal" enctype="multipart/form-data"
          action="{{  route('post_category.store') }}"
          method="post" autocomplete="off">
        {{ csrf_field()  }}
            <label class="form-check-label" for="flexSwitchCheckDefault"><h3>Percent Plagiarism</h3></label>
{{--        @isset($newRes)--}}
        <div class="form-group">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $response['percentPlagiarism'] }}%;"
                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            {{ $response['percentPlagiarism'] }}%
                    </div>
                </div>
                <label class="form-check-label" for="flexSwitchCheckDefault">
                    <h3>Sources</h3>
                </label>
            @isset($response['sources'])
                @empty($response['sources'])
                    <span> <h3><p>
                        This text does not contain plagiarism </h3> </span>
                @endempty

            @foreach($response['sources'] as $source)

                  <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item" id="1">
                      <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <a href="{{ $source['url'] }}">{{ $source['url'] }}</a>
                        </button>
                      </h2>
                      <div id="flush-collapseOne" class="accordion-collapse collapse"
                      aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                      <label class="form-check-label" for="flexSwitchCheckDefault"><h4>title :</h4></label>
                      {{  $source['title'] }}
                          @foreach ( $source['matches'] as $index=>$matches )
                        <div class="accordion-body">
                            <div class="card">
                                <div class="card-header">
                                  match text {{ $index + 1}}
                                </div>
                                <div class="card-body">
                                    <footer class="blockquote-footer">{{ $matches['matchText'] }}</footer>
                                </div>
                            </div>
                        </div>
                          @endforeach
                      </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endisset
{{--        @endisset--}}
    </form>
@endsection


