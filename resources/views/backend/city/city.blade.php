@extends('layouts.master')
@section('title','City')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        {{ isset($country) ?  'City Edit' : 'City Entry' }}
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
            <label for="country_id">Country Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="country_id" id="country_id">
            @if(isset($city))
                @foreach($countries as $country)
                    @if($country->id == $city->country_id)
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
            <label for="name">City Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input required type="text" class="form-control" id="name" name="name" placeholder="Enter City Name" value="{{ isset($city)? $city->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
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
    <script type="text/javascript">
        $(document).ready(function() {
            //Start Validation for Entry and Edit Form
            $('#city').validate({
                rules: {
                    name                  : 'required',
                    country_id            : 'required',
                },
                messages: {
                    name                  : 'City Name is required',
                    country_id            : 'Country is required',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form

            //For checkbox picker
            $(':checkbox').checkboxpicker();
        });
    </script>
@stop