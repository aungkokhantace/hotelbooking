@extends('layouts.master')
@section('title','City')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        @if(isset($profile))
            Update Profile
        @else
            {{ isset($country) ?  'City Edit' : 'City Entry' }}
        @endif
    </h1>

    {{--check new or edit--}}
    @if(isset($city))
        {!! Form::open(array('url' => '/backend/city/update', 'class'=> 'form-horizontal user-form-border', 'id'=>'city')) !!}

    @else
        {!! Form::open(array('url' => '/backend/city/store', 'class'=> 'form-horizontal user-form-border', 'id'=>'city')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($city)? $city->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="country_id">Country Name <span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            @if(isset($city))
                {!! Form::select('country_id',$countries,$city->country->id,['class' => 'form-control','id'=>'country_id']) !!}
                <p class="text-danger">{{$errors->first('country_id')}}</p>
            @else
                {!! Form::select('country_id',$countries,null,['class' => 'form-control','id'=>'country_id']) !!}
                <p class="text-danger">{{$errors->first('country_id')}}</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="user_name">City Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input required type="text" class="form-control" id="city_name" name="city_name"
                   placeholder="Enter City Name" value="{{ isset($city)? $city->city_name:Request::old('city_name') }}"/>
            <p class="text-danger">{{$errors->first('city_name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($city)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('city')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
@stop