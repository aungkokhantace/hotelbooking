@extends('layouts.master')
@section('title','Hotel Nearby Hospital')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_nearby_hospital) ? trans('setup_nearbyhospital.title-edit') : trans('setup_nearbyhospital.title-entry') }}</h1>

    @if(isset($hotel_nearby_hospital))
        {!! Form::open(array('url' => '/backend_mps/hotel_nearby_hospital/update','id'=>'hotel_nearby_hospital', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend_mps/hotel_nearby_hospital/store','id'=>'hotel_nearby_hospital', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_nearby_hospital)? $hotel_nearby_hospital->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">
                {{trans('setup_nearbyhospital.hotel')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_nearby_hospital))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $hotel_nearby_hospital->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_nearbyhospital.place-hotel')}}
                    </option>
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
            <label for="name">
                {{trans('setup_nearbyhospital.name')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="name" name="name"
                   placeholder="{{trans('setup_nearbyhospital.place-name')}}"
                   value="{{ isset($hotel_nearby_hospital)? $hotel_nearby_hospital->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="distance">
                {{trans('setup_nearbyhospital.place-distance')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="distance" name="distance"
                   placeholder="{{trans('setup_nearbyhospital.place-distance')}}"
                   value="{{ isset($hotel_nearby_hospital)? $hotel_nearby_hospital->distance:Request::old('distance') }}"/>
            <p class="text-danger">{{$errors->first('distance')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="remark">{{trans('setup_nearbyhospital.remark')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="{{trans('setup_nearbyhospital.place-remark')}}">{{ isset($hotel_nearby_hospital)? $hotel_nearby_hospital->remark:Request::old('remark') }}</textarea>
            <p class="text-danger">{{$errors->first('remark')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_nearby_hospital)? trans('setup_nearbyhospital.btn-update') : trans('setup_nearbyhospital.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_nearbyhospital.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_nearby_hospital')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //Start Validation for Entry and Edit Form
            $('#hotel_nearby_hospital').validate({
                rules: {
                    hotel_id      : 'required',
                    name          : 'required',
                    distance      : 'required',
                },
                messages: {
                    hotel_id      : 'Hotel is required!',
                    name          : 'Name is required!',
                    distance      : 'Distance is required!'
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