@extends('layouts.master')
@section('title','Hotel Config')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_config) ? trans('setup_hotelconfig.title-edit') : trans('setup_hotelconfig.title-entry')}}</h1>

    @if(isset($hotel_config))
        {!! Form::open(array('url' => '/backend/hotel_config/update','id'=>'hotel_config', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_config/store','id'=>'hotel_config', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_config)? $hotel_config->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotelconfig.hotel')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_config))
                    <option value="{{$hotel_config->hotel_id}}" selected>{{$hotel_config->hotel->name}}</option>
                @else
                    <option value="" disabled selected>{{trans('setup_hotelconfig.place-hotel')}}</option>
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('hotel_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotelconfig.first-cancellation-day')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="first_cancellation_day" id="first_cancellation_day">
                @if(isset($hotel_config))
                    @for ($i = 1; $i <= 100; $i++)
                        @if($i == $hotel_config->first_cancellation_day_count)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                @else
                    <option value="" disabled selected>{{trans('setup_hotelconfig.place-first-cancellation-day')}}</option>
                    @for ($i = 1; $i <= 100; $i++)
                        <option value="{{ $i }}"  @if(Request::old('first_cancellation_day') == $i) {{ 'selected' }} @endif>{{ $i }}</option>
                    @endfor
                @endif
            </select>
            <p class="text-danger">{{$errors->first('first_cancellation_day')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotelconfig.second-cancellation-day')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="second_cancellation_day" id="second_cancellation_day">
                @if(isset($hotel_config))
                    @for ($i = 1; $i <= 100; $i++)
                        @if($i == $hotel_config->second_cancellation_day_count)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                @else
                    <option value="" disabled selected>{{trans('setup_hotelconfig.place-second-cancellation-day')}}</option>
                    @for ($i = 1; $i <= 100; $i++)
                        <option value="{{ $i }}"  @if(Request::old('second_cancellation_day') == $i) {{ 'selected' }} @endif>{{ $i }}</option>
                    @endfor
                @endif
            </select>
            <p class="text-danger">{{$errors->first('second_cancellation_day')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{trans('setup_hotelconfig.breakfast-fees')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="breakfast_fees" name="breakfast_fees"
                   placeholder="{{trans('setup_hotelconfig.place-breakfast-fees')}}" value="{{ isset($hotel_config)? $hotel_config->breakfast_fees:Request::old('breakfast_fees') }}"/>
            <p class="text-danger">{{$errors->first('breakfast_fees')}}</p>
        </div>
    </div>

    {{--<div class="row">--}}
        {{--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">--}}
            {{--<label for="name">{{trans('setup_hotelconfig.extrabed-fees')}}<span class="require">*</span></label>--}}
        {{--</div>--}}
        {{--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">--}}
            {{--<input type="text" class="form-control" id="extrabed_fees" name="extrabed_fees"--}}
                   {{--placeholder="{{trans('setup_hotelconfig.place-extrabed-fees')}}" value="{{ isset($hotel_config)? $hotel_config->extrabed_fees:Request::old('extrabed_fees') }}"/>--}}
            {{--<p class="text-danger">{{$errors->first('extrabed_fees')}}</p>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{trans('setup_hotelconfig.tax')}}(%)<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="tax" name="tax"
                   placeholder="{{trans('setup_hotelconfig.place-tax')}}" value="{{ isset($hotel_config)? $hotel_config->tax:Request::old('tax') }}"/>
            <p class="text-danger">{{$errors->first('tax')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_config)? trans('setup_hotelconfig.btn-update') : trans('setup_hotelconfig.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotelconfig.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_config')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            $.validator.addMethod("greaterThan",
                    function (value, element, param) {
                        var $otherElement = $(param);
                        return parseInt(value, 10) > parseInt($otherElement.val(), 10);
                });

            $.validator.addMethod("lessThan",
                    function (value, element, param) {
                        var $otherElement = $(param);
                        return parseInt(value, 10) < parseInt($otherElement.val(), 10);
                    });

            //Start Validation for Entry and Edit Form
            $('#hotel_config').validate({
                rules: {
                    hotel_id                : 'required',
                    first_cancellation_day  : {
                        required   : true,
                        greaterThan: "#second_cancellation_day"
                    },
                    second_cancellation_day  : {
                        required   : true,
                        lessThan: "#first_cancellation_day"
                    },
                    breakfast_fees          : {
                        required: true,
                        number  : true,
                    },
                    extrabed_fees           : {
                        required: true,
                        number  : true,
                    },
                    tax                     : {
                        required: true,
                        number  : true,
                        max     : 100,
                    },
                },
                messages: {
                    hotel_id                : 'Hotel is required!',
                    first_cancellation_day  : {
                        required   : 'First Cancellation Day Count is required',
                        greaterThan: "First Cancellation Day Count must be greater than Second Cancellation Day Count"
                    },
                    second_cancellation_day  : {
                        required   : 'Second Cancellation Day is required',
                        lessThan   : "Second Cancellation Day Count must be less than First Cancellation Day Count"
                    },
                    breakfast_fees          : {
                        required: 'Breakfast Fee is required',
                        number  : 'Breakfast Fee must be numeric',
                    },
                    extrabed_fees           : {
                        required: 'Extrabed Fee is required',
                        number  : 'Extrabed Fee must be numeric',
                    },
                    tax                     : {
                        required: 'Tax is required',
                        number  : 'Tax must be numeric',
                        max     : 'Tax percentage should not be more than 100',
                    },
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form
        });
    </script>
@stop