@extends('layouts.master')
@section('title','Hotel Nearby')
@section('content')

    <!-- begin #content -->
    <div id="content" class="content">

        <h1 class="page-header">{{isset($hotel_nearby) ? trans('setup_nearby.title-edit') : trans('setup_nearby.title-entry') }}</h1>

        @if(isset($hotel_nearby))
            {!! Form::open(array('url' => '/backend/hotel_nearby/update','id'=>'hotel_nearby', 'class'=> 'form-horizontal user-form-border')) !!}

        @else
            {!! Form::open(array('url' => '/backend/hotel_nearby/store','id'=>'hotel_nearby', 'class'=> 'form-horizontal user-form-border')) !!}
        @endif
        <input type="hidden" name="id" value="{{isset($hotel_nearby)? $hotel_nearby->id:''}}"/>
        <br/>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="category">Name<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <input type="text" class="form-control" id="name" name="name"
                       placeholder="{{ trans('setup_nearby.name') }}"
                       value="{{ isset($hotel_nearby)? $hotel_nearby->name:Request::old('name') }}"/>
                <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="category">Category<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <select class="form-control" name="hotel_category" id="hotel_category">
                <option value="">{{trans('setup_nearby.select-category')}}</option>
                @if(isset($nearby_categories))

                    @foreach($nearby_categories as $nearby_category)
                        @if(isset($hotel_nearby))
                        <option value="{{ $nearby_category->id }}" @if($hotel_nearby->h_nearby_category_id == $nearby_category->id) selected @endif>{{ $nearby_category->name }}</option>
                        @else
                        <option value="{{ $nearby_category->id }}" >{{ $nearby_category->name }}</option>
                        @endif
                    @endforeach
                @else
                    <option value="1">Hotel</option>
                @endif
            </select>
                <p class="text-danger">{{$errors->first('hotel_category')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="description">Description<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <input type="text" class="form-control" id="description" name="description"
                       placeholder="{{ trans('setup_nearby.Description')}}"
                       value="{{ isset($hotel_nearby)? $hotel_nearby->description:Request::old('description') }}"/>
                <p class="text-danger">{{$errors->first('description')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="submit" name="submit" value="{{isset($hotel_nearby)? trans('setup_hotelnearby.btn-update') : trans('setup_hotelnearby.btn-add')}}" class="form-control btn-primary">
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
            $('#hotel_nearby').validate({
                rules: {
                    name            : 'required',
                    hotel_category  : 'required',
                    description     : 'required',
                },
                messages: {
                    name            : 'Nearby Name required!',
                    hotel_category  : 'Hotel Nearby Category required!',
                    description     : 'Description required',
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