@extends('layouts.master')
@section('title','Hotel')
@section('content')
        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel) ? trans('setup_hotel.title-edit') : trans('setup_hotel.title-entry') }}</h1>

    @if(isset($hotel))
        {{--  {!! Form::open(array('url' => '/backend_mps/hotel/update','files'=>true, 'id'=>'hotel', 'onsubmit'=>'return validate()', 'class'=> 'form-horizontal user-form-border')) !!}  --}}
        {!! Form::open(array('url' => '/backend_mps/hotel/update','files'=>true, 'id'=>'hotel', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend_mps/hotel/store','files'=>true, 'id'=>'hotel', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel)? $hotel->id:''}}" id="hidden_id"/>
    
    <br/>

    <div class="row">
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{trans('setup_hotel.name')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="name">{{trans('setup_hotel.name')}}<span class="require">*</span></label>
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="{{trans('setup_hotel.place-name')}}" value="{{ isset($hotel)? $hotel->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    {{-- </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_type_id">{{trans('setup_hotel.type')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="h_type_id">{{trans('setup_hotel.type')}}<span class="require">*</span></label>
            <select class="form-control" name="h_type_id" id="h_type_id">
                @if(isset($hotel))
                    @if($hotel->h_type_id == 1)
                        <option value="1" selected>Hotel</option>
                    @else
                        <option value="1">Hotel</option>
                    @endif
                    @if($hotel->h_type_id == 2)
                        <option value="2" selected>Motel</option>
                    @else
                        <option value="2">Motel</option>
                    @endif
                    @if($hotel->h_type_id == 3)
                        <option value="3" selected>Guest House</option>
                    @else
                        <option value="3">Guest House</option>
                    @endif
                    @if($hotel->h_type_id == 4)
                        <option value="4" selected>Inn</option>
                    @else
                        <option value="4">Inn</option>
                    @endif
                    @if($hotel->h_type_id == 5)
                        <option value="5" selected>Hostel</option>
                    @else
                        <option value="5">Hostel</option>
                    @endif
                @else
                    <option value="" disabled selected>{{trans('setup_hotel.place-type')}}</option>
                    <option value="1">Hotel</option>
                    <option value="2">Motel</option>
                    <option value="3">Guest House</option>
                    <option value="4">Inn</option>
                    <option value="5">Hostel</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_type_id')}}</p>
        </div>
    {{-- </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="address">{{trans('setup_hotel.address')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="star">{{trans('setup_hotel.star')}}<span class="require">*</span></label>
            <select class="form-control" name="star" id="star">
                @if(isset($hotel))
                    @if($hotel->star == 1)
                        <option value="1" selected>1</option>
                    @else
                        <option value="1">1</option>
                    @endif
                    @if($hotel->star == 2)
                        <option value="2" selected>2</option>
                    @else
                        <option value="2">2</option>
                    @endif
                    @if($hotel->star == 3)
                        <option value="3" selected>3</option>
                    @else
                        <option value="3">3</option>
                    @endif
                    @if($hotel->star == 4)
                        <option value="4" selected>4</option>
                    @else
                        <option value="4">4</option>
                    @endif
                    @if($hotel->star == 5)
                        <option value="5" selected>5</option>
                    @else
                        <option value="5">5</option>
                    @endif
                    @if($hotel->star == 6)
                        <option value="6" selected>6</option>
                    @else
                        <option value="6">6</option>
                    @endif
                    @if($hotel->star == 7)
                        <option value="7" selected>7</option>
                    @else
                        <option value="7">7</option>
                    @endif
                @else
                    <option value="" disabled selected>{{trans('setup_hotel.place-star')}}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('star')}}</p>
        </div>
    </div>

    <div class="row">
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="phone">{{trans('setup_hotel.phone')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="number_of_floors">{{trans('setup_hotel.floor')}}<span class="require">*</span></label>
            <select class="form-control" name="number_of_floors" id="number_of_floors">
                @if(isset($hotel))
                    @for ($i = 1; $i <= 100; $i++)
                        {{--<option value="{{ $i }}">{{ $i }}</option>--}}
                        @if($i == $hotel->number_of_floors)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                @else
                    @for ($i = 1; $i <= 100; $i++)
                        <option value="{{ $i }}"  @if(Request::old('number_of_floors') == $i) {{ 'selected' }} @endif>{{ $i }}</option>
                    @endfor
                @endif
            </select>
            <p class="text-danger">{{$errors->first('number_of_floors')}}</p>
        </div>
    {{-- </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="phone">{{trans('setup_hotel.phone')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="phone">{{trans('setup_hotel.phone')}}<span class="require">*</span></label>
            <input type="text" class="form-control" id="phone" name="phone"
                   placeholder="{{trans('setup_hotel.place-phone')}}" value="{{ isset($hotel)? $hotel->phone:Request::old('phone') }}"/>
            <p class="text-danger">{{$errors->first('phone')}}</p>
        </div>
    {{-- </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="fax">{{trans('setup_hotel.fax')}}</label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="fax">{{trans('setup_hotel.fax')}}</label>
            <input type="text" class="form-control" id="fax" name="fax"
                   placeholder="{{trans('setup_hotel.fax')}}" value="{{ isset($hotel)? $hotel->fax:Request::old('fax') }}"/>
            <p class="text-danger">{{$errors->first('fax')}}</p>
        </div>
    </div>

    <div class="row">
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="latitude">{{trans('setup_hotel.latitude')}}</label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="website">{{trans('setup_hotel.website')}}</label>
            <input type="text" class="form-control" id="website" name="website"
                   placeholder="{{trans('setup_hotel.place-website')}}" value="{{ isset($hotel)? $hotel->website:Request::old('website') }}"/>
            <p class="text-danger">{{$errors->first('website')}}</p>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="latitude">{{trans('setup_hotel.latitude')}}<span class="require">*</span></label>
            <input type="text" class="form-control" id="latitude" name="latitude"
                   placeholder="{{trans('setup_hotel.place-latitude')}}" value="{{ isset($hotel)? $hotel->latitude:Request::old('latitude') }}"/>
            <p class="text-danger">{{$errors->first('latitude')}}</p>
        </div>
   {{--  </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="longitude">{{trans('setup_hotel.longitude')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="longitude">{{trans('setup_hotel.longitude')}}<span class="require">*</span></label>
            <input type="text" class="form-control" id="longitude" name="longitude"
                   placeholder="{{trans('setup_hotel.place-longitude')}}" value="{{ isset($hotel)? $hotel->longitude:Request::old('longitude') }}"/>
            <p class="text-danger">{{$errors->first('longitude')}}</p>
        </div>
    </div>

    <div class="row">
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="country_id">{{trans('setup_hotel.country')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="country_id">{{trans('setup_hotel.country')}}<span class="require">*</span></label>
            <select class="form-control" name="country_id" id="country_id">
                @if(isset($hotel))
                    @foreach($countries as $country)
                        @if($country->id == $hotel->country_id)
                            <option value="{{$country->id}}" selected>{{$country->name}}</option>
                        @else
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>{{trans('setup_hotel.place-country')}}</option>
                    @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('country_id')}}</p>
        </div>
    {{-- </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="city_id">{{trans('setup_hotel.city')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="city_id">{{trans('setup_hotel.city')}}<span class="require">*</span></label>
            <select class="form-control" name="city_id" id="city_id">
                @if(isset($hotel))
                    @foreach($cities as $city)
                        @if($city->id == $hotel->city_id)
                            <option value="{{$city->id}}" selected>{{$city->name}}</option>
                        @else
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>{{trans('setup_hotel.place-city')}}</option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('city_id')}}</p>
        </div>
   {{--  </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="township_id">{{trans('setup_hotel.township')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="township_id">{{trans('setup_hotel.township')}}<span class="require">*</span></label>
            <select class="form-control" name="township_id" id="township_id">
                @if(isset($hotel))
                    @foreach($townships as $township)
                        @if($township->id == $hotel->township_id)
                            <option value="{{$township->id}}" selected>{{$township->name}}</option>
                        @else
                            <option value="{{$township->id}}">{{$township->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>{{trans('setup_hotel.place-township')}}</option>
                    @foreach($townships as $township)
                        <option value="{{$township->id}}">{{$township->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('township_id')}}</p>
        </div>
    </div>

    <div class="row">
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="check_in_time">{{trans('setup_hotel.check-in')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <label for="check_in_time">{{trans('setup_hotel.check-in')}}<span class="require">*</span></label>
            <div class="input-group bootstrap-timepicker timepicker">
            <input type="text" class="form-control" id="check_in_time" name="check_in_time"
                   placeholder="Enter Hotel Check-in Time" value="{{ isset($hotel)? $hotel->check_in_time:Request::old('check_in_time') }}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <p class="text-danger">{{$errors->first('check_in_time')}}</p>
        </div>
    {{-- </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="check_out_time">{{trans('setup_hotel.check-out')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <label for="check_out_time">{{trans('setup_hotel.check-out')}}<span class="require">*</span></label>
            <div class="input-group bootstrap-timepicker timepicker">
                <input type="text" class="form-control" id="check_out_time" name="check_out_time"
                       placeholder="Enter Hotel Check-out Time" value="{{ isset($hotel)? $hotel->check_out_time:Request::old('check_out_time') }}"/>
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <p class="text-danger">{{$errors->first('check_out_time')}}</p>
        </div>
    </div>

    <div class="row">
       {{--  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="breakfast_start_time">{{trans('setup_hotel.breakfast-start')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <label for="breakfast_start_time">{{trans('setup_hotel.breakfast-start')}}<span class="require">*</span></label>
            <div class="input-group bootstrap-timepicker timepicker">
            <input type="text" class="form-control" id="breakfast_start_time" name="breakfast_start_time"
                   placeholder="Enter Hotel Breakfast Start Time" value="{{ isset($hotel)? $hotel->breakfast_start_time:Request::old('breakfast_start_time') }}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <p class="text-danger">{{$errors->first('breakfast_start_time')}}</p>
        </div>
   {{--  </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="breakfast_end_time">{{trans('setup_hotel.breakfast-end')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <label for="breakfast_end_time">{{trans('setup_hotel.breakfast-end')}}<span class="require">*</span></label>
            <div class="input-group bootstrap-timepicker timepicker">
            <input type="text" class="form-control" id="breakfast_end_time" name="breakfast_end_time"
                   placeholder="Enter Hotel Breakfast End Time" value="{{ isset($hotel)? $hotel->breakfast_end_time:Request::old('breakfast_end_time') }}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <p class="text-danger">{{$errors->first('breakfast_end_time')}}</p>
        </div>
    </div>

    <div class="row">
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="address">{{trans('setup_hotel.address')}}<span class="require">*</span></label>
        </div> --}}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label for="address">{{trans('setup_hotel.address')}}<span class="require">*</span></label>
            <textarea rows="5" cols="50" class="form-control" id="address" name="address" placeholder="{{trans('setup_hotel.place-address')}}">{{ isset($hotel)? $hotel->address:Request::old('address') }}</textarea>
            <p class="text-danger">{{$errors->first('address')}}</p>
        </div>
    </div>

    <div class="row">
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">{{trans('setup_hotel.description')}}</label>
        </div> --}}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label for="description">{{trans('setup_hotel.description')}}</label>
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_hotel.place-description')}}">{{ isset($hotel)? $hotel->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    {{--Start File Upload--}}
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="photo" class="text_bold_black">{{trans('setup_hotel.logo')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
            <label class="notice">(Image must be 340*260 pixels)</label>
            @if(isset($hotel))
                <div class="add_image_div add_image_div_red" style="background-image: url({{'/images/upload/'.$hotel->logo}});background-position:center;background-size:cover">
                </div>
                <input type="hidden" id="removeImageFlag" value="0" name="removeImageFlag">
            @else
                <div class="add_image_div add_image_div_red">
                </div>
                <input type="hidden" id="removeImageFlag" value="0" name="removeImageFlag">
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="button" class="form-control image_remove_btn" value="Remove Image" id="removeImage" name="removeImage">
            <p class="text-danger">{{$errors->first('photo')}}</p>
        </div>
    </div>
    <br/>
    {{--End File Upload--}}

      {{--  @if(isset($hotel))
            @if($h_nearby_places->count()==0)
                @include('backend.hotel.nearby')
                @else
            @include('backend.hotel.nearby_edit')
            @endif
        @else
            @include('backend.hotel.nearby')
        @endif--}}

    {{--Start hotel admin--}}
    <div class="row">
        <div class="panel panel-primary">
        {{--Start Panel--}}
        <div class="panel-heading">
            <h3 class="panel-title">Hotel Admin</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label for="user_name">Staff Name<span class="require">*</span></label>
                </div> --}}
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label for="user_name">Staff Name<span class="require">*</span></label>
                    <input required type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Staff Login User Name" value="{{ isset($hotel_admin)? $hotel_admin->user_name:Request::old('user_name') }}"/>
                    <p class="text-danger">{{$errors->first('user_name')}}</p>
                </div>
            {{-- </div>

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label for="display_name">Display Name<span class="require">*</span></label>
                </div> --}}
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label for="display_name">Display Name<span class="require">*</span></label>
                    <input required type="text" class="form-control" id="display_name" name="display_name" placeholder="Enter Staff Display Name" value="{{ isset($hotel_admin)? $hotel_admin->display_name:Request::old('display_name') }}"/>
                    <p class="text-danger">{{$errors->first('display_name')}}</p>
                </div>
            {{-- </div>

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label for="email">Email<span class="require">*</span></label>
                </div> --}}
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label for="email">Email<span class="require">*</span></label>
                    <input required type="email" class="form-control" id="user_email" name="user_email" placeholder="Enter Staff Email" value="{{ isset($hotel_admin)? $hotel_admin->email:Request::old('user_email') }}"/>
                    <p class="text-danger">{{$errors->first('user_email')}}</p>
                </div>
            </div>

            @if(!isset($hotel_admin))
                <div class="row">
                    {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <label for="discount">Password<span class="require">*</span></label>
                    </div> --}}

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label for="discount">Password<span class="require">*</span></label>
                        <input required type="password" class="form-control" id="password" name="password" placeholder="Enter Password"/>
                        <p class="text-danger">{{$errors->first('password')}}</p>
                    </div>
                {{-- </div>

                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <label for="discount">Confirm Password<span class="require">*</span></label>
                    </div> --}}

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label for="discount">Confirm Password<span class="require">*</span></label>
                        <input required type="password" class="form-control" id="conpassword" name="conpassword" placeholder="Enter Confirm Password"/>
                        <p class="text-danger">{{$errors->first('conpassword')}}</p>
                    </div>
                </div>
            @endif

            <div class="row">
                {{--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label for="address">Address</label>
                </div> --}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="address">Address</label>
                    <textarea rows="4" cols="50"class="form-control" id="user_address" name="user_address" placeholder="Enter Staff Address">{{ isset($hotel_admin)? $hotel_admin->address:Request::old('user_address') }}</textarea>
                    {{--<p class="text-danger">{{$errors->first('user_address')}}</p>--}}
                </div>
            </div>
        </div>
        {{--End Panel--}}
    </div>
    </div>
    {{--End hotel admin--}}

    {{--Start Tab Panel--}}
    <div class="row">
        <div id="exTab2">
            <ul class="nav nav-tabs hotel">
                <li class="active">
                    <a  href="#1" data-toggle="tab">Hotel Config</a>
                </li>
                <li><a href="#2" data-toggle="tab">Hotel Landmark</a>
                </li>
                <li><a href="#3" data-toggle="tab">Hotel NearBy</a>
                </li>
                <li><a href="#4" data-toggle="tab">Hotel Feature</a>
                </li>
                <li><a href="#5" data-toggle="tab">Hotel Facility</a>
                </li>
                {{--  <li><a href="#6" data-toggle="tab">Hotel RoomType</a>
                </li>  --}}
            </ul>

            <div class="tab-content ">
                <div class="tab-pane active" id="1">
                        <div class="row">
                            {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <label for="hotel_id">{{trans('setup_hotelconfig.first-cancellation-day')}}<span class="require">*</span></label>
                            </div> --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="hotel_id">{{trans('setup_hotelconfig.first-cancellation-day')}}<span class="require">*</span></label>
                                <select class="form-control" name="first_cancellation_day" id="first_cancellation_day">
                                    @if(isset($hotel))
                                        @if(!empty($h_configs))
{{--                                        @foreach($h_configs as $h_config)--}}
                                            @for ($i = 1; $i <= 100; $i++)
{{--                                                    @if($i == $h_config->first_cancellation_day_count)--}}
                                                        <option value="{{ $i }}" @foreach($h_configs as $h_con) @if($i == $h_con->first_cancellation_day_count)selected @endif @endforeach>{{ $i }}</option>
                                                    {{--@endif--}}
                                            @endfor
                                        {{--@endforeach--}}
                                            @else
                                            <option value="" disabled selected>{{trans('setup_hotelconfig.place-first-cancellation-day')}}</option>
                                            @for ($i = 1; $i <= 100; $i++)
                                                <option value="{{ $i }}"  {{--@if(Request::old('first_cancellation_day') == $i) {{ 'selected' }} @endif--}}>{{ $i }}</option>
                                            @endfor
                                            @endif
                                    @else
                                        <option value="" disabled selected>{{trans('setup_hotelconfig.place-first-cancellation-day')}}</option>
                                        @for ($i = 1; $i <= 100; $i++)
                                            <option value="{{ $i }}"  @if(Request::old('first_cancellation_day') == $i) {{ 'selected' }} @endif>{{ $i }}</option>
                                        @endfor
                                    @endif
                                </select>
                                <p class="text-danger">{{$errors->first('first_cancellation_day')}}
                            </div>
                        {{-- </div>

                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <label for="hotel_id">{{trans('setup_hotelconfig.second-cancellation-day')}}<span class="require">*</span></label>
                            </div> --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="hotel_id">{{trans('setup_hotelconfig.second-cancellation-day')}}<span class="require">*</span></label>
                                <select class="form-control" name="second_cancellation_day" id="second_cancellation_day">
                                    @if(isset($hotel))
                                        @if(!empty($h_configs))
                                            @for ($i = 1; $i <= 100; $i++)
                                                {{--@foreach($h_configs as $h_con)--}}
{{--                                                    @if($i == $h_con->second_cancellation_day_count)--}}
                                                        <option value="{{ $i }}" @foreach($h_configs as $h_con) @if($i == $h_con->second_cancellation_day_count)selected @endif @endforeach>{{ $i }}</option>
                                                {{--@endif--}}
                                               {{-- @endforeach--}}
                                            @endfor
                                        @else
                                            <option value="" disabled selected>{{trans('setup_hotelconfig.place-second-cancellation-day')}}</option>
                                            @for ($i = 1; $i <= 100; $i++)
                                                <option value="{{ $i }}"  @if(Request::old('second_cancellation_day') == $i) {{ 'selected' }} @endif>{{ $i }}</option>
                                            @endfor
                                            @endif
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
                           {{--  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <label for="name">{{trans('setup_hotelconfig.breakfast-fees')}}<span class="require">*</span></label>
                            </div> --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="name">{{trans('setup_hotelconfig.breakfast-fees')}}<span class="require">*</span></label>
                                @if(isset($hotel))
                                    @if(!empty($h_configs))
                                    @foreach($h_configs as $h_config)
                                            <input type="text" class="form-control" id="breakfast_fees" name="breakfast_fees"
                                                   placeholder="{{trans('setup_hotelconfig.place-breakfast-fees')}}" @if($h_config->hotel_id == $hotel->id) value="{{number_format($h_config->breakfast_fees,2)}}"@endif/>
                                            <p class="text-danger">{{$errors->first('breakfast_fees')}}</p>
                                    @endforeach
                                        @else
                                        <input type="text" class="form-control" id="breakfast_fees" name="breakfast_fees"
                                               placeholder="{{trans('setup_hotelconfig.place-breakfast-fees')}}"/>
                                        <p class="text-danger">{{$errors->first('breakfast_fees')}}</p>
                                        @endif
                                    @else
                                    <input type="text" class="form-control" id="breakfast_fees" name="breakfast_fees"
                                           placeholder="{{trans('setup_hotelconfig.place-breakfast-fees')}}"/>
                                    <p class="text-danger">{{$errors->first('breakfast_fees')}}</p>
                                    @endif
                            </div>
                        {{-- </div>

                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <label for="name">{{trans('setup_hotelconfig.tax')}}(%)<span class="require">*</span></label>
                            </div> --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="name">{{trans('setup_hotelconfig.tax')}}(%)<span class="require">*</span></label>
                            @if(isset($hotel))
                                @if(!empty($h_configs))
                                    @foreach($h_configs as $h_config)
                                            <input type="text" class="form-control" id="tax" name="tax"
                                                   placeholder="{{trans('setup_hotelconfig.place-tax')}}" @if($h_config->hotel_id == $hotel->id) value="{{$h_config->tax}}" @endif/>
                                            <p class="text-danger">{{$errors->first('tax')}}</p>
                                            @endforeach
                                    @else
                                        <input type="text" class="form-control" id="tax" name="tax"
                                               placeholder="{{trans('setup_hotelconfig.place-tax')}}"/>
                                        <p class="text-danger">{{$errors->first('tax')}}</p>
                                    @endif

                                @else
                                    <input type="text" class="form-control" id="tax" name="tax"
                                           placeholder="{{trans('setup_hotelconfig.place-tax')}}"/>
                                    <p class="text-danger">{{$errors->first('tax')}}</p>
                                @endif
                                </div>
                        </div>
                    </div>
       <div class="tab-pane row" id="2">
          @if(isset($hotel))
             @if(isset($h_landmarks))
                   
                    @foreach($cities as $city)
                    <div class="panel panel-default">

                        @if(count($city->landmarks)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$city->name}}</h4>
                        </div>
                        <div class="panel-body">
                          @foreach($city->landmarks as $landmark)
                             <div class="col-md-4"> 
                               <input type="checkbox" name="landmark[]" value="{{$landmark->id}}" @foreach($h_landmarks as $land) @if($land->landmark_id == $landmark->id)checked @endif @endforeach>&nbsp &nbsp{{$landmark->name}}
                                 <br><br>
                              </div>
                          @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
             @else
                    @foreach($cities as $city)
                    <div class="panel panel-default">

                        @if(count($city->landmarks)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$city->name}}</h4>
                        </div>
                        <div class="panel-body">
                          @foreach($city->landmarks as $landmark)
                             <div class="col-md-4"> 
                               <input type="checkbox" name="landmark[]" value="{{$landmark->id}}" >&nbsp &nbsp{{$landmark->name}}
                                 <br><br>
                              </div>
                          @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
             @endif
        @else
             @foreach($cities as $city)
                    <div class="panel panel-default">

                        @if(count($city->landmarks)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$city->name}}</h4>
                        </div>
                        <div class="panel-body">
                          @foreach($city->landmarks as $landmark)
                             <div class="col-md-4"> 
                               <input type="checkbox" name="landmark[]" value="{{$landmark->id}}"  >&nbsp &nbsp{{$landmark->name}}
                                 <br><br>
                              </div>
                          @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
        @endif
                   
                </div>

   <!--   <div class="tab-pane row" id="2">
                    @if(isset($hotel))
                        @if(isset($h_landmarks))
                                @foreach($landmarks as $landmark)
                                    <div class="col-md-4">
                                        <input type="checkbox" name="landmark[]"  value="{{$landmark->id}}" @foreach($landmark->landmark_id as $land ) @if($land->landmark_id == $landmark->id)checked @endif @endforeach>&nbsp<strong>{{$landmark->name}}</strong>
                                        <br><br>
                                    </div>
                                    @endforeach
                            @else
                            @foreach($landmarks as $landmark)
                                <div class="col-md-4">
                                    <input type="checkbox" name="landmark[]" value="{{$landmark->id}}">&nbsp<strong>{{$landmark->name}}</strong>
                                    <br><br>
                                </div>
                            @endforeach
                            @endif
                        @else
                        @foreach($landmarks as $landmark)
                            <div class="col-md-4">
                                <input type="checkbox" name="landmark[]" value="{{$landmark->id}}">&nbsp<strong>{{$landmark->name}}</strong>
                                <br><br>
                            </div>
                        @endforeach
                    @endif
                </div> -->



                <div class="tab-pane row" id="3">
                
              @if(isset($hotel))
              @if(isset($h_nearby_places) && $h_nearby_places !==null && $h_nearby_places !=="")
                     @foreach($hotel_nearbyCate as $nearby_cate)
                       <div class="panel panel-default">
                        @if(count($nearby_cate->nearby)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$nearby_cate->name}}</h4>
                        </div>
                        <div class="panel-body">

                          @foreach($nearby_cate->nearby as $nearby)
                          <div class ="col-md-4">
                            <input type="checkbox" name="nearby_place[]" value="{{$nearby->id}}"  @foreach($h_nearby_places as $near) @if($near->nearby_id == $nearby->id) checked @endif @endforeach><strong>
                            &nbsp;{{$nearby->name}}</strong><br><br>

                            <input type="text" name="nearby_distance_{{$nearby->id}}"  class="form-control"
                             @foreach($h_nearby_places as $near) @if($near->nearby_id == $nearby->id) value="{{$near->km}}" @else placeholder="{{trans('setup_hotel.nearby-distance')}}" @endif @endforeach>
                                        <br><br>
                             </div>
                          @endforeach
                           </div>
                        @endif
                    </div>
                     @endforeach
                   @else

                         @foreach($hotel_nearbyCate as $nearby_cate)

                        <div class="panel panel-default">
                        @if(count($nearby_cate->nearby)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$nearby_cate->name}}</h4>
                        </div>
                        <div class="panel-body">

                          @foreach($nearby_cate->nearby as $nearby)
                          <div class ="col-md-4">
                            <input type="checkbox" name="nearby_place[]" value="{{$nearby->id}}" ><strong>
                            &nbsp;{{$nearby->name}}</strong><br><br>

                            <input type="text" name="nearby_distance_{{$nearby->id}}"  class="form-control" placeholder="Enter Distance Kilometer">
                            <br><br>
                          </div>
                          @endforeach
                         </div>
                        @endif
                    </div>
                     @endforeach
                  @endif
                  @else
                      @foreach($hotel_nearbyCate as $nearby_cate)

                        <div class="panel panel-default">
                        @if(count($nearby_cate->nearby)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$nearby_cate->name}}</h4>
                        </div>
                        <div class="panel-body">


                          @foreach($nearby_cate->nearby as $nearby)
                          <div class ="col-md-4">
                            <input type="checkbox" name="nearby_place[]" value="{{$nearby->id}}" ><strong>
                            &nbsp;{{$nearby->name}}</strong><br><br>

                            <input type="text" name="nearby_distance_{{$nearby->id}}"  class="form-control" placeholder="Enter Distance Kilometer">
                            <br><br>
                          </div>
                          @endforeach
                          </div>
                        @endif
                    </div>
                     @endforeach

                    @endif
                     <!-- @if(isset($hotel))
                        @if(isset($h_nearby_places))
{{--                            @foreach($h_nearby_places as $h_nearby_place)--}}
                                @foreach($hotel_nearby as $nearby)
                                    <div class="col-md-3">
                                        <input type="checkbox" name="nearby_place[]"  value="{{$nearby->id}}" @foreach($nearby->nearby_id as $near) @if($near->nearby_id == $nearby->id) checked @endif @endforeach><strong>
                                            &nbsp;{{$nearby->name}}</strong><br><br>
                                        <input type="text" name="nearby_distance_{{$nearby->id}}"  class="form-control"
                                               @foreach($nearby->nearby_id as $near) @if($near->nearby_id == $nearby->id) value="{{$near->km}}" @else placeholder="{{trans('setup_hotel.nearby-distance')}}" @endif @endforeach>
                                        <br><br>
                                    </div>
                                @endforeach
                            {{--@endforeach--}}
                            @else
                            @foreach($hotel_nearby as $nearby)
                                <div class="col-md-3">
                                    <input type="checkbox" name="nearby_place[]" value="{{$nearby->id}}"><strong>&nbsp;{{$nearby->name}}</strong><br><br>
                                    <input type="text" name="nearby_distance_{{$nearby->id}}" class="form-control" placeholder="Enter Distance Kilometer">
                                    <br><br>
                                </div>
                            @endforeach
                            @endif
                            @else
                                @foreach($hotel_nearby as $nearby)
                                    <div class="col-md-3">
                                        <input type="checkbox" name="nearby_place[]" value="{{$nearby->id}}"><strong>&nbsp;{{$nearby->name}}</strong><br><br>
                                        <input type="text" name="nearby_distance_{{$nearby->id}}" class="form-control" placeholder="Enter Distance Kilometer">
                                        <br><br>
                                    </div>
                            @endforeach
                            @endif-->
                </div> 
                <div class="tab-pane row" id="4">
                    @if(isset($hotel))
                        @if(!empty($h_feature))
                            @foreach($features as $feature)
                                <div class="col-md-12">
                                    <fieldset class="skill-border">
                                    <div class="col-md-12">
                                        <strong>{{$feature->name}}</strong>&nbsp;&nbsp;<input type="checkbox" id="checked-box" name="feature_id[]" value="{{$feature->id}}" @foreach($feature->feature_id as $fea ) @if($fea->feature_id == $feature->id)checked  @endif @endforeach>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="qty">{{trans('setup_hotelfeature.qty')}}</label>
                                        <input type="text" class="form-control" {{--id="quantity"--}} name="qty_{{$feature->id}}"
                                               @foreach($feature->feature_id as $fea)@if($fea->feature_id == $feature->id)value="{{$fea->qty}}" @else placeholder="{{trans('setup_hotelfeature.place-qty')}}" @endif @endforeach/>
                                        <p class="text-danger">{{$errors->first('qty')}}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="capacity">{{trans('setup_hotelfeature.capacity')}}</label>
                                        <input type="text" class="form-control" {{--id="capacity"--}} name="capacity_{{$feature->id}}"
                                               @foreach($feature->feature_id as $fea)@if($fea->feature_id == $feature->id)value="{{$fea->capacity}}" @else placeholder="{{trans('setup_hotelfeature.place-capacity')}}" @endif @endforeach/>
                                        <p class="text-danger">{{$errors->first('capacity')}}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="open_hour">{{trans('setup_hotelfeature.area')}}</label>
                                        <input type="text" class="form-control" {{--id="area"--}} name="area_{{$feature->id}}"
                                               @foreach($feature->feature_id as $fea)@if($fea->feature_id == $feature->id)value="{{$fea->area}}" @else placeholder="Enter Area" @endif @endforeach/>
                                        <p class="text-danger">{{$errors->first('area')}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="open_hour">{{trans('setup_hotelfeature.open')}}</label>
                                        <input type="text" class="form-control" {{--id="open_hour"--}} name="open_hour_{{$feature->id}}"
                                               @foreach($feature->feature_id as $fea)@if($fea->feature_id == $feature->id)value="{{$fea->open_hour}}" @else placeholder="Enter Open Hour" @endif @endforeach/>
                                        <p class="text-danger">{{$errors->first('open_hour')}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="close_hour">{{trans('setup_hotelfeature.close')}}</label>
                                        <input type="text" class="form-control" {{--id="close_hour"--}} name="close_hour_{{$feature->id}}"
                                               @foreach($feature->feature_id as $fea)@if($fea->feature_id == $feature->id)value="{{$fea->close_hour}}" @else placeholder="Enter Close Hour" @endif @endforeach />
                                        <p class="text-danger">{{$errors->first('close_hour')}}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="remark">{{trans('setup_hotelfeature.remark')}}</label>
                                        {{-- @foreach($feature->feature_id as $fea)
                                            @if($fea->feature_id == $feature->id)
                                            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark_{{$feature->id}}" placeholder="{{trans('setup_hotelfeature.place-remark')}}">{{$fea->remark}}</textarea>

                                            @endif
                                            @endforeach --}}

                                            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark_{{$feature->id}}" placeholder="{{trans('setup_hotelfeature.place-remark')}}"> @foreach($feature->feature_id as $fea)@if($fea->feature_id == $feature->id){{$fea->remark}} @endif @endforeach</textarea>



                                        <p class="text-danger">{{$errors->first('remark')}}</p>
                                    </div>
                                    </fieldset>
                                </div>
                            @endforeach
                            @else
                            @foreach($features as $feature)
                                <div class="col-md-12">
                                    <fieldset class="skill-border">
                                    <div class="col-md-12">
                                        <input type="checkbox" id="checked-box" name="feature_id[]" value="{{$feature->id}}"><strong>&nbsp;{{$feature->name}}</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="qty">{{trans('setup_hotelfeature.qty')}}</label>
                                        <input type="text" class="form-control" {{--id="quantity"--}} name="qty_{{$feature->id}}"
                                               placeholder="Enter Quantity"/>
                                        <p class="text-danger">{{$errors->first('qty')}}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="capacity">{{trans('setup_hotelfeature.capacity')}}</label>
                                        <input type="text" class="form-control" {{--id="capacity"--}} name="capacity_{{$feature->id}}"
                                               placeholder="{{trans('setup_hotelfeature.place-capacity')}}"/>
                                        <p class="text-danger">{{$errors->first('capacity')}}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="open_hour">{{trans('setup_hotelfeature.area')}}</label>
                                        <input type="text" class="form-control" {{--id="area"--}} name="area_{{$feature->id}}"
                                               placeholder="Enter Area"/>
                                        <p class="text-danger">{{$errors->first('area')}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="open_hour">{{trans('setup_hotelfeature.open')}}</label>
                                        <input type="text" class="form-control" {{--id="open_hour"--}} name="open_hour_{{$feature->id}}"
                                               placeholder="Enter Open Hour"/>
                                        <p class="text-danger">{{$errors->first('open_hour')}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="close_hour">{{trans('setup_hotelfeature.close')}}</label>
                                        <input type="text" class="form-control" {{--id="close_hour"--}} name="close_hour_{{$feature->id}}"
                                               placeholder="Enter Close Hour" />
                                        <p class="text-danger">{{$errors->first('close_hour')}}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="remark">{{trans('setup_hotelfeature.remark')}}</label>
                                        <textarea rows="5" cols="50" class="form-control" id="remark" name="remark_{{$feature->id}}" placeholder="{{trans('setup_hotelfeature.place-remark')}}"></textarea>
                                        <p class="text-danger">{{$errors->first('remark')}}</p>
                                    </div>
                                    </fieldset>
                                </div>
                            @endforeach
                            @endif

                        @else
                        @foreach($features as $feature)
                            <div class="col-md-12">
                                <fieldset class="skill-border">
                                <div class="col-md-12">
                                    <input type="checkbox" id="checked-box" name="feature_id[]" value="{{$feature->id}}"><strong>&nbsp;{{$feature->name}}</strong>
                                </div>
                                <div class="col-md-4">
                                    <label for="qty">{{trans('setup_hotelfeature.qty')}}</label>
                                    <input type="text" class="form-control" {{--id="quantity"--}} name="qty_{{$feature->id}}"
                                           placeholder="{{trans('setup_hotelfeature.place-qty')}}"/>
                                    <p class="text-danger">{{$errors->first('qty')}}</p>
                                </div>
                                <div class="col-md-4">
                                    <label for="capacity">{{trans('setup_hotelfeature.capacity')}}</label>
                                    <input type="text" class="form-control" {{--id="capacity"--}} name="capacity_{{$feature->id}}"
                                           placeholder="{{trans('setup_hotelfeature.place-capacity')}}"/>
                                    <p class="text-danger">{{$errors->first('capacity')}}</p>
                                </div>
                                <div class="col-md-4">
                                    <label for="open_hour">{{trans('setup_hotelfeature.area')}}</label>
                                    <input type="text" class="form-control" {{--id="area"--}} name="area_{{$feature->id}}"
                                           placeholder="Enter Area"/>
                                    <p class="text-danger">{{$errors->first('area')}}</p>
                                </div>
                                <div class="col-md-6">
                                    <label for="open_hour">{{trans('setup_hotelfeature.open')}}</label>
                                    <input type="text" class="form-control" {{--id="open_hour"--}} name="open_hour_{{$feature->id}}"
                                           placeholder="Enter Open Hour"/>
                                    <p class="text-danger">{{$errors->first('open_hour')}}</p>
                                </div>
                                <div class="col-md-6">
                                    <label for="close_hour">{{trans('setup_hotelfeature.close')}}</label>
                                    <input type="text" class="form-control" {{--id="close_hour"--}} name="close_hour_{{$feature->id}}"
                                           placeholder="Enter Close Hour" />
                                    <p class="text-danger">{{$errors->first('close_hour')}}</p>
                                </div>
                                <div class="col-md-12">
                                    <label for="remark">{{trans('setup_hotelfeature.remark')}}</label>
                                    <textarea rows="5" cols="50" class="form-control" id="remark" name="remark_{{$feature->id}}" placeholder="{{trans('setup_hotelfeature.place-remark')}}"></textarea>
                                    <p class="text-danger">{{$errors->first('remark')}}</p>
                                </div>
                                </fieldset>
                            </div>
                        @endforeach
                        @endif

                </div>
               <div class="tab-pane row" id="5">
                    @if(isset($hotel))
                        @if(isset($h_facility))
                       @foreach($facilitiesBygroup as $facilitiesGroup )
                        <div class="panel panel-default">
                        @if(count($facilitiesGroup->facility)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$facilitiesGroup->name}}</h4>
                        </div>
                        <div class="panel-body">
                            @foreach($facilitiesGroup->facility as $facility)
                                <div class="col-md-4">
                                    <input type="checkbox" name="facility_id[]" value="{{$facility->id}}" @foreach($h_facility as $fac) @if($fac->facility_id == $facility->id)checked @endif @endforeach><strong>
                                        {{$facility->name}}</strong>
                                    <br><br>
                                </div>
                            @endforeach
                        </div>
                        @endif
                      </div>
                      @endforeach
                    @else
                            @foreach($facilitiesBygroup as $facilitiesGroup )
                        <div class="panel panel-default">
                        @if(count($facilitiesGroup->facility)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$facilitiesGroup->name}}</h4>
                        </div>
                        <div class="panel-body">
                            @foreach($facilitiesGroup->facility as $facility)
                                <div class="col-md-4">
                                    <input type="checkbox" name="facility_id[]" value="{{$facility->id}}"><strong>
                                        {{$facility->name}}</strong>
                                    <br><br>
                                </div>
                            @endforeach
                        </div>
                        @endif
                      </div>
                      @endforeach
                @endif
                    @else
                        @foreach($facilitiesBygroup as $facilitiesGroup )
                        <div class="panel panel-default">
                        @if(count($facilitiesGroup->facility)>0)
                        <div class="panel-heading">
                         <h4 style="color:blue">{{$facilitiesGroup->name}}</h4>
                        </div>
                        <div class="panel-body">
                            @foreach($facilitiesGroup->facility as $facility)
                                <div class="col-md-4">
                                    <input type="checkbox" name="facility_id[]" value="{{$facility->id}}"><strong>
                                        {{$facility->name}}</strong>
                                    <br><br>
                                </div>
                            @endforeach
                        </div>
                        @endif
                      </div>
                      @endforeach
                    @endif
                </div>
                <!--
                <div class="tab-pane" id="6">
                    @if(isset($hotel))
                        @if(!empty($h_room_types))
                            <?php $i = 0;?>
                            @foreach($h_room_types as $h_room_type)

                            <div class="row div_facility">
                                <div class="col-lg-8 col-md-8 col-sm-8 div_border">
                                    <div class="col-md-4">
                                        <label for="name">{{trans('setup_hotelroomtype.name')}}</label>
                                        <input type="text" class="form-control room_type" {{-- id="name" --}} name="room_type[{{$i}}][name]" placeholder="{{trans('setup_hotelroomtype.place-name')}}" @if($h_room_type->hotel_id == $hotel->id) value="{{$h_room_type->name}}" @endif//>
                                        <p class="text-danger">{{$errors->first('name')}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description">{{trans('setup_hotelroomtype.description')}}</label>
                                        <textarea rows="5" cols="50" class="form-control room_type" {{-- id="description" --}} name="room_type[{{$i}}][description]" placeholder="{{trans('setup_hotelroomtype.place-description')}}">{{$h_room_type->description}}</textarea>
                                        <p class="text-danger">{{$errors->first('description')}}</p>
                                    </div>
                                </div>
                                @if($i != 0)
                                    <input type="button" class="btn btn-danger hotel_remove_btn" value="Remove">
                                @endif
                            </div>

                            <?php $i++;?>
                            @endforeach
                            <button type="button" class="btn btn-info" id="add_more_btn">Add More</button>
                        @else
                            <div class="row div_facility">
                                <div class="col-lg-8 col-md-8 col-sm-8 div_border">
                                    <div class="col-md-4">
                                        <label for="name">{{trans('setup_hotelroomtype.name')}}</label>
                                        <input type="text" class="form-control room_type" {{-- id="name" --}} name="room_type[0][name]" placeholder="{{trans('setup_hotelroomtype.place-name')}}"/>
                                        <p class="text-danger">{{$errors->first('name')}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description">{{trans('setup_hotelroomtype.description')}}</label>
                                        <textarea rows="5" cols="50" class="form-control room_type" {{-- id="description" --}} name="room_type[0][description]" placeholder="{{trans('setup_hotelroomtype.place-description')}}"></textarea>
                                        <p class="text-danger">{{$errors->first('description')}}</p>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info" id="add_more_btn">Add More</button>
                        @endif
                    @else
                        <div class="row div_facility">
                            <div class="col-lg-8 col-md-8 col-sm-8 div_border">
                                <div class="col-md-4">
                                    <label for="name">{{trans('setup_hotelroomtype.name')}}</label>
                                    <input type="text" class="form-control room_type" {{-- id="name" --}} name="room_type[0][name]" placeholder="{{trans('setup_hotelroomtype.place-name')}}"/>
                                    <p class="text-danger">{{$errors->first('name')}}</p>
                                </div>
                                <div class="col-md-6">
                                    <label for="description">{{trans('setup_hotelroomtype.description')}}</label>
                                    <textarea rows="5" cols="50" class="form-control room_type" {{-- id="description" --}} name="room_type[0][description]" placeholder="{{trans('setup_hotelroomtype.place-description')}}"></textarea>
                                    <p class="text-danger">{{$errors->first('description')}}</p>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info" id="add_more_btn">Add More</button>
                    @endif
                </div>
                -->
            </div>
        </div>
    </div>
    {{--End Tab Panel--}}

    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" value="{{isset($hotel)? trans('setup_hotel.btn-update') : trans('setup_hotel.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotel.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel')">
        </div>
    </div>

    {{--Start Modal--}}
    <div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Upload item image,</h4>
                    <p>Please ensure file is in .jpg, .png, .gif format.</p>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 380px; height: 220px;">

                                <img id='user_image_PopUp' src="" alt="Load Image"/>
                            </div>
                            <div data-provides="fileinput">
                        <span class="btn btn-default btn-file">
                            <span class="fileinput-new" data-trigger="fileinput">Select image</span>
                            <span class="fileinput-exists">Change</span>

                            <input id="photo" type="file" name="photo" accept="image.*" />
                            {{--{{ Form::file('nric_front_img') }}--}}
                        </span>
                                {{--<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>--}}
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="changeItemImage()" class="btn btn-default" data-dismiss="modal">Save</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-image-remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Remove Image !</h4>
                    <p>Please ensure you want to remove this image .</p>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        Are you sure want to remove this image ?
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="removeIMG()" class="btn btn-default" data-dismiss="modal">Yes</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="image_error_fileFormat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <label class="font-big-red">You can only upload a .jpg / jpeg / png / gif file format.</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="image_error_fileSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <label class="font-big-red">This is not an allowed file size !</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--End Modal--}}

    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">

        $(document).ready(function(){
            //console.log($('#user_email').val());
            $(':checkbox').checkboxpicker();
            //Start Validation for Entry and Edit Form
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
           
           

            $('#hotel').validate({
                rules: {
                    name                    : 'required',
                    address                 : 'required',
                    h_type_id               : 'required',
                    phone                   : 'required',
                    photo                   : 'required',
                    star                    : 'required',
                    country_id              : 'required',
                    city_id                 : 'required',
                    township_id             : 'required',
                    number_of_floors        : 'required',
                    hotel_class             : 'required',
                    website                 : 'url',
//                    'nearby_place[]'        : 'required',
//                    'nearby_distance[]'     : 'required',
                    check_in_time           : 'required',
                    check_out_time          : 'required',
                    breakfast_start_time    : 'required',
                    breakfast_end_time      : 'required',
                    latitude                : 'required',
                    longitude               : 'required',
              
                    user_name               : 'required',
                    display_name            : 'required',
                    
                    // user_email   	        : {
                    //     required 	: true,
                    //     email	 	: true,
                        
                    //     remote: {
                    //         url: "{{route('backend_mps/hotel/check_user_email')}}",
                    //         type: "get",
                    //         data:
                    //         {
                    //             email: function()
                    //             {
                                    
                    //                $('#user_email').val();
                    //             }
                    //         }
                    //     }
                     
                        
                    // },
                    

                    //  id             : {
                    //     required    : true,
                    //     email       : true,
                        
                    //     remote: {
                    //         url: "{{route('backend_mps/hotel/check_user_email')}}",
                    //         type: "get",
                    //         data:
                    //         {
                    //             hidden: function()
                    //             {
                                    
                    //                $('#hidden_id').val();
                    //             }
                    //         }
                    //     }
                     
                        
                    // },

                     
                    password                : 'required',
                    conpassword             : {
                        required: "true",
                        equalTo: "#password",
                    },
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
                    /*'qty[]'           : 'required',
                    'capacity[]'      : 'required',
                    'area[]'          : 'required',
                    'open_hour[]'     : 'required',
                    'close_hour[]'    : 'required',*/

                },
                messages: {
                    name                    : 'Name is required',
                    h_type_id               : 'Type is required',
                    address                 : 'Address is required',
                    phone                   : 'Phone is required',
                    photo                   : 'Photo is required',
                    star                    : 'Star is required',
                    country_id              : 'Country is required',
                    city_id                 : 'City is required',
                    township_id             : 'Township is required',
                    number_of_floors        : 'Number of Floors is required',
                    hotel_class             : 'Class is required',
                    website                 : 'Webite URL is not valid',
                    check_in_time           : 'Check-in Time is required',
                    check_out_time          : 'Check-out Time is required',
                    breakfast_start_time    : 'Breakfast Start Time is required',
                    breakfast_end_time      : 'Breakfast End Time is required',
                    latitude                : 'Latitude is required',
                    longitude               : 'Longitude is required',

                    user_name               : 'User Name is required',
                    display_name            : 'Display Name is required',
                    user_email     	        : {
                        required 	: 'Email is required',
                        email 	 	: 'Email is invalid format',
                        remote		: jQuery.validator.format("{0} is already taken.")
                    },
                    password                : 'Password is required',
                    conpassword             : {
                        required    : "Confirm Password is required",
                        equalTo     : "Password and Confirm Password must match.",
                    },
                    first_cancellation_day  : {
                        required    : 'First Cancellation Day Count is required',
                        greaterThan : "First Cancellation Day Count must be greater than Second Cancellation Day Count"
                    },
                    second_cancellation_day  : {
                        required    : 'Second Cancellation Day is required',
                        lessThan    : "Second Cancellation Day Count must be less than First Cancellation Day Count"
                    },
                    breakfast_fees          : {
                        required    : 'Breakfast Fee is required',
                        number      : 'Breakfast Fee must be numeric',
                    },
                    extrabed_fees           : {
                        required    : 'Extrabed Fee is required',
                        number      : 'Extrabed Fee must be numeric',
                    },
                    tax                     : {
                        required    : 'Tax is required',
                        number      : 'Tax must be numeric',
                        max         : 'Tax percentage should not be more than 100',
                    },
                   /* 'qty[]'           : 'Quantity is required',
                    'capacity[]'      : 'Capacity is required',
                    'area[]'          : 'Area is required',
                    'open_hour[]'     : 'Open Hour is required',
                    'close_hour[]'    : 'Close Hour is required',*/
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });



           /* $("[name *= qty]").each(function(){
                $(this).rules('add',{
                    required:true,
                    messages:{
                        required:'Quantity is required'
                    }
                });
            });
            $("[name *= capacity]").each(function(){
                $(this).rules('add',{
                    required:true,
                    messages:{
                        required:'Capacity is required'
                    }
                });
            });
            $("[name *= area]").each(function(){
                $(this).rules('add',{
                    required:true,
                    messages:{
                        required:'Area is required'
                    }
                });
            });
            $("[name *= open_hour]").each(function(){
                $(this).rules('add',{
                    required:true,
                    messages:{
                        required:'Open Hour is required'
                    }
                });
            });
            $("[name *= close_hour]").each(function(){
                $(this).rules('add',{
                    required:true,
                    messages:{
                        required:'Close Hour is required'
                    }
                });
            });*/
            //End Validation for Entry and Edit Form
            $('#nearby_place').change(function() {
                if ($("#nearby_place").val() ){
                    //if checkbox is checked- add the 'required' class
                    $("#nearby_distance").addClass('required');
                }else{
                    $("#nearby_distance").removeClass('required');
                }
            });

            //            Start fileupload js
            $(".add_image_div").click(function(){
                showPopup();
            });

            $("#removeImage").click(function(){
                $('#modal-image-remove').modal();
            });

            $('INPUT[type="file"]').change(function () {

                var ext = this.value.match(/\.(.+)$/)[1];
                var f=this.files[0];
                var fileSize = (f.size||f.fileSize);
                var imgkbytes = Math.round(parseInt(fileSize)/1024);

                if(imgkbytes > 5000){
                    $('#image_error_fileSize').modal('show');
                    //$('#user_image_PopUp').attr('src') = '';
                    $('#user_image_PopUp').attr('src','');
                    $('#user_image').val(null);
                }
                // else{
                switch (ext) {
                    case 'jpg':
                    case 'JPG':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        break;
                    default:
                        $('#image_error_fileFormat').modal('show');
                        //$('#user_image_PopUp').attr('src') = '';
                        $('#user_image_PopUp').attr('src','');
                        $('#user_image').val(null);
                }
                //}

            });
//            End fileupload js

            $('#check_in_time').timepicker();
            $('#check_out_time').timepicker();
            $('#breakfast_start_time').timepicker();
            $('#breakfast_end_time').timepicker();

            $('#country_id').change(function(e){
                load_city($(this).val());
            });

            $('#city_id').change(function(e){
                load_township($(this).val());
            });

            //For selectbox with search function
            $("#country_id").select2();

            //For selectbox with search function
            $("#city_id").select2();

             //For selectbox with search function
            $("#township_id").select2();

            /* Muti text box for hotel facilities */
            $('#add_more_btn').click(function() {
                var i = $('.room_type').size();
                $(this).before(
                    $("<div/>", {
                        class: 'row div_facility'
                    }).fadeIn('slow').append(
                        "<div class='col-md-8 div_border'>"+
                            "<div class='col-md-4'>"+
                                "<label for='name'>{{trans('setup_hotelroomtype.name')}}</label>"+
                                "<input type='text' class='form-control room_type' {{-- id='name' --}} name='room_type["+i+"][name]' placeholder='{{trans('setup_hotelroomtype.place-name')}}'/>"+
                                "<p class='text-danger'>{{$errors->first('name')}}</p>"+
                            "</div>"+
                            "<div class='col-md-6'>"+
                                "<label for='description'>{{trans('setup_hotelroomtype.description')}}</label>"+
                                "<textarea rows='5' cols='50' class='form-control room_type' {{-- id='description' --}} name='room_type["+i+"][description]' placeholder='{{trans('setup_hotelroomtype.place-description')}}'></textarea>"+
                                "<p class='text-danger'>{{$errors->first('description')}}</p>"+
                            "</div>"+
                        "</div>"
                    ).append(
                        $("<input>",{
                            type: 'button',
                            id: 'remove',
                            value: 'Remove',
                            class: 'btn btn-danger hotel_remove_btn'
                        }).click(function(){
                            //console.log($(this).parent());
                            $(this).parent().remove();
                        })
                    )
                );
            });
            /* Muti text box for hotel facilities */

            $('.hotel_remove_btn').click(function(){
                $(this).parent().remove();
            });
        });

        //start js function for fileupload
        function showPopup() {
            $('#modal-image').modal();
        }

        function changeItemImage(){
            var images = $('#modal-image img').attr('src');
            $('.add_image_div').css({"background-image": "url("+images+")", "background-position": "center","background-size":"cover"});
            $('#removeImageFlag').val(0);
        }

        function removeIMG(){
            $('#modal-image img').attr('src','second.jpg');
            $('.add_image_div').css('background-image', 'url()');
            $('#removeImageFlag').val(1);
        }
        //end js function for fileupload

        //start ajax functions
        function load_city(countryId){
            $.ajax({
                type: "GET",
                url: "/backend_mps/hotel/get_cities/"+countryId
            }).done(function( result ) {
                $("#city_id").empty();//To reset cities
                $("#city_id").append("<option selected disabled>Select City</option>");

                $("#township_id").empty();//To reset townships
                $("#township_id").append("<option selected disabled>Select Township</option>");

                $(result).each(function(){
                    $("#city_id").append($('<option>', {
                        value: this.id,
                        text: this.name,
                    }));
                })
            });
        }

        function load_township(cityId){
            $.ajax({
                type: "GET",
                url: "/backend_mps/hotel/get_townships/"+cityId
            }).done(function( result ) {
                $("#township_id").empty();//To reset townships
                $("#township_id").append("<option selected disabled>Select Township</option>");

                $(result).each(function(){
                    $("#township_id").append($('<option>', {
                        value: this.id,
                        text: this.name,
                    }));
                })
            });
        }
        //end ajax functions
    </script>
@stop
