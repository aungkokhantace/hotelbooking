@extends('layouts.master')
@section('title','Township')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        @if(isset($profile))
            Update Profile
        @else
            {{ isset($township) ?  'Township Edit' : 'Township Entry' }}
        @endif
    </h1>

    {{--check new or edit--}}
    @if(isset($township))
        {!! Form::open(array('url' => '/backend/township/update', 'class'=> 'form-horizontal user-form-border', 'id'=>'township')) !!}

    @else
        {!! Form::open(array('url' => '/backend/township/store', 'class'=> 'form-horizontal user-form-border', 'id'=>'township')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($township)? $township->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="country_id">City Name <span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            @if(isset($township))
                {!! Form::select('city_id',$cities,$township->city->id,['class' => 'form-control','id'=>'city_id']) !!}
                <p class="text-danger">{{$errors->first('city_id')}}</p>
            @else
                {!! Form::select('city_id',$cities,null,['class' => 'form-control','id'=>'city_id']) !!}
                <p class="text-danger">{{$errors->first('city_id')}}</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="user_name">Township Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input required type="text" class="form-control" id="township_name" name="township_name"
                   placeholder="Enter Township Name" value="{{ isset($township)? $township->township_name:Request::old('township_name') }}"/>
            <p class="text-danger">{{$errors->first('township_name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($township)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('township')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
@stop