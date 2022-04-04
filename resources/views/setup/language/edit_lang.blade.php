@extends('setup.index')

@push('style')
    <style>
        table.dataTable tbody tr td{
            white-space: normal;
        }
        @include('setup.partials.action_toolbar', [
 'title' => 'Services',
 'hide_save_button' => TRUE,
 'create_link' => ['title' => 'Create Service', 'url' => route("services_create")]

 ])
    </style>
@endpush
@section('panel')

    <div id="app">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row justify-content-between">
                            <div class="col-md-7">
                                <ul>
                                    <li>
                                        <h5>@lang('Language Keywords of') {{ __($code) }}</h5>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-5 mt-md-0 mt-3">
                                <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-sm btn--primary box--shadow1 text--small float-right"><i class="fa fa-plus"></i> @lang('Add New Key') </button>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light tabstyle--two custom-data-table white-space-wrap" id="myTable">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Key')
                                    </th>
                                    <th scope="col" class="text-left">
                                        {{__($code)}}
                                    </th>

                                    <th scope="col" class="w-85">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($json as $k => $lang)
                                    <tr>
                                        <td data-label="@lang('key')">{{$k}}</td>
                                        <td data-label="@lang('Value')" class="text-left white-space-wrap">{{$lang}}</td>


                                        <td data-label="@lang('Action')">
                                            <a href="javascript:void(0)"
                                               data-target="#editModal"
                                               data-toggle="modal"
                                               data-title="{{$k}}"
                                               data-key="{{$k}}"
                                               data-value="{{$lang}}"
                                               class="editModal icon-btn ml-1"
                                               data-original-title="@lang('Edit')">
                                                <i class="la la-pencil"></i>
                                            </a>

                                            <a href="javascript:void(0)"
                                               data-key="{{$k}}"
                                               data-value="{{$lang}}"
                                               data-toggle="modal" data-target="#DelModal"
                                               class="icon-btn btn--danger ml-1 deleteKey"
                                               data-original-title="@lang('Remove')">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"> @lang('Add New')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>

                    <form action="{{route('language.store.key',$code)}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="key" class="control-label font-weight-bold">@lang('Key')</label>
                                <input type="text" class="form-control form-control-lg " id="key" name="key" placeholder="@lang('Key')" value="{{old('key')}}">

                            </div>
                            <div class="form-group">
                                <label for="value" class="control-label font-weight-bold">@lang('Value')</label>
                                <input type="text" class="form-control form-control-lg" id="value" name="value" placeholder="@lang('Value')" value="{{old('value')}}">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary"> @lang('Save')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">@lang('Edit')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>

                    <form action="{{route('language.update.key',$code)}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group ">
                                <label for="inputName" class="control-label font-weight-bold form-title"></label>
                                <input type="text" class="form-control form-control-lg" name="value" placeholder="@lang('Value')" value="">
                            </div>
                            <input type="hidden" name="key">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary">@lang('Update')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Modal for DELETE -->
        <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class='fa fa-trash'></i> @lang('Delete')!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <strong>@lang('Are you sure you want to Delete?')</strong>
                    </div>
                    <form action="{{route('language.delete.key',$code)}}" method="post">
                        @csrf
                        <input type="hidden" name="key">
                        <input type="hidden" name="value">
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--danger ">@lang('Delete')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Import Language')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center text--danger">@lang('If you import keywords, Your current keywords will be removed and replaced by imported keyword')</p>
                        <div class="form-group">
                        <label for="key" class="control-label font-weight-bold">@lang('Key')</label>
                        <select class="form-control select_lang"  required>
                            <option value="">@lang('Import Keywords')</option>
                            {{--@foreach($list_lang as $data)--}}
                            {{--<option value="{{$data->id}}" @if($data->id == $la->id) class="d-none" @endif >{{__($data->name)}}</option>--}}
                            {{--@endforeach--}}
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="button" class="btn btn--primary import_lang"> @lang('Import Now')</button>
                </div>
            </div>
        </div>
    </div>
@stop


@push('breadcrumb-plugins')
<button type="button" class="btn btn-sm btn--primary box--shadow1 importBtn"><i class="la la-download"></i>@lang('Import Language')</button>
@endpush

@push('script')
    <script>
        (function($,document){
            "use strict";
            $('.deleteKey').on('click', function () {
                var modal = $('#DelModal');
                modal.find('input[name=key]').val($(this).data('key'));
                modal.find('input[name=value]').val($(this).data('value'));
            });
            $('.editModal').on('click', function () {
                var modal = $('#editModal');
                modal.find('.form-title').text($(this).data('title'));
                modal.find('input[name=key]').val($(this).data('key'));
                modal.find('input[name=value]').val($(this).data('value'));
            });


            $('.importBtn').on('click', function () {
                $('#importModal').modal('show');
            });
            $(document).on('click','.import_lang',function(){
                var id = $('.select_lang').val();

                if(id ==''){
                    iziToast.error({
                        message: 'Please Select a language to Import',
                        position: "topRight"
                    });

                    return 0;
                }else{
                    $.ajax({
                        type:"post",
                        url:"{{route('language.import_lang')}}",
                        data:{
                            id : id,
                            myLangid : "{{$code}}",
                            _token: "{{csrf_token()}}"
                        },
                        success:function(data){
                            console.log(data);

                            if (data == 'success'){
                                iziToast.success({
                                    message: 'Import Data Successfully',
                                    position: "topRight"
                                });

                                window.location.href = "{{url()->current()}}"
                            }
                        },
                        error:function(res){

                        }
                    });
                }

            });
        })(jQuery,document);


    </script>
@endpush
