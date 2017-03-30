@extends('layouts.master')
@section('title','Hotel Restaurant')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_restaurant) ?  'Hotel Restaurant Edit' : 'Hotel Restaurant Entry' }}</h1>

    @if(isset($hotel_restaurant))
        {!! Form::open(array('url' => '/backend/hotel_restaurant/update','id'=>'hotel_restaurant', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_restaurant/store','id'=>'hotel_restaurant', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_restaurant)? $hotel_restaurant->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">Hotel <span class="require">*</span></label>
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
                    <option value="" disabled selected>Select Hotel</option>
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
            <label for="hotel_restaurant_category">Hotel Restaurant Category<span class="require">*</span></label>
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
                    <option value="" disabled selected>Select Hotel Restaurant Category</option>
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
            <label for="name">Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="name" name="name"
                   placeholder="Enter Restaurant Name" value="{{ isset($hotel_restaurant)? $hotel_restaurant->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="opening_hours">Opening Hours<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="opening_hours" name="opening_hours"
                   placeholder="Enter Opening Hours" value="{{ isset($hotel_restaurant)? $hotel_restaurant->opening_hours:Request::old('opening_hours') }}"/>
            <p class="text-danger">{{$errors->first('opening_hours')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="opening_days">Opening Days<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="opening_days" name="opening_days"
                   placeholder="Enter Opening Days" value="{{ isset($hotel_restaurant)? $hotel_restaurant->opening_days:Request::old('opening_days') }}"/>
            <p class="text-danger">{{$errors->first('opening_days')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="capacity">Capacity<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="capacity" name="capacity"
                   placeholder="Enter Capacity"
                   value="{{ isset($hotel_restaurant)? $hotel_restaurant->capacity:Request::old('capacity') }}"/>
            <p class="text-danger">{{$errors->first('capacity')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="area">Area(A.Q.M)<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="area" name="area"
                   placeholder="Enter Area" value="{{ isset($hotel_restaurant)? $hotel_restaurant->area:Request::old('area') }}"/>
            <p class="text-danger">{{$errors->first('area')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="floor">Floor<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="floor" name="floor"
                   placeholder="Enter Floor" value="{{ isset($hotel_restaurant)? $hotel_restaurant->floor:Request::old('floor') }}"/>
            <p class="text-danger">{{$errors->first('floor')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="private_room">Private Room(Included Room)</label>
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
            <label for="description">Description</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="Enter Room Category Description">{{ isset($hotel_restaurant)? $hotel_restaurant->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="remark">Remark</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="Enter Remark">{{ isset($hotel_restaurant)? $hotel_restaurant->remark:Request::old('remark') }}</textarea>
            <p class="text-danger">{{$errors->first('remark')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_restaurant)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('hotel_restaurant')">
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