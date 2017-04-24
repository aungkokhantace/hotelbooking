@extends('layouts.master')
@section('title','Hotel Restaurant')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_restaurant) ? trans('setup_hotelrestaurant.title-edit') : trans('setup_hotelrestaurant.title-entry') }}</h1>

    @if(isset($hotel_restaurant))
        {!! Form::open(array('url' => '/backend/hotel_restaurant/update','id'=>'hotel_restaurant', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_restaurant/store','id'=>'hotel_restaurant', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_restaurant)? $hotel_restaurant->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotelrestaurant.hotel')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_restaurant))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $hotel_restaurant->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_hotelrestaurant.place-hotel')}}
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
            <label for="hotel_restaurant_category">
                {{trans('setup_hotelrestaurant.category')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_restaurant_category" id="hotel_restaurant_category">
                @if(isset($hotel_restaurant))
                    @foreach($hotel_restaurant_category as $category)
                        @if($category->id == $hotel_restaurant->hotel_id)
                            <option value="{{$category->id}}" selected>{{$category->name}}</option>
                        @else
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_hotelrestaurant.place-category')}}
                    </option>
                    @foreach($hotel_restaurant_category as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('hotel_restaurant_category')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">
                {{trans('setup_hotelrestaurant.name')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="name" name="name"
                   placeholder="{{trans('setup_hotelrestaurant.place-name')}}"
                   value="{{ isset($hotel_restaurant)? $hotel_restaurant->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="opening_hours">
                {{trans('setup_hotelrestaurant.open-hr')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="opening_hours" name="opening_hours"
                   placeholder="{{trans('setup_hotelrestaurant.place-open-hr')}}" value="{{ isset($hotel_restaurant)? $hotel_restaurant->opening_hours:Request::old('opening_hours') }}"/>
            <p class="text-danger">{{$errors->first('opening_hours')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="opening_days">
                {{trans('setup_hotelrestaurant.open-day')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="opening_days" name="opening_days"
                   placeholder="{{trans('setup_hotelrestaurant.place-open-day')}}" value="{{ isset($hotel_restaurant)? $hotel_restaurant->opening_days:Request::old('opening_days') }}"/>
            <p class="text-danger">{{$errors->first('opening_days')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="capacity">{{trans('setup_hotelrestaurant.capacity')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="capacity" name="capacity"
                   placeholder="{{trans('setup_hotelrestaurant.open-capacity')}}"
                   value="{{ isset($hotel_restaurant)? $hotel_restaurant->capacity:Request::old('capacity') }}"/>
            <p class="text-danger">{{$errors->first('capacity')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="area">
                {{trans('setup_hotelrestaurant.area')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="area" name="area"
                   placeholder="{{trans('setup_hotelrestaurant.place-area')}}" value="{{ isset($hotel_restaurant)? $hotel_restaurant->area:Request::old('area') }}"/>
            <p class="text-danger">{{$errors->first('area')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="floor">
                {{trans('setup_hotelrestaurant.floor')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="floor" name="floor"
                   placeholder="{{trans('setup_hotelrestaurant.place-floor')}}"
                   value="{{ isset($hotel_restaurant)? $hotel_restaurant->floor:Request::old('floor') }}"/>
            <p class="text-danger">{{$errors->first('floor')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="private_room">
                {{trans('setup_hotelrestaurant.private')}}
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            @if(isset($hotel_restaurant))
                <input type="checkbox" id="private_room" name="private_room" value="true"
                        {{$hotel_restaurant->private_room == 1 ? 'checked':'' }}/>
            @else
                <input type="checkbox" id="private_room" name="private_room" value="true" />
            @endif
            <p class="text-danger">{{$errors->first('private_room')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">
                {{trans('setup_hotelrestaurant.description')}}
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_hotelrestaurant.place-description')}}">{{ isset($hotel_restaurant)? $hotel_restaurant->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="remark">{{trans('setup_hotelrestaurant.remark')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="{{trans('setup_hotelrestaurant.place-remark')}}">{{ isset($hotel_restaurant)? $hotel_restaurant->remark:Request::old('remark') }}</textarea>
            <p class="text-danger">{{$errors->first('remark')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_restaurant)? trans('setup_hotelrestaurant.btn-update') : trans('setup_hotelrestaurant.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotelrestaurant.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_restaurant')">
        </div>
    </div>

    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        var count = 0;      // Declaring and defining global increment variable.
        $(document).ready(function(){

            //Start Validation for Entry and Edit Form
            $('#hotel_restaurant').validate({
                rules: {
                    hotel_id                : 'required',
                    hotel_room_category     : 'required',
                    name                    : 'required',
                    opening_hours           : 'required',
                    opening_days            : 'required',
                    capacity                : 'required',
                    area                    : 'required',
                    floor                   : 'required',

                },
                messages: {
                    hotel_id                : 'Hotel is required!',
                    hotel_room_category     : 'Hotel Room Category is required!',
                    name                    : 'Restaurant Name is required!',
                    opening_hours           : 'Opening Hours is required!',
                    opening_days            : 'Opening Days is required!',
                    capacity                : 'Capacity is required!',
                    area                    : 'Area is required!',
                    floor                   : 'Floor is required!',
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