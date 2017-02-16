@extends('layouts.master')
@section('title','HotelRestaurantCategory')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_restaurant_category) ?  'HotelRestaurantCategory Edit' : 'HotelRestaurantCategory Entry' }}</h1>

    @if(isset($countries))
        {!! Form::open(array('url' => '/backend/hotel_restaurant_category/update','id'=>'hotel_restaurant_category', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_restaurant_category/store','id'=>'hotel_restaurant_category', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_restaurant_category)? $hotel_restaurant_category->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="countries_name">Hotel Restaurant Category<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="hotel_restaurant_category_name" name="hotel_restaurant_category_name"
                   placeholder="Enter Hotel Restaurant Category Name" value="{{ isset($hotel_restaurant_category)? $hotel_restaurant_category->hotel_restaurant_category_name:Request::old('hotel_restaurant_category_name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_restaurant_category)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('hotel_restaurant_category')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
@stop