@extends('layouts.master')
@section('title','Feature')
@section('content')

    <!-- begin #content -->
    <div id="content" class="content">

        <h1 class="page-header">
            {{ isset($event) ? trans('setup_eventemail.title-edit') : trans('setup_eventemail.title-entry') }}
        </h1>

        {{--check new or edit--}}
        @if(isset($event))
            {!! Form::open(array('url' => '/backend/eventemail/update', 'class'=> 'form-horizontal user-form-border', 'id'=>'event')) !!}

        @else
            {!! Form::open(array('url' => '/backend/eventemail/store', 'class'=> 'form-horizontal user-form-border', 'id'=>'event')) !!}
        @endif
        <input type="hidden" name="id" value="{{isset($event)? $event->id:''}}"/>
        <br/>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="name">{{trans('setup_eventemail.email')}}<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <input required type="text" class="form-control" id="email" name="email"
                       placeholder="{{trans('setup_eventemail.place-email')}}" value="{{ isset($event)? $event->email:Request::old('email') }}"/>
                <p class="text-danger">{{$errors->first('email')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="description">{{trans('setup_eventemail.description')}}</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_eventemail.place-description')}}">{{ isset($event)? $event->description:Request::old('description') }}</textarea>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="type">Type<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <select required class="form-control select2" name="type" id="type">
                        @if(isset($event))
                            <option value="">Select Event Email Type</option>
                            <option value="1" @if($event->type == 1) selected @endif>Customer</option>
                            <option value="2" @if($event->type == 2) selected @endif>Hotel Admin</option>
                            <option value="3" @if($event->type == 3) selected @endif>Site Admin</option>
                        @else
                            <option value="">Select Event Email Type</option>
                            <option value="1" {{ (Input::old("type") == 1 ? "selected":"") }}>Customer</option>
                            <option value="2" {{ (Input::old("type") == 2 ? "selected":"") }}>Hotel Admin</option>
                            <option value="3" {{ (Input::old("type") == 3 ? "selected":"") }}>Site Admin</option>
                        @endif
                    </select>
                <p class="text-danger">{{$errors->first('type')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="submit" name="submit" value="{{isset($event)? trans('setup_eventemail.btn-update') : trans('setup_eventemail.btn-add')}}" class="form-control btn-primary">
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="button" value="{{trans('setup_eventemail.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('eventemail')">
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
//            End fileupload js

            //Start Validation for Entry and Edit Form
            $('#event').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    description   : 'required',
                    type          : 'required',

                },
                messages: {
                    email         : 'Email is required or Wrong Email address',
                    description   : 'Description is required',
                    type          : 'Choose Email Type',
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