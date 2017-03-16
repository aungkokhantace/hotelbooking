@extends('layouts.master')
@section('title','Room')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_room_type) ?  'Room Edit' : 'Room Entry' }}</h1>

    @if(isset($room))
        {!! Form::open(array('url' => '/backend/room/update','id'=>'room', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/room/store','id'=>'room', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($room)? $room->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">Hotel <span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($room))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $room->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select Hotel</option>
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
            <label for="h_room_type_id">Room Type<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="h_room_type_id" id="h_room_type_id">
                @if(isset($room))
                    @foreach($hotel_room_type as $type)
                        @if($type->id == $room->h_room_type_id)
                            <option value="{{$type->id}}" selected>{{$type->name}}</option>
                        @else
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select Room Type</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_room_type_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_room_category_id">Room Category<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="h_room_category_id" id="h_room_category_id">
                @if(isset($room))
                    @foreach($hotel_room_category as $category)
                        @if($category->id == $room->h_room_category_id)
                            <option value="{{$category->id}}" selected>{{$category->name}}</option>
                        @else
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select Room Category</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_room_category_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="room_view_id">Room View <span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="room_view_id" id="room_view_id">
                @if(isset($room))
                    @foreach($room_view as $view)
                        @if($view->id == $room->room_view_id)
                            <option value="{{$view->id}}" selected>{{$view->name}}</option>
                        @else
                            <option value="{{$view->id}}">{{$view->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select Room View</option>
                    @foreach($room_view as $view)
                        <option value="{{$view->id}}">{{$view->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('room_view_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Enter Room Name" value="{{ isset($room)? $room->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="status">Status<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="status" name="status"
                   placeholder="Enter Room Status" value="{{ isset($room)? $room->status:Request::old('status') }}"/>
            <p class="text-danger">{{$errors->first('status')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">Description</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="Enter Room Description">{{ isset($room)? $room->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="remark">Remark</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="Enter Room Remark">{{ isset($room)? $room->remark:Request::old('remark') }}</textarea>
            <p class="text-danger">{{$errors->first('remark')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($room)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('room')">
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
            $('#room').validate({
                rules: {
                    hotel_id            : 'required',
                    h_room_type_id      : 'required',
                    h_room_category_id  : 'required',
                    room_view_id        : 'required',
                    name                : 'required',
                    status              : 'required',
                },
                messages: {
                    hotel_id            : 'Hotel is required!',
                    h_room_type_id      : 'Room Type is required!',
                    h_room_category_id  : 'Room Category is required!',
                    room_view_id        : 'Room View is required!',
                    name                : 'Name is required!',
                    status              : 'Status is required!',
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