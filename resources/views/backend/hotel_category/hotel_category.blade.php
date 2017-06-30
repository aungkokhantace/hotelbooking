@extends('layouts.master')
@section('title','Hotel Category')
@section('content')

    <!-- begin #content -->
    <div id="content" class="content">

        <h1 class="page-header">{{isset($hotel_category) ? trans('setup_hotelnearby.title-edit') : trans('setup_hotelnearby.title-entry') }}</h1>

        @if(isset($hotel_category))
            {!! Form::open(array('url' => '/backend/nearby_category/update','id'=>'hotel_category', 'class'=> 'form-horizontal user-form-border')) !!}

        @else
            {!! Form::open(array('url' => '/backend/nearby_category/store','id'=>'hotel_category', 'class'=> 'form-horizontal user-form-border')) !!}
        @endif
        <input type="hidden" name="id" value="{{isset($hotel_category)? $hotel_category->id:''}}"/>
        <br/>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="category">Name<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <input type="text" class="form-control" id="category" name="category"
                       placeholder="setup_hotelnearby.name"
                       value="{{ isset($hotel_category)? $hotel_category->name:Request::old('category') }}"/>
                <p class="text-danger">{{$errors->first('category')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="description">Description<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <input type="text" class="form-control" id="description" name="description"
                       placeholder="setup_hotelnearby.description"
                       value="{{ isset($hotel_category)? $hotel_category->description:Request::old('description') }}"/>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="submit" name="submit" value="{{isset($hotel_category)? trans('setup_hotelnearby.btn-update') : trans('setup_hotelnearby.btn-add')}}" class="form-control btn-primary">
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="button" value="{{trans('setup_hotelfeature.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('setup_hotelnearby')">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //Start Validation for Entry and Edit Form
            $('#hotel_feature').validate({
                rules: {
                    category      : 'required',
                },
                messages: {
                    category      : 'Hotel Category required',
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