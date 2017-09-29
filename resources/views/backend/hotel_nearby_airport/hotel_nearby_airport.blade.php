@extends('layouts.master')
@section('title','Hotel Nearby Airport')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_nearby_airport) ? trans('setup_nearbyairport.title-edit') : trans('setup_nearbyairport.title-entry') }}</h1>

    @if(isset($hotel_nearby_airport))
        {!! Form::open(array('url' => '/backend_mps/hotel_nearby_airport/update','id'=>'hotel_nearby_airport', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend_mps/hotel_nearby_airport/store','id'=>'hotel_nearby_airport', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_nearby_airport)? $hotel_nearby_airport->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">
                {{trans('setup_nearbyairport.hotel')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_nearby_airport))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $hotel_nearby_airport->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_nearbyairport.place-hotel')}}
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
                {{trans('setup_nearbyairport.name')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="name" name="name"
                   placeholder="{{trans('setup_nearbyairport.place-name')}}"
                   value="{{ isset($hotel_nearby_airport)? $hotel_nearby_airport->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="distance">
                {{trans('setup_nearbyairport.distance')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="distance" name="distance"
                   placeholder="{{trans('setup_nearbyairport.place-distance')}}"
                   value="{{ isset($hotel_nearby_airport)? $hotel_nearby_airport->distance:Request::old('distance') }}"/>
            <p class="text-danger">{{$errors->first('distance')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="remark">{{trans('setup_nearbyairport.remark')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="{{trans('setup_nearbyairport.place-remark')}}">{{ isset($hotel_nearby_airport)? $hotel_nearby_airport->remark:Request::old('remark') }}</textarea>
            <p class="text-danger">{{$errors->first('remark')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_nearby_airport)? trans('setup_nearbyairport.btn-update'): trans('setup_nearbyairport.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_nearbyairport.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_nearby_airport')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //Start Validation for Entry and Edit Form
            $('#hotel_nearby_airport').validate({
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