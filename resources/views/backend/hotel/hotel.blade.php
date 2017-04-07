@extends('layouts.master')
@section('title','Hotel')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel) ?  'Hotel Edit' : 'Hotel Entry' }}</h1>

    @if(isset($hotel))
        {!! Form::open(array('url' => '/backend/hotel/update','files'=>true, 'id'=>'hotel', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel/store','files'=>true, 'id'=>'hotel', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel)? $hotel->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Enter Hotel Name" value="{{ isset($hotel)? $hotel->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_type_id">Type<span class="require">*</span></label>
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
                    <option value="" disabled selected>Select Type</option>
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
            <label for="address">Address<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="address" name="address" placeholder="Enter Hotel Address">{{ isset($hotel)? $hotel->address:Request::old('address') }}</textarea>
            <p class="text-danger">{{$errors->first('address')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="phone">Phone<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="phone" name="phone"
                   placeholder="Enter Hotel Phone" value="{{ isset($hotel)? $hotel->phone:Request::old('phone') }}"/>
            <p class="text-danger">{{$errors->first('phone')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="fax">Fax</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="fax" name="fax"
                   placeholder="Enter Hotel Fax" value="{{ isset($hotel)? $hotel->fax:Request::old('fax') }}"/>
            <p class="text-danger">{{$errors->first('fax')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="latitude">Latitude</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="latitude" name="latitude"
                   placeholder="Enter Hotel Latitude" value="{{ isset($hotel)? $hotel->latitude:Request::old('latitude') }}"/>
            <p class="text-danger">{{$errors->first('latitude')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="longitude">Longitude</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="longitude" name="longitude"
                   placeholder="Enter Hotel Longitude" value="{{ isset($hotel)? $hotel->longitude:Request::old('longitude') }}"/>
            <p class="text-danger">{{$errors->first('longitude')}}</p>
        </div>
    </div>

    {{--Start File Upload--}}
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="photo" class="text_bold_black">Logo</label>
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
            <label for="star">Star<span class="require">*</span></label>
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
                    <option value="" disabled selected>Select Star</option>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="email">Email<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="email" name="email"
                   placeholder="Enter Hotel Email" value="{{ isset($hotel)? $hotel->email:Request::old('email') }}"/>
            <p class="text-danger">{{$errors->first('email')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="country_id">Country<span class="require">*</span></label>
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
                    <option value="" disabled selected>Select Country</option>
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
            <label for="city_id">City<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="city_id" id="city_id">
                @if(isset($hotel))
                    @foreach($cities as $city)
                        @if($city->id == $hotel->country_id)
                            <option value="{{$city->id}}" selected>{{$city->name}}</option>
                        @else
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select City</option>
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
            <label for="township_id">Township<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="township_id" id="township_id">
                @if(isset($hotel))
                    @foreach($townships as $township)
                        @if($township->id == $hotel->country_id)
                            <option value="{{$township->id}}" selected>{{$township->name}}</option>
                        @else
                            <option value="{{$township->id}}">{{$township->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select Township</option>
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
            <label for="description">Description</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="Enter Hotel Description">{{ isset($hotel)? $hotel->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="number_of_floors">Number of floors<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            {{--<input type="text" class="form-control" id="number_of_floors" name="number_of_floors"--}}
                   {{--placeholder="Enter Number of Floors" value="{{ isset($hotel)? $hotel->number_of_floors:Request::old('number_of_floors') }}"/>--}}
            <select class="form-control" name="number_of_floors" id="number_of_floors">
                @if(isset($hotel))
                    @for ($i = 1; $i <= 100; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
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
            <label for="hotel_class">Class<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="hotel_class" name="hotel_class"
                   placeholder="Enter Hotel Class" value="{{ isset($hotel)? $hotel->class:Request::old('hotel_class') }}"/>
            <p class="text-danger">{{$errors->first('hotel_class')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="website">Website</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="website" name="website"
                   placeholder="Enter Hotel Website" value="{{ isset($hotel)? $hotel->website:Request::old('website') }}"/>
            <p class="text-danger">{{$errors->first('website')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="check_in_time">Check-in Time<span class="require">*</span></label>
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
            <label for="check_out_time">Check-out Time<span class="require">*</span></label>
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
            <label for="breakfast_start_time">Breakfast Start Time<span class="require">*</span></label>
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
            <label for="breakfast_end_time">Breakfast End Time<span class="require">*</span></label>
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

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('hotel')">
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
                    email: {
                        required: true,
                        email: true
                    },
                    country_id              : 'required',
                    city_id                 : 'required',
                    township_id             : 'required',
                    number_of_floors        : 'required',
                    hotel_class             : 'required',
                    website                 : 'url',
                    check_in_time           : 'required',
                    check_out_time          : 'required',
                    breakfast_start_time    : 'required',
                    breakfast_end_time      : 'required',
                },
                messages: {
                    name                    : 'Name is required',
                    h_type_id               : 'Type is required',
                    address                 : 'Address is required',
                    phone                   : 'Phone is required',
                    photo                   : 'Photo is required',
                    star                    : 'Star is required',
                    email: {
                        required:'Email is required',
                        email   : 'Email is not valid'
                    },
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