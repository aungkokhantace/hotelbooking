@extends('layouts.master')
@section('title','Room Discount')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($room_discount) ?  'Room Discount Edit' : 'Room Discount Entry' }}</h1>

    @if(isset($room_discount))
        {!! Form::open(array('url' => '/backend/room_discount/update','id'=>'room_discount', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/room_discount/store','id'=>'room_discount', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($room_discount)? $room_discount->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Enter Name" value="{{ isset($room_discount)? $room_discount->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">Hotel <span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($room_discount))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $room_discount->hotel_id)
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
                @if(isset($room_discount))
                    @foreach($hotel_room_type as $type)
                        @if($type->id == $room_discount->h_room_type_id)
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
                @if(isset($room_discount))
                    @foreach($hotel_room_category as $category)
                        @if($category->id == $room_discount->h_room_category_id)
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
            <label for="type">Discount Type<span class="require">*</span></label>
        </div>
        @if(isset($room_discount))
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                @if($room_discount->type == '%')
                    <input type="radio" name="type" value="%" checked> %
                @else
                    <input type="radio" name="type" value="%"> %
                @endif
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                @if($room_discount->type == 'Amount')
                    <input type="radio" name="type" value="amount" checked> Amount
                @else
                    <input type="radio" name="type" value="amount"> Amount
                @endif
            </div>
        @else
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <input type="radio" name="type" value="%"> %
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <input type="radio" name="type" value="amount" checked> Amount
            </div>
        @endif
        <p class="text-danger">{{$errors->first('type')}}</p>
    </div>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="discount_amount">Discount Amount<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            @if(isset($room_discount) && $room_discount->type == '%')
                <input type="text" class="form-control" id="discount_amount" name="discount_amount"
                       placeholder="Enter Discount Amount" value="{{ isset($room_discount)? $room_discount->discount_percent:Request::old('discount_amount') }}"/>
            @else
                <input type="text" class="form-control" id="discount_amount" name="discount_amount"
                       placeholder="Enter Discount Amount" value="{{ isset($room_discount)? $room_discount->discount_amount:Request::old('discount_amount') }}"/>
            @endif
            <p class="text-danger">{{$errors->first('discount_amount')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="from_date">From Date<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="input-group date dateTimePicker" data-provide="datepicker" id="datepicker_from">
                <input type="text" class="form-control" id="from_date" name="from_date" value="{{isset($room_discount)? \Carbon\Carbon::parse($room_discount->from_date)->format('d-m-Y') : ''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <p class="text-danger">{{$errors->first('from_date')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="to_date">To Date<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="input-group date dateTimePicker" data-provide="datepicker"  id="datepicker_to">
                <input type="text" class="form-control" id="to_date" name="to_date" value="{{isset($room_discount)? \Carbon\Carbon::parse($room_discount->to_date)->format('d-m-Y') : ''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            <p class="text-danger">{{$errors->first('to_date')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="remark">Remark</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="Enter Remark">{{ isset($room_discount)? $room_discount->remark:Request::old('remark') }}</textarea>
            <p class="text-danger">{{$errors->first('remark')}}</p>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($room_discount)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('room_discount')">
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
            $('#room_discount').validate({
                rules: {
                    name                : 'required',
                    hotel_id            : 'required',
                    h_room_type_id      : 'required',
                    h_room_category_id  : 'required',
                    type                : 'required',
                    discount_amount     : 'required',
                    from_date           : 'required',
                    to_date             : 'required',

                },
                messages: {
                    name                : 'Name is required!',
                    hotel_id            : 'Hotel is required!',
                    h_room_type_id      : 'Room Type is required!',
                    h_room_category_id  : 'Room Category is required!',
                    type                : 'Type is required!',
                    discount_amount     : 'Discount Amount is required!',
                    from_date           : 'From Date is required!',
                    to_date             : 'To Date is required!',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form

            //Date Picker
            $("#datepicker_from").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                showButtonPanel: true,
                startDate: new Date()
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate() + 1);
                $('#datepicker_to').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('#datepicker_to').datepicker('setStartDate',null);
            });

            $("#datepicker_to").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                startDate: new Date()
            }).on('changeDate', function (selected) {
                $('#from_date').val('');
                var endDate = new Date(selected.date.valueOf());
                $('#datepicker_from').datepicker('setEndDate', endDate);
            }).on('clearDate', function (selected) {
                $('#datepicker_from').datepicker('setEndDate',null);
            });


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