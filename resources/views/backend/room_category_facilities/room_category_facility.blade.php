@extends('layouts.master')
@section('title','Room Category Facility')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($r_category_facility) ? trans('setup_roomcategoryfacility.title-edit') : trans('setup_roomcategoryfacility.title-entry') }}</h1>

    @if(isset($r_category_facility))
        {!! Form::open(array('url' => '/backend/room_category_facility/update','id'=>'r_category_facility', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/room_category_facility/store','id'=>'r_category_facility', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($r_category_facility)? $r_category_facility->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="facility">
                {{trans('setup_roomcategoryfacility.facility')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="facility" id="facility">
                @if(isset($r_category_facility))
                    @foreach($facilities as $facility)
                        @if($facility->id == $r_category_facility->facility_id)
                            <option value="{{$facility->id}}" selected>{{$facility->name}}</option>
                        @else
                            <option value="{{$facility->id}}">{{$facility->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_roomcategoryfacility.place-facility')}}
                    </option>
                    @foreach($facilities as $facility)
                        <option value="{{$facility->id}}">{{$facility->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('facility')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="facility_group">
                {{trans('setup_roomcategoryfacility.facility-gp')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="facility_group" id="facility_group">
                @if(isset($r_category_facility))
                    @foreach($facility_group as $group)
                        @if($group->id == $group->facility_group_id)
                            <option value="{{$group->id}}" selected>{{$group->name}}</option>
                        @else
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_roomcategoryfacility.place-facility-gp')}}
                    </option>
                    @foreach($facility_group as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('facility_group')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">
                {{trans('setup_roomcategoryfacility.hotel')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($r_category_facility))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $r_category_facility->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_roomcategoryfacility.place-hotel')}}
                    </option>
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('hotel_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_room_type_id">
                {{trans('setup_roomcategoryfacility.room-type')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="h_room_type_id" id="h_room_type_id">
                @if(isset($r_category_facility))
                    @foreach($hotel_room_type as $type)
                        @if($type->id == $r_category_facility->h_room_type_id)
                            <option value="{{$type->id}}" selected>{{$type->name}}</option>
                        @else
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_roomcategoryfacility.room-type')}}
                    </option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_room_type_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_room_category_id">
                {{trans('setup_roomcategoryfacility.room-category')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="h_room_category_id" id="h_room_category_id">
                @if(isset($r_category_facility))
                    @foreach($hotel_room_category as $category)
                        @if($category->id == $r_category_facility->h_room_category_id)
                            <option value="{{$category->id}}" selected>{{$category->name}}</option>
                        @else
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_roomcategoryfacility.place-room-category')}}
                    </option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_room_category_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="value">
                {{trans('setup_roomcategoryfacility.value')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="value" name="value"
                   placeholder="{{trans('setup_roomcategoryfacility.place-value')}}"
                   value="{{ isset($r_category_facility)? $r_category_facility->value:Request::old('value') }}"/>
            <p class="text-danger">{{$errors->first('value')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">{{trans('setup_roomcategoryfacility.description')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_roomcategoryfacility.place-description')}}">{{ isset($r_category_facility)? $r_category_facility->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($r_category_facility)? trans('setup_roomcategoryfacility.btn-update') : trans('setup_roomcategoryfacility.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_roomcategoryfacility.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('room_category_facility')">
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
            $('#r_category_facility').validate({
                rules: {
                    facility            : 'required',
                    hotel_id            : 'required',
                    h_room_type_id      : 'required',
                    h_room_category_id  : 'required',
                    value               : 'required',

                },
                messages: {
                    facility            : 'Facility is required!',
                    hotel_id            : 'Hotel is required!',
                    h_room_type_id      : 'Room Type is required!',
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