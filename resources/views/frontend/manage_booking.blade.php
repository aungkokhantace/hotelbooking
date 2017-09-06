@extends('layouts_frontend.master_frontend')
@section('title','Manage Booking')
@section('content')
    <div id="header_id">
        <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
    </div>
    </div>

    <section id="popular">
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <!-- Blog Sidebar Widgets Column -->
                <div class="col-md-3">
                    <!-- Blog-->
                    <div>
                        <div class="side_profile">
                            <img src="/assets/shared/images/user.png">
                            <h3>{{isset($customer)&&count($customer)?$customer['display_name']:''}}</h3>
                        </div>
                        <div class="side_gmail">
                            <p>{{isset($customer)?$customer['email']:''}}</p>
                        </div>
                        <div class="left_menu">
                            <ul>
                                <li><a class="active"href="#">Booking List</a></li>
                                <li><a href="/profile">My Profile</a></li>
                            </ul>
                        </div>
                    </div>

                </div><!-- Blog Entries Column -->
                <div class="col-md-9"><!-- Manage Booking Column-->
                    <div class="row">
                        <h3>Your confirmed booking at {{$hotel->name}}</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <img src="/images/upload/{{$booking->hotel->logo}}" alt="img" style="width: 100%;height: auto;">
                            <p>{{$hotel->address}}</p>
                            <p>{{$hotel->phone}}</p>
                            <p>{{$hotel->email}}</p>
                            <p>{{$hotel->fax}}</p>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <p>Booking Number : {{$booking->booking_no}}</p>
                            <hr>
                            <p>
                                Check In <br>
                                <b>{{Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y')}}</b><br/>
                                from <b>{{$booking->check_in_time}}</b>
                                <br/><br/>
                                Check Out <br>
                                <b>{{Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y')}}</b><br/>
                                until <b>{{$booking->check_out_time}}</b>
                            </p>
                            <hr>
                            <p>
                                Price <br/>
                                <b>{{$booking->total_day}} night, {{$booking->room_count}} room</b>
                                <h4><b><i>{{$booking->total_payable_amt}} MMK</i></b></h4>
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <a href="#">Change Date</a><br/>
                            <a href="#">View Policies</a><br/>
                            <a href="/congratulations/{{$booking->id}}">View Confirmation</a><br/>
                            <a href="/booking/manage/print/{{$booking->id}}" target="_blank">Print Confirmation</a><br/>
                            <a href="#" data-toggle="modal" data-target="#cancelBooking">Cancel Booking</a>
{{--                            <a href="/booking/test/{{$booking->id}}">Cancel Booking</a>--}}
                            <!-- Cancel Booking Modal -->
                            @include('frontend.booking_cancel');
                            <!-- Cancel Booking Modal -->
                        </div>
                    </div>
                </div><!-- Manage Booking Column-->
            </div>
            <div class="row">
                <div class="col-md-offset-3">
                    <p>Booking Cancel</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    @foreach($booking->rooms as $room)
                        <div class="row"><!-- Booking Room Information -->
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <img src="{{$room->category_image}}" alt="room_image" style="width: 100%;height: auto;">
                            </div>
                            <div class="col-sm-9 col-md-9 col-lg-9">
                                <h4>{{$room->room_category}}</h4>

                                {{--Guest : {{$room->guest_count}} <br/>--}}
                                <div class="row" id="rowEdit{{$room->id}}">
                                    <div class="col-md-12">
                                        <i>for</i> <span>{{$room->guest_name}}</span>
                                        ({{$room->guest_count>1?$room->guest_count.'guests':$room->guest_count.'guest'}})
                                        <button type="button" class="btn btn-edit" id="{{$room->id}}">
                                            <span class="glyphicon glyphicon-pencil"></span>Edit
                                        </button>
                                    </div>

                                </div>

                                <div class="row formEdit" id="formEdit{{$room->id}}">
                                    <div class="col-md-12">
                                        {!! Form::open(array('url'=>'/booking/room/edit','class'=>'form-inline','id'=>'form'.$room->id)) !!}
                                            <input type="hidden" name="r_id" value="{{$room->id}}">
                                            <input type="hidden" name="b_id" value="{{$booking->id}}">
                                            <input type="text" name="f_name" placeholder="First" class="form-control" value="{{isset($room->user_first_name)?$room->user_first_name:''}}">
                                            <input type="text" name="l_name" placeholder="Last" class="form-control" value="{{isset($room->user_last_name)?$room->user_last_name:''}}">
                                            <select class="form-control" name="g_count">
                                                @for($i=1;$i<=$room->max_count;$i++){
                                                    <option value="{{$i}}" {{$i==$room->guest_count?'selected':''}}>
                                                        {{$i>1?$i.'guests':$i.'guest'}}
                                                    </option>
                                                @endfor
                                            </select>
                                            <button type="button" class="btn btn-success saveEdit" id="saveEdit-{{$room->id}}">
                                                Save
                                            </button>
                                            <button type="button" class="btn cancelEdit" id="cancelEdit-{{$room->id}}">Cancel</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            <b>Amenities</b><br/>

                                            @foreach($room->amenities as $amenity)
                                                {{"* ".$amenity->name}}
                                            @endforeach
                                            <br/>

                                            <b>Room Facilities</b><br/>
                                            @foreach($room->facilities as $facility)
                                                {{"* ".$facility->name}}
                                            @endforeach
                                            <br/>
                                            <b>Hotel Facilities</b><br/>
                                            @foreach($hotel->h_facilities as $h_facility)
                                                {{"* ".$h_facility->facility->name}}
                                            @endforeach
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div><!-- booking Room Information -->
                        <div class="row">
                            <div class="col-md-offset-3 col-md-2">
                                <button type="button" href="#" data-toggle="modal" data-target="#cancelRoom" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove-circle" style="color: #fff;"></span> Cancel this room
                                </button>
                            </div>
                        </div>
                        <hr/><br/>
                    @endforeach
                </div>
            </div>
            <!-- /.row -->.

            <div class="row"> <!-- Transportation-->
                <div class="col-md-offset-3 col-md-9">
                    <!-- First Blog Post Left -->
                    <div class="payment_list">
                        <h4>Book for Transportation</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-9 payment_form">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="booking_taxi" value="1" {!! $b_request->booking_taxi==1?'checked':'' !!}>
                        </label>
                        <img src="/assets/shared/images/transporation.png">
                        <span style="font-size:15px;">I'm interested in booking a taxi in advance</span>
                    </div>
                </div>
            </div><!-- Transportation -->

            <div class="row"><!-- Tour Guide -->
                <div class="col-md-offset-3 col-md-9">
                    <!-- First Blog Post Left -->
                    <div class="payment_list">
                        <h4>Book for Tour Guide</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-9 payment_form">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="booking_tour_guide" value="1" {!! $b_request->booking_tour_guide==1?'checked':'' !!}>
                        </label>
                        <img src="/assets/shared/images/tour.png">
                        <span style="font-size:15px;">I'm interested in booking tour guide.</span>
                    </div>
                </div>
            </div><!-- Tour Guide -->

            <!-- Communication Channel -->
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <!-- First Blog Post Left -->
                    <div class="payment_list">
                        <h4>Talk Here</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-9 last_form">
                    <div class="formtitle_left">
                        <span>Special Requests</span>
                    </div>
                    <div class="formtitle_left">
                        <span>We'll forward these to your hotel or host immediately upon booking.</span>
                    </div>

                    <div>
                        <span>Please be aware that all requests are subject to availability.</span>
                    </div>
                    <div class="list_style" style="float:left;">
                        <input type="checkbox" name="non_smoking_request" value="1" {!! $b_request->non_smoking_room==1?'checked':'' !!} disabled>
                        <span>I'd like a non-smoking room</span><br>
                        <input type="checkbox" name="late_check_in_request" value="1" {!! $b_request->late_check_in==1?'checked':'' !!} disabled>
                        <span>I'd like a late check-in</span><br>
                        <input type="checkbox" name="high_floor_request" value="1" {!! $b_request->high_floor_room==1?'checked':'' !!} disabled>
                        <span>I'd like a room on a high floor</span><br>
                        <input type="checkbox" name="large_bed_request" value="1" {!! $b_request->large_bed==1?'checked':'' !!} disabled>
                        <span>I'd like a large bed</span><br>
                        <input type="checkbox" name="early_check_in_request" value="1" {!! $b_request->early_check_in==1?'checked':'' !!} disabled>
                        <span>I'd like an early check-in</span><br>
                    </div>
                    <div class="list_style">
                        <input type="checkbox" name="twin_bed_request" value="1" {!! $b_request->twin_bed==1?'checked':'' !!} disabled>
                        <span>I'd like twin beds</span><br>
                        <input type="checkbox" name="quiet_room_request" value="1" {!! $b_request->quiet_room==1?'checked':'' !!} disabled>
                        <span>I'd like a quiet room</span><br>
                        <input type="checkbox" name="airport_transfer_request" value="1" {!! $b_request->airport_transfer==1?'checked':'' !!} disabled>
                        <span>I'd like an airport transfer</span><br>
                        <input type="checkbox" name="private_parking_request" value="1" {!! $b_request->private_parking==1?'checked':'' !!} disabled>
                        <span>I'd like a private parking</span><br>
                        <input type="checkbox" name="baby_cot_request" value="1" {!! $b_request->baby_cot==1?'checked':'' !!} disabled>
                        <span>I'd like to have a baby cot <br>(additional charges may apply)</span>
                    </div>
                    <br>
                    <div class="formtitle_left">
                        <span>Special Request</span>
                    </div>
                    <div class="payment_formgroups">
                        <div class="col-sm-7 pd_rg_10">
                            @if(isset($communications) && count($communications) > 0)
                            @foreach($communications as $comm)
                                @if(!empty($comm->special_request))
                                    <span {{$comm->type == 1?'class=span-right':''}}>
                                        <b>{{$comm->type==1?'Admin':'Me'}}</b>
                                    </span>
                                    <br>
                                    <span {{$comm->type == 1?'class=span-right':''}}>[{{$comm->created_at}}]</span>
                                    <div class="clear-div"></div>
                                    <div class="div-left">{{$comm->special_request}}</div>
                                    <div class="clear-div line-height"></div>
                                @endif
                            @endforeach
                            @endif
                            {!! Form::open(array('url'=>'/booking/communication','class'=>'form-inline','id'=>'communication')) !!}
                            <input type="hidden" name="id" value="{{$booking->id}}">
                            <textarea rows="4" style="width:100%;" id="special_request" name="special_request"></textarea>
                            <br>
                            <button type="button" class="btn btn-success" id="communication-btn">Say</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Communication Channel -->

        </div>
        <!-- /.container -->
    </section>
@stop

@section('page_script')

    <script>
        $(document).ready(function(){
            $('.formEdit').hide();
            $('.btn-edit').click(function(){
                var id = $(this).attr('id');
                $('#rowEdit'+id).hide();
                $('#formEdit'+id).show();
            });
            $('.saveEdit').click(function(){
                var id_str          = $(this).attr('id');
                var id_split        = id_str.split('-');
                var id              = id_split[1];
                var serializedData  = $('#form'+id).serialize();
                $.ajax({
                    url: '/booking/room/edit',
                    type: 'POST',
                    data: serializedData,
                    success: function(data){
                        if(data.aceplusStatusCode == '200'){
                            console.log('success');
                            swal({title: "Success", text: "Booking is updated.Please check your email.", type: "success"},
                                    function(){
//                                    window.location = '/booking/cancel/show/'+data.param;
                                        $('#formEdit'+id).hide();
                                        $('#rowEdit'+id).show();
                                        location.reload();
                                    }
                            );
                            return;
                        }
                        else if(data.aceplusStatusCode = '503'){
                            console.log('fail');
                            swal({title: "Warning", text: "Booking is updated.But email can't send for some reason.", type: "warning"},
                                    function(){
                                        location.reload();
                                    }
                            );
                            return;
                        }
                        else{
                            console.log('error');
                            swal({title: "Fail", text: "Something Wrong!", type: "error"},
                                    function(){
                                        location.reload();
                                    }
                            );
                            return;
                        }
                    },
                    error: function(data){
                        console.log(data);
                        alert(data);
                        swal({title: "Opps", text: "Sorry, Please Try Again!", type: "error"},
                                function(){
                                    location.reload();
                                }
                        );
                        return;
                    }
                });
            });
            $('.cancelEdit').click(function(){
//                location.reload();
                var id_str          = $(this).attr('id');
                var id_split        = id_str.split('-');
                var id              = id_split[1];
                $('#formEdit'+id).hide();
                $('#rowEdit'+id).show();
            });

            $('#communication-btn').click(function(){
                var serializedData  = $('#communication').serialize();
                $.ajax({
                    url: '/booking/communication',
                    type: 'POST',
                    data: serializedData,
                    success: function(data){
                        if(data.aceplusStatusCode == '200'){
                            location.reload();
                            return;
                        }
                        else{
                            swal({title: "Fail", text: "Something Wrong!", type: "error"},
                                    function(){
                                        location.reload();
                                    }
                            );
                            return;
                        }
                    },
                    error: function(data){
                        console.log(data);
                        alert(data);
                        swal({title: "Opps", text: "Sorry, Please Try Again!", type: "error"},
                                function(){
                                    location.reload();
                                }
                        );
                        return;
                    }
                });
            });
        });
    </script>
@stop