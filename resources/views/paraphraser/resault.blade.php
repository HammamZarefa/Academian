@extends('layouts.app')
@section('title', 'Post Category')
@section('content')
    <form role="form" class="form-horizontal" enctype="multipart/form-data"
          action="{{  route('post_category.store') }}"
          method="post" autocomplete="off" >
        {{ csrf_field()  }}
        <div class="row">
            <div class="col">
                <label for="exampleFormControlTextarea1"><h3>Text Befor Paraphrasing</h3></label>

                <textarea name="text" class="form-control"
                id="exampleFormControlTextarea1" rows="4" cols="50" >
    </textarea>
      </div>
            <div class="col">
                <label for="exampleFormControlTextarea1"><h3>Text After Paraphrasing</h3></label>
@isset($newRes)
                <textarea name="text" class="form-control" readonly
                id="exampleFormControlTextarea1" rows="4" cols="50" >{{ $newRes['rewrite'] }}</textarea>
            </div>
          </div>

            <label class="form-check-label" for="flexSwitchCheckDefault"><h3>Similarity</h3></label>
            <div class="form-group">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $newRes['similarity'] * 100}}%;" aria-valuenow="0" aria-valuemin="25" aria-valuemax="100">{{ $newRes['similarity'] }}%</div>
                </div>
        @endisset
        </div>
    </form>
@endsection
{{-- @push('scripts') --}}
{{-- <script>
    function setSelectionRange(start, end ) {
        let str = "fahed";
  const input = document.getElementById('strong');
        consol.write.input;
        consol.write.str;
//   input.focus();
let detect = input.slice(start, end); --}}
{{-- // document.str.write(<strong> + detect + </strong>)
    }

</script> --}}
{{-- @endpush --}}


