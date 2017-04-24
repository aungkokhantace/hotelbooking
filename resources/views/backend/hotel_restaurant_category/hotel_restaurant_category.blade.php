@extends('layouts.master')
@section('title','Hotel Restaurant Category')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_restaurant_category) ? trans('setup_hotelrestaurantcategory.title-edit') : trans('setup_hotelrestaurantcategory.title-entry') }}</h1>

    @if(isset($hotel_restaurant_category))
        {!! Form::open(array('url' => '/backend/hotel_restaurant_category/update','id'=>'hotel_restaurant_category', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_restaurant_category/store','id'=>'hotel_restaurant_category', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_restaurant_category)? $hotel_restaurant_category->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">
                {{trans('setup_hotelrestaurantcategory.name')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="name" name="name"
                   placeholder="{{trans('setup_hotelrestaurantcategory.place-name')}}" value="{{ isset($hotel_restaurant_category)? $hotel_restaurant_category->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">{{trans('setup_hotelrestaurantcategory.description')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_hotelrestaurantcategory.place-description')}}">{{ isset($hotel_restaurant_category)? $hotel_restaurant_category->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_restaurant_category)? trans('setup_hotelrestaurantcategory.btn-update') : trans('setup_hotelrestaurantcategory.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotelrestaurantcategory.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_restaurant_category')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //Start Validation for Entry and Edit Form
            $('#hotel_restaurant_category').validate({
                rules: {
                    name          : 'required',
                },
                messages: {
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