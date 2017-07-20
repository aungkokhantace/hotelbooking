@extends('layouts.master')
@section('title','Hotel')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel) ? trans('setup_hotel.title-edit') : trans('setup_hotel.title-entry') }}</h1>

    @if(isset($hotel))
        {!! Form::open(array('url' => '/backend/hotel/update','files'=>true, 'id'=>'hotel', 'onsubmit'=>'return validate()', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel/store','files'=>true, 'id'=>'hotel', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel)? $hotel->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{trans('setup_hotel.name')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="{{trans('setup_hotel.place-name')}}" value="{{ isset($hotel)? $hotel->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_type_id">{{trans('setup_hotel.type')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
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
            <p class="text-danger">{{$errors->first('country_id')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="address">{{trans('setup_hotel.address')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="address" name="address" placeholder="{{trans('setup_hotel.place-address')}}">{{ isset($hotel)? $hotel->address:Request::old('address') }}</textarea>
            <p class="text-danger">{{$errors->first('address')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="phone">{{trans('setup_hotel.phone')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="phone" name="phone"
                   placeholder="{{trans('setup_hotel.place-phone')}}" value="{{ isset($hotel)? $hotel->phone:Request::old('phone') }}"/>
            <p class="text-danger">{{$errors->first('phone')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="fax">{{trans('setup_hotel.fax')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="fax" name="fax"
                   placeholder="{{trans('setup_hotel.fax')}}" value="{{ isset($hotel)? $hotel->fax:Request::old('fax') }}"/>
            <p class="text-danger">{{$errors->first('fax')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="latitude">{{trans('setup_hotel.latitude')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="latitude" name="latitude"
                   placeholder="{{trans('setup_hotel.place-latitude')}}" value="{{ isset($hotel)? $hotel->latitude:Request::old('latitude') }}"/>
            <p class="text-danger">{{$errors->first('latitude')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="longitude">{{trans('setup_hotel.longitude')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="longitude" name="longitude"
                   placeholder="{{trans('setup_hotel.place-longitude')}}" value="{{ isset($hotel)? $hotel->longitude:Request::old('longitude') }}"/>
            <p class="text-danger">{{$errors->first('longitude')}}</p>
        </div>
    </div>

    {{--Start File Upload--}}
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="photo" class="text_bold_black">{{trans('setup_hotel.logo')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
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

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="star">{{trans('setup_hotel.star')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            {{--<input type="text" class="form-control" id="star" name="star"--}}
                   {{--placeholder="Enter Hotel Star" value="{{ isset($hotel)? $hotel->star:Request::old('star') }}"/>--}}
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

    {{--<div class="row">--}}
        {{--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">--}}
            {{--<label for="email">{{trans('setup_hotel.email')}}<span class="require">*</span></label>--}}
        {{--</div>--}}
        {{--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">--}}
            {{--<input type="text" class="form-control" id="email" name="email"--}}
                   {{--placeholder="{{trans('setup_hotel.place-email')}}" value="{{ isset($hotel)? $hotel->email:Request::old('email') }}"/>--}}
            {{--<p class="text-danger">{{$errors->first('email')}}</p>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="country_id">{{trans('setup_hotel.country')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
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
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="city_id">{{trans('setup_hotel.city')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
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
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="township_id">{{trans('setup_hotel.township')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">{{trans('setup_hotel.description')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_hotel.place-description')}}">{{ isset($hotel)? $hotel->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="number_of_floors">{{trans('setup_hotel.floor')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            {{--<input type="text" class="form-control" id="number_of_floors" name="number_of_floors"--}}
                   {{--placeholder="Enter Number of Floors" value="{{ isset($hotel)? $hotel->number_of_floors:Request::old('number_of_floors') }}"/>--}}
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
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_class">{{trans('setup_hotel.class')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="hotel_class" name="hotel_class"
                   placeholder="{{trans('setup_hotel.place-class')}}" value="{{ isset($hotel)? $hotel->class:Request::old('hotel_class') }}"/>
            <p class="text-danger">{{$errors->first('hotel_class')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="website">{{trans('setup_hotel.website')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="website" name="website"
                   placeholder="{{trans('setup_hotel.place-website')}}" value="{{ isset($hotel)? $hotel->website:Request::old('website') }}"/>
            <p class="text-danger">{{$errors->first('website')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="check_in_time">{{trans('setup_hotel.check-in')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="input-group bootstrap-timepicker timepicker">
            <input type="text" class="form-control" id="check_in_time" name="check_in_time"
                   placeholder="Enter Hotel Check-in Time" value="{{ isset($hotel)? $hotel->check_in_time:Request::old('check_in_time') }}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <p class="text-danger">{{$errors->first('check_in_time')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="check_out_time">{{trans('setup_hotel.check-out')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="input-group bootstrap-timepicker timepicker">
                <input type="text" class="form-control" id="check_out_time" name="check_out_time"
                       placeholder="Enter Hotel Check-out Time" value="{{ isset($hotel)? $hotel->check_out_time:Request::old('check_out_time') }}"/>
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <p class="text-danger">{{$errors->first('check_out_time')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="breakfast_start_time">{{trans('setup_hotel.breakfast-start')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="input-group bootstrap-timepicker timepicker">
            <input type="text" class="form-control" id="breakfast_start_time" name="breakfast_start_time"
                   placeholder="Enter Hotel Breakfast Start Time" value="{{ isset($hotel)? $hotel->breakfast_start_time:Request::old('breakfast_start_time') }}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <p class="text-danger">{{$errors->first('breakfast_start_time')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="breakfast_end_time">{{trans('setup_hotel.breakfast-start')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="input-group bootstrap-timepicker timepicker">
            <input type="text" class="form-control" id="breakfast_end_time" name="breakfast_end_time"
                   placeholder="Enter Hotel Breakfast End Time" value="{{ isset($hotel)? $hotel->breakfast_end_time:Request::old('breakfast_end_time') }}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            <p class="text-danger">{{$errors->first('breakfast_end_time')}}</p>
        </div>
    </div>

    @if(isset($hotel))
        @include('backend.hotel.nearby_edit')
    @else
        @include('backend.hotel.nearby')
    @endif

    {{--Start hotel admin--}}
    <div class="row">
        <div class="panel panel-primary">
        {{--Start Panel--}}
        <div class="panel-heading">
            <h3 class="panel-title">Hotel Admin</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label for="user_name">Staff Name<span class="require">*</span></label>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <input required type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Staff Login User Name" value="{{ isset($hotel_admin)? $hotel_admin->user_name:Request::old('user_name') }}"/>
                    <p class="text-danger">{{$errors->first('user_name')}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label for="display_name">Display Name<span class="require">*</span></label>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <input required type="text" class="form-control" id="display_name" name="display_name" placeholder="Enter Staff Display Name" value="{{ isset($hotel_admin)? $hotel_admin->display_name:Request::old('display_name') }}"/>
                    <p class="text-danger">{{$errors->first('display_name')}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label for="email">Email<span class="require">*</span></label>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <input required type="email" class="form-control" id="user_email" name="user_email" placeholder="Enter Staff Email" value="{{ isset($hotel_admin)? $hotel_admin->email:Request::old('user_email') }}"/>
                    <p class="text-danger">{{$errors->first('user_email')}}</p>
                </div>
            </div>

            @if(!isset($hotel_admin))
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <label for="discount">Password<span class="require">*</span></label>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <input required type="password" class="form-control" id="password" name="password" placeholder="Enter Password"/>
                        <p class="text-danger">{{$errors->first('password')}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <label for="discount">Confirm Password<span class="require">*</span></label>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <input required type="password" class="form-control" id="conpassword" name="conpassword" placeholder="Enter Confirm Password"/>
                        <p class="text-danger">{{$errors->first('conpassword')}}</p>
                    </div>
                </div>
            @endif

            {{--@if(isset($profile))--}}
                {{--<div class="row">--}}
                    {{--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">--}}
                        {{--<label for="discount">Password<span class="require">*</span></label>--}}
                    {{--</div>--}}

                    {{--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">--}}
                        {{--<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"/>--}}
                        {{--<p class="text-danger">{{$errors->first('password')}}</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label for="address">Address</label>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <textarea rows="4" cols="50"class="form-control" id="user_address" name="user_address" placeholder="Enter Staff Address">{{ isset($hotel_admin)? $hotel_admin->address:Request::old('user_address') }}</textarea>
                    {{--<p class="text-danger">{{$errors->first('user_address')}}</p>--}}
                </div>
            </div>
        </div>
        {{--End Panel--}}
    </div>
    </div>
    {{--End hotel admin--}}

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel)? trans('setup_hotel.btn-update') : trans('setup_hotel.btn-add')}}" class="form-control btn-primary">
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
            //Start Validation for Entry and Edit Form
            $('#hotel').validate({
                rules: {
                    name                    : 'required',
                    address                 : 'required',
                    h_type_id               : 'required',
                    phone                   : 'required',
                    photo                   : 'required',
                    star                    : 'required',
//                    email: {
//                        required: true,
//                        email: true
//                    },
                    country_id              : 'required',
                    city_id                 : 'required',
                    township_id             : 'required',
                    number_of_floors        : 'required',
                    hotel_class             : 'required',
                    website                 : 'url',
                    'nearby_place[]'        : 'required',
                    'nearby_distance[]'     : 'required',
                    check_in_time           : 'required',
                    check_out_time          : 'required',
                    breakfast_start_time    : 'required',
                    breakfast_end_time      : 'required',

                    user_name               : 'required',
                    display_name            : 'required',
                    user_email              : 'required',
                    password                : 'required',
                    conpassword             : {
                        required: "true",
                        equalTo: "#password",
                    },
                },
                messages: {
                    name                    : 'Name is required',
                    h_type_id               : 'Type is required',
                    address                 : 'Address is required',
                    phone                   : 'Phone is required',
                    photo                   : 'Photo is required',
                    star                    : 'Star is required',
//                    email: {
//                        required:'Email is required',
//                        email   : 'Email is not valid'
//                    },
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

                    user_name               : 'User Name is required',
                    display_name            : 'Display Name is required',
                    user_email              : 'User Email is required',
                    password                : 'Password is required',
                    conpassword             : {
                        required: "Confirm Password is required",
                        equalTo: "Password and Confirm Password must match.",
                    },
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form

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
                url: "/backend/hotel/get_cities/"+countryId
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
                url: "/backend/hotel/get_townships/"+cityId
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