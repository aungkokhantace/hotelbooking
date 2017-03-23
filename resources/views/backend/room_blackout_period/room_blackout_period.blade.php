@extends('layouts.master')
@section('title','Room Blackout Period')
@section('content')
    <style>
        .date-value-box{
            width: 95% !important;
        }
    </style>
    <!-- begin #content -->
    <div id="content" class="content">

        <h1 class="page-header">{{isset($r_blackout_period) ?  'Room Discount Edit' : 'Room Discount Entry' }}</h1>

        @if(isset($r_blackout_period))
            {!! Form::open(array('url' => '/backend/room_blackout_period/update','id'=>'room_blackout_period', 'class'=> 'form-horizontal user-form-border')) !!}

        @else
            {!! Form::open(array('url' => '/backend/room_blackout_period/store','id'=>'room_blackout_period', 'class'=> 'form-horizontal user-form-border')) !!}
        @endif
        <input type="hidden" name="id" value="{{isset($r_blackout_period)? $r_blackout_period->id:''}}"/>
        <br/>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="hotel_id">Hotel <span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <select class="form-control" name="hotel_id" id="hotel_id">
                    @if(isset($r_blackout_period))
                        @foreach($hotels as $hotel)
                            @if($hotel->id == $r_blackout_period->hotel_id)
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
                <label for="room_id">Room<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <select class="form-control" name="room_id" id="room_id">
                    @if(isset($r_blackout_period))
                        @foreach($rooms as $room)
                            @if($room->id == $r_blackout_period->room_id)
                                <option value="{{$room->id}}" selected>{{$room->name}}</option>
                            @else
                                <option value="{{$room->id}}">{{$room->name}}</option>
                            @endif
                        @endforeach
                    @else
                        <option value="" disabled selected>Select Room</option>
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('room_id')}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="from_date">From Date<span class="require">*</span></label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="input-group date dateTimePicker" data-provide="datepicker" id="datepicker_from">
                    <input type="text" class="form-control date-value-box" id="from_date" name="from_date" value="{{isset($r_blackout_period)? \Carbon\Carbon::parse($r_blackout_period->from_date)->format('d-m-Y') : ''}}">
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
                    <input type="text" class="form-control date-value-box" id="to_date" name="to_date" value="{{isset($r_blackout_period)? \Carbon\Carbon::parse($r_blackout_period->to_date)->format('d-m-Y') : ''}}">
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
                <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="Enter Remark">{{ isset($r_blackout_period)? $r_blackout_period->remark:Request::old('remark') }}</textarea>
                <p class="text-danger">{{$errors->first('remark')}}</p>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="submit" name="submit" value="{{isset($r_blackout_period)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('room_blackout_period')">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('page_script')

    <script type="text/javascript">
        $(document).ready(function(){

            $('#hotel_id').change(function(e){
                loadRoom($(this).val());
            });

            //Start Validation for Entry and Edit Form
            $('#room_blackout_period').validate({
                rules: {
                    hotel_id            : 'required',
                    room_id             : 'required',
                    from_date           : 'required',
                    to_date             : 'required',

                },
                messages: {
                    hotel_id            : 'Hotel is required!',
                    room_id             : 'Romm is required!',
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

        function loadRoom(hotel_id){
            $.ajax({
                type: "GET",
                url: "/backend/room/get_room/"+hotel_id,
            }).done(function( result ) {
                $("#room_id").empty();//To reset states
                $("#room_id").append("<option selected disabled>Select Room</option>");
                $(result).each(function(){
                    $("#room_id").append($('<option>', {
                        value: this.id,
                        text: this.name,
                    }));
                })
            });
        }
    </script>
@stop