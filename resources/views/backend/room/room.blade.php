@extends('layouts.master')
@section('title','Room')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_room_type) ? trans('setup_room.title-edit') : trans('setup_room.title-entry') }}</h1>

    @if(isset($room))
        {!! Form::open(array('url' => '/backend/room/update','id'=>'room', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/room/store','id'=>'room', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" id="id" value="{{isset($room)? $room->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">
                {{trans('setup_room.hotel')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($room))
                    @if ($role == 3)
                        <option value="{{$hotels->id}}" selected>{{$hotels->name}}</option>
                    @else
                        @foreach($hotels as $hotel)
                            @if($hotel->id == $room->hotel_id)
                                <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                            @else
                                <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                            @endif
                        @endforeach
                    @endif
                @else
                    @if ($role == 3)
                        <option value="{{$hotels->id}}">{{$hotels->name}}</option>
                    @else
                        <option value="" disabled selected>
                            {{trans('setup_room.place-hotel')}}
                        </option>
                        @foreach($hotels as $hotel)
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endforeach
                    @endif
                @endif
            </select>
            <p class="text-danger">{{$errors->first('hotel_id')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_room_type_id">
                {{trans('setup_room.room-type')}}
                <span class="require">*</span>
            </label>
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
                    <option value="" disabled selected>
                        {{trans('setup_room.place-room-type')}}
                    </option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_room_type_id')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="h_room_category_id">
                {{trans('setup_room.room-category')}}
                <span class="require">*</span>
            </label>
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
                    <option value="" disabled selected>
                        {{trans('setup_room.place-room-category')}}
                    </option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_room_category_id')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="room_view_id">
                {{trans('setup_room.room-view')}}
                <span class="require">*</span>
            </label>
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
                    <option value="" disabled selected>
                        {{trans('setup_room.room-view')}}
                    </option>
                    @foreach($room_view as $view)
                        <option value="{{$view->id}}">{{$view->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('room_view_id')}}</p>
        </div>
    </div>
    @if(!isset($room))
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="number_of_rooms">
                {{trans('setup_room.number-of-rooms')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="number" class="form-control" id="number_of_rooms" name="number_of_rooms"
                   placeholder="{{trans('setup_room.place-no-of-rooms')}}"/>
            <p class="text-danger">{{$errors->first('number_of_rooms')}}</p>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">
                {{trans('setup_room.name')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 multi_name">
            @if(isset($room) && count($room) > 0)
                <input type="text" class="form-control" name="room_name" class="multi" placeholder="{{trans('setup_room.place-name')}}"
                       value="{{isset($room)?$room->name:Request::old('room_name')}}"/>
            @else
                <input type="text" class="form-control" name="room_name[1]" class="multi" placeholder="{{trans('setup_room.place-name')}}"
                       value="{{isset($room)?$room->name:''}}"/>
            @endif
            <p class="text-danger">{{$errors->first('room_name[1]')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="status">
                {{trans('setup_room.status')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="status" id="status">
                @if(isset($room))
                    <option value="1" {{$room->status == 1? 'selected':''}}>Available</option>
                    <option value="0" {{$room->status == 0? 'selected':''}}>Not Available</option>
                @else
                    <option value="1" selected>Available</option>
                    <option value="0">Not Available</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('status')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">{{trans('setup_room.description')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="{{trans('setup_room.place-description')}}">{{ isset($room)? $room->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 co                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             l-md-2 col-sm-2 col-xs-2">
            <label for="remark">{{trans('setup_room.remark')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="{{trans('setup_room.place-remark')}}">{{ isset($room)? $room->remark:Request::old('remark') }}</textarea>
            <p class="text-danger">{{$errors->first('remark')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($room)? trans('setup_room.btn-update') : trans('setup_room.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_room.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('room')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //if isset hotelId Load Room Type
            var hotelId    = $('#hotel_id').val();
            var room       = $('#id').val();
            if (hotelId > 0 && room <= 0) {
                loadHotelRoomType(hotelId);
            }

            $('#hotel_id').change(function(e){
                loadHotelRoomType($(this).val());
            });

            $('#h_room_type_id').change(function(e){
                loadHotelRoomCategory($(this).val());
            });

            //Number of Rooms
            $('#number_of_rooms').focusout(function (e){
                $('.multi_name').empty();
                var rows    = $('#number_of_rooms').val();
                var count   = 1;
                var html    = '<input type="text" class="form-control" name="room_name['+count+']" class="multi" placeholder="{{trans('setup_room.place-name')}}"/>';


                for (i = 0; i < rows-1; i++) {
                    count += 1;
                    html  += '<input type="text" class="form-control" name="room_name[' + count + ']" class="multi" placeholder="{{trans('setup_room.place-name')}}"/>';
                }
                html       += '<p class="text-danger">{{$errors->first('room_name[]')}}</p>';
                $('.multi_name').append(html);
                $("[name*=room_name]").each(function() {
                    console.log('ssss');
                    $(this).rules('add', {
                        required: true,
                        messages: {
                            required : 'Room Name is required!'
                        }
                    });
                });

            });

            //Start Validation for Entry and Edit Form

            $('#room').validate({
                rules: {
                    'hotel_id'            : 'required',
                    'h_room_type_id'      : 'required',
                    'h_room_category_id'  : 'required',
                    'room_view_id'        : 'required',
                    'room_name[1]'        : 'required',
                    'status'              : 'required'
                },
                messages: {
                    'hotel_id'            : 'Hotel is required!',
                    'h_room_type_id'      : 'Room Type is required!',
                    'h_room_category_id'  : 'Room Category is required!',
                    'room_view_id'        : 'Room View is required!',
                    'room_name[1]'        : 'Room Name is required!',
                    'status'              : 'Status is required!'
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

                $("#h_room_category_id").empty();//To reset states
                $("#h_room_category_id").append("<option selected disabled>Select Room Category</option>");

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