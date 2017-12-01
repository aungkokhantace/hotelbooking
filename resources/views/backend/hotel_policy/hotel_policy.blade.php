@extends('layouts.master')
@section('title','Hotel Policy')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_policy) ? trans('setup_hotelpolicy.title-edit') : trans('setup_hotelpolicy.title-entry')}}</h1>

    @if(isset($hotel_policy))
        {!! Form::open(array('url' => '/backend_mps/hotel_policy/update','id'=>'hotel_policy', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}

    @else
        {!! Form::open(array('url' => '/backend_mps/hotel_policy/store','id'=>'hotel_policy', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_policy)? $hotel_policy->id:0}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotelpolicy.hotel')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            @if ($role == 3)
            <select class="form-control" name="hotel_id" id="hotel_id">
                @foreach($hotels as $hotel)
                <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                @endforeach
                </select>
            @else
                <!-- @foreach($hotels as $hotel)
                    @if($hotel_id == $hotel->id)
                    <select class="form-control" name="hotel_id" id="hotel_id">
                            <option value="{{$hotel->id}}" selected >{{$hotel->name}}</option>
                    </select>
                    @endif
                @endforeach -->
                @if(isset($hotel_policy))
                    <select class="form-control" name="hotel_id" id="hotel_id">
                            <option value="{{$hotel_policy->id}}" selected >{{$hotel_policy->hotel->name}}</option>
                    </select>
                @else
                    @foreach($hotels as $hotel)
                        @if($hotel_id == $hotel->id)
                        <select class="form-control" name="hotel_id" id="hotel_id">
                                <option value="{{$hotel->id}}" selected >{{$hotel->name}}</option>
                        </select>
                        @endif
                    @endforeach
                @endif
            @endif
            <p class="text-danger">{{$errors->first('hotel_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description" class="text_bold_black">Hotel Policy</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <textarea class="form-control" id="policy" name="policy" placeholder="Enter Hotel Policy" rows="5" cols="50">{{ isset($hotel_policy)? $hotel_policy->policy:Request::old('policy') }}</textarea>
            <p class="text-danger">{{$errors->first('policy')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <!-- <input type="submit" name="submit" value="{{isset($hotel)? trans('setup_hotelpolicy.btn-update') : trans('setup_hotelpolicy.btn-add')}}" class="form-control btn-primary"> -->
            <input type="submit" name="submit" value="{{isset($hotel_policy)? trans('setup_hotelpolicy.btn-update') : trans('setup_hotelpolicy.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotelpolicy.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_policy')">
        </div>
    </div>

    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        var count = 0;      // Declaring and defining global increment variable.
        $(document).ready(function(){
          $('#policy').summernote({
              height:300,
              toolbar: [
                  // [groupName, [list of button]]
                  ['style', ['style']],
                  ['style', ['bold', 'italic', 'underline', 'clear']],
                  ['font', ['strikethrough', 'superscript', 'subscript']],
                  ['fontsize', ['fontsize']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['height', ['height']],
                  ['picture', ['picture']],
                  ['link', ['link']],
                  ['table', ['table']],
                  ['hr', ['hr']],
                  ['codeview', ['codeview']],
                  ['undo', ['undo']],
                  ['redo', ['redo']],
//                ['help', ['help']],
              ]
          });

            //Start Validation for Entry and Edit Form
            $('#hotel_policy').validate({
                rules: {
                    hotel_id            : 'required',
                    policy              : 'required',
                },
                messages: {
                    hotel_id            : 'Hotel is required',
                    policy              : 'Hotel policy is required!',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form

            $(':checkbox').checkboxpicker();
        });
    </script>
@stop
