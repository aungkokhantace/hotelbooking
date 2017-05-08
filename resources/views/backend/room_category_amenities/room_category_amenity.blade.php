@extends('layouts.master')
@section('title','Room Category Amenities')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($r_category_amenity) ? trans('setup_roomcategoryamenity.title-edit') : trans('setup_roomcategoryamenity.title-entry') }}</h1>

    @if(isset($r_category_amenity))
        {!! Form::open(array('url' => '/backend/room_category_amenity/update','id'=>'r_category_amenity', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/room_category_amenity/store','id'=>'r_category_amenity', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($r_category_amenity)? $r_category_amenity->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_room_category_id">
                {{trans('setup_roomcategoryamenity.room-category')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="h_room_category_id" id="h_room_category_id">
                @if(isset($r_category_amenity))
                    @foreach($room_categories as $room_category)
                        @if($room_category->id == $r_category_amenity->room_category_id)
                            <option value="{{$room_category->id}}" selected>{{$room_category->name}}</option>
                        @else
                            <option value="{{$room_category->id}}">{{$room_category->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_roomcategoryamenity.place-room-category')}}
                    </option>
                    @foreach($room_categories as $room_category)
                        <option value="{{$room_category->id}}">{{$room_category->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_room_category_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="amenity">
                {{trans('setup_roomcategoryamenity.amenity')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="amenity" id="amenity">
                @if(isset($r_category_amenity))
                    @foreach($amenities as $amenity)
                        @if($amenity->id == $r_category_amenity->amenity_id)
                            <option value="{{$amenity->id}}" selected>{{$amenity->name}}</option>
                        @else
                            <option value="{{$amenity->id}}">{{$amenity->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_roomcategoryamenity.place-amenity')}}
                    </option>
                    @foreach($amenities as $amenity)
                        <option value="{{$amenity->id}}">{{$amenity->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('amenity')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="value">
                {{trans('setup_roomcategoryamenity.value')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="value" name="value"
                   placeholder="{{trans('setup_roomcategoryamenity.place-value')}}"
                   value="{{ isset($r_category_amenity)? $r_category_amenity->value:Request::old('value') }}"/>
            <p class="text-danger">{{$errors->first('value')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">{{trans('setup_roomcategoryamenity.description')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_roomcategoryamenity.place-description')}}">{{ isset($r_category_amenity)? $r_category_amenity->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($r_category_amenity)? trans('setup_roomcategoryamenity.btn-update') : trans('setup_roomcategoryamenity.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_roomcategoryamenity.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('room_category_amenity')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#hotel_id').change(function(e){
                loadHotelRoomType($(this).val());
            });

            $('#h_room_type_id').change(function(e){
                loadHotelRoomCategory($(this).val());
            });

            //Start Validation for Entry and Edit Form
            $('#r_category_amenity').validate({
                rules: {
                    amenity             : 'required',
                    h_room_category_id  : 'required',
                    value               : 'required',

                },
                messages: {
                    amenity             : 'Amenity is required!',
                    h_room_category_id  : 'Room Category is required!',
                    value               : 'Value is required!',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form
        });

        function loadHotelRoomType(hotelId){
            $.ajax({
                type: "GET",
                url: "/backend/hotel_room_type/get_room_type/"+hotelId,
            }).done(function( result ) {
                $("#h_room_type_id").empty();//To reset states
                $("#h_room_type_id").append("<option selected disabled>Select Room Type</option>");
                $(result).each(function(){
                    $("#h_room_type_id").append($('<option>', {
                        value: this.id,
                        text: this.name,
                    }));
                })
            });
        }

        function loadHotelRoomCategory(hRoomTypeId){
            $.ajax({
                type: "GET",
                url: "/backend/hotel_room_category/get_room_category/"+hRoomTypeId,
            }).done(function( result ) {
                $("#h_room_category_id").empty();//To reset states
                $("#h_room_category_id").append("<option selected disabled>Select Room Category</option>");
                $(result).each(function(){
                    $("#h_room_category_id").append($('<option>', {
                        value: this.id,
                        text: this.name,
                    }));
                })
            });
        }
    </script>
@stop