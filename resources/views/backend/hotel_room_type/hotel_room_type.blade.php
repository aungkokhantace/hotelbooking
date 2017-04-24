@extends('layouts.master')
@section('title','Hotel Room Type')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_room_type) ? trans('setup_hotelroomtype.title-edit') : trans('setup_hotelroomtype.title-entry') }}</h1>

    @if(isset($hotel_room_type))
        {!! Form::open(array('url' => '/backend/hotel_room_type/update','id'=>'hotel_room_type', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_room_type/store','id'=>'hotel_room_type', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_room_type)? $hotel_room_type->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotelroomtype.hotel')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_room_type))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $hotel_room_type->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_hotelroomtype.place-hotel')}}
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
            <label for="name">{{trans('setup_hotelroomtype.name')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="name" name="name"
                   placeholder="{{trans('setup_hotelroomtype.place-name')}}" value="{{ isset($hotel_room_type)? $hotel_room_type->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">{{trans('setup_hotelroomtype.description')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_hotelroomtype.place-description')}}">{{ isset($hotel_room_type)? $hotel_room_type->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_restaurant_category)? trans('setup_hotelroomtype.btn-update') : trans('setup_hotelroomtype.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotelroomtype.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_room_type')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //Start Validation for Entry and Edit Form
            $('#hotel_room_type').validate({
                rules: {
                    hotel_id      : 'required',
                    name          : 'required',
                },
                messages: {
                    hotel_id      : 'Hotel is required',
                    name          : 'Name is required',
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