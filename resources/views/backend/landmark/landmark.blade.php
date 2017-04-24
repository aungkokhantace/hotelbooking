@extends('layouts.master')
@section('title','Landmark')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($landmark)? trans('setup_landmark.title-edit') : trans('setup_landmark.title-entry')  }}</h1>

    @if(isset($landmark))
        {!! Form::open(array('url' => '/backend/landmark/update','id'=>'landmark', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}

    @else
        {!! Form::open(array('url' => '/backend/landmark/store','id'=>'landmark', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($landmark)? $landmark->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{trans('setup_landmark.name')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text"  class="form-control" id="name" name="name"
                   placeholder="{{trans('setup_landmark.place-name')}}" value="{{ isset($landmark)? $landmark->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_landmark.township')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="township" id="township">
                @if(isset($landmark))
                    @foreach($townships as $township)
                        @if($township->id == $landmark->township_id)
                            <option value="{{$township->id}}" selected>{{$township->name}}</option>
                        @else
                            <option value="{{$township->id}}">{{$township->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>{{trans('setup_landmark.place-township')}}</option>
                    @foreach($townships as $township)
                        <option value="{{$township->id}}">{{$township->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('township')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="popular">{{trans('setup_landmark.Popular')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            @if(isset($landmark))
                <input type="checkbox" id="popular" name="popular" value="true" {{$landmark->is_popular == 1 ? 'checked':'' }}/>
            @else
                <input type="checkbox" id="popular" name="popular" value="true" />
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="latitude">{{trans('setup_landmark.latitude')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text"  class="form-control" id="latitude" name="latitude"
                   placeholder="{{trans('setup_landmark.place-latitude')}}" value="{{ isset($landmark)? $landmark->latitude:Request::old('latitude') }}"/>
            <p class="text-danger">{{$errors->first('latitude')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="longitude">{{trans('setup_landmark.longitude')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text"  class="form-control" id="longitude" name="longitude"
                   placeholder="{{trans('setup_landmark.place-longitude')}}"
                   value="{{ isset($landmark)? $landmark->longitude:Request::old('longitude') }}"/>
            <p class="text-danger">{{$errors->first('longitude')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">{{trans('setup_landmark.description')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_landmark.place-description')}}">{{ isset($landmark)? $landmark->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($landmark)? trans('setup_landmark.btn-update') : trans('setup_landmark.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_landmark.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('landmark')">
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
            $('#landmark').validate({
                rules: {
                    name        : 'required',
                    township    : 'required',
                    latitude    : 'required',
                    longitude   : 'required',

                },
                messages: {
                    name        : 'Name is required!',
                    township    : 'Township is required!',
                    latitude    : 'Latitude is required!',
                    longitude   : 'Longitude is required!',
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