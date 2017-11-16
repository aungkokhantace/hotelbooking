@extends('layouts_frontend.master_frontend')
@section('title','Manage Booking')
@section('content')
    <div id="header_id">
        <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
    </div>
    </div>

    <section id="popular">
        <div class="container">
            <div class="row">
                <!-- Blog Sidebar Widget Column -->
                <div class="col-md-3">
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
                </div>
                <!-- Blog Sidebar Widget Column -->
                <!-- Manage Booking Column -->
                <div class="col-md-9 user_list">
                    <div class="search_list">
                        <h2>Bookings</h2>
                        <h4 style="margin-top: 30px;"><a href="/bookingList" style="color: #626262;">Back to all bookings</a></h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive room_table">
                                <h3 style="color:#D63090;">Your confirmed booking at
                                    <a href="#" style="color: #626262;">{{$hotel->name}}</a>
                                    @while($hotel->star != 0)
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <?php $hotel->star--; ?>
                                    @endwhile
                                    {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                                    {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                                    {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                                </h3>
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <ul class="fa-ul-new price_night manage-form">
                                                <li>
                                                    <div class="thumbnail">
                                                        <a href="shared/images/us.png">
                                                            <img src="/images/upload/{{$booking->hotel->logo}}" alt="logo" style="width:100%">
                                                        </a>
                                                    </div>
                                                </li>
                                                {{--<li style="float:right;">--}}
                                                    {{--<a href="#">show map</a>--}}
                                                {{--</li>--}}
                                                <li>
                                                    {{$hotel->address}}
                                                </li>
                                            </ul>
                                            <ul class="fa-uls price_night">
                                                <li style="float:right;">
                                                    {{--<a href="#">Email property</a>--}}
                                                    {{$hotel->email}}
                                                </li>
                                                <li class="text_fa">{{$hotel->phone}}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="fa-uls price_night manage-form">
                                                <li class="text_fa">BOOKING NUMBER: <strong>{{$booking->booking_no}}</strong> </li>
                                                {{--<li class="text_fa">PIN code: <strong>3050</strong></li>--}}
                                            </ul>
                                            <ul class="fa-uls price_night">
                                                <li class="text_fa">Check-in </li>
                                                <li class="text_fa">
                                                    <strong>
                                                        {{Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y')}}
                                                    </strong>
                                                </li>
                                                <li class="text_fa">from {{$booking->check_in_time}}</li>
                                            </ul>
                                            <ul class="fa-uls price_night manage-form">
                                                <li class="text_fa">Check-out </li>
                                                <li class="text_fa">
                                                    <strong>
                                                        {{Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y')}}
                                                    </strong>
                                                </li>
                                                <li class="text_fa">until {{$booking->check_out_time}}</li>
                                            </ul>
                                            <ul class="fa-uls price_night">
                                                {{--<li style="float:right;">--}}
                                                    {{--<a href="#">Price details</a>--}}
                                                {{--</li>--}}
                                                <li class="text_fa">Price</li>
                                                <li class="text_fa">
                                                    <strong>
                                                        {{$booking->total_day}} night, {{$booking->room_count}} room
                                                    </strong>
                                                </li>
                                                <li class="text_fa"><h4>{{$currency.' '.$booking->total_payable_amt}}</h4></li>
                                            </ul>
                                        </td>
                                        <td class="manageform_right">
                                            <ul class="fa-ul price_night">
                                                <li class="text_fa">
                                                    <a href="#" data-toggle="modal" data-target="#change_date" class="change_date_link">Changes Date</a>
                                                    <!-- Modal for Change Date -->
                                                    @include('frontend.change_date')
                                                    <!-- Modal for Change Date -->
                                                </li>
                                                <li class="text_fa">
                                                    <a href="/congratulations/{{$booking->id}}">View Confirmation</a>
                                                </li>
                                                <li class="text_fa">
                                                    <a href="/booking/manage/print/{{$booking->id}}" target="_blank">
                                                        Print Confirmation
                                                    </a>
                                                </li>
                                                <li class="text_fa">
                                                    <a href="#" data-toggle="modal" data-target="#cancelbooking" class="cancel_link">Cancel Booking</a>
                                                    <!-- Modal for Cancel Booking -->
                                                    @include('frontend.booking_cancel')
                                                    <!-- Modal for Cancel Booking -->
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    {{--<tr>--}}
                                        {{--<td colspan="3">--}}
                                            {{--<div class="col-md-5">--}}
                                                {{--<ul class="fa-ul price_night">--}}
                                                    {{--<li class="text_fa text-center"><h5>Cancellation is free</h5></li>--}}
                                                    {{--<li class="text_fa text-center">For: 2 months 24 days 13 hours 58 minutes</li>--}}
                                                    {{--<li class="text_fa tooltips">--}}
                                                        {{--Cancel your reservation before 16 Sept--}}
                                                        {{--at 23:59 Yangon time for a full refund. After that time, cancel for US$33.23.--}}
                                                    {{--</li>--}}
                                                {{--</ul>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-4 manage_progress">--}}
                                                {{--<div class="progress">--}}
                                                    {{--<div class="progress-bar" role="progressbar" aria-valuenow=50"--}}
                                                         {{--aria-valuemin="0" aria-valuemax="100" style="width:50%">--}}
                                                        {{--50%--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-3 manage_progress">--}}
                                                {{--<ul class="fa-ul price_night">--}}
                                                    {{--<li class="text_fa"><a class="cancelbooking" href="#">Cancel your booking</a></li>--}}
                                                {{--</ul>--}}
                                            {{--</div>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive room_table ">
                                @foreach($booking->rooms as $room)
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <td class="b-manage-table booking_manage_table" width="40%" >
                                                <img class="img-hover img-responsive"
                                                src="{{$room->category_image}}"
                                                alt="">
                                            </td>
                                            <td class="lead_left booking_manage_table">
                                           <div class="booking_data_fix">
                                           <h4>{{$room->room_category}}</h4>
                                           <div class="manageform-edit" id="rowEdit{{$room->id}}">
                                               <i>for </i> <span>{{$room->guest_name}}</span>
                                               ({{$room->guest_count>1?$room->guest_count.'guests':$room->guest_count.'guest'}})
                                               <button type="button" class="btn-four btn-primary-four btn-edit" id="{{$room->id}}">
                                                   <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Edit
                                               </button>
                                           </div>
                                           {!! Form::open(array('url'=>'/booking/room/edit',
                                                                'id'=>'form'.$room->id)) !!}
                                           <div class="form-groups row formEdit" id="formEdit{{$room->id}}">
                                               <div class="col-10">
                                                   <input type="hidden" name="r_id" value="{{$room->id}}">
                                                   <input type="hidden" name="b_id" value="{{$booking->id}}">
                                                   <div class="col-2">
                                                       <input type="text" class="floatLabel form-control"
                                                              id="f_name" placeholder="First" name="f_name"
                                                              value="{{isset($room->user_first_name)?$room->user_first_name:''}}">
                                                   </div>
                                                   <div class="col-2">
                                                       <input type="text" class="floatLabel form-control"
                                                              id="l_name" placeholder="Last" name="l_name"
                                                              value="{{isset($room->user_last_name)?$room->user_last_name:''}}">
                                                   </div>
                                                   <div class="col-2">
                                                       <select class="floatLabel form-control" name="g_count">
                                                           @for($i=1;$i<=$room->max_count;$i++){
                                                           <option value="{{$i}}" {{$i==$room->guest_count?'selected':''}}>
                                                               {{$i>1?$i.' guests':$i.' guest'}}
                                                           </option>
                                                           @endfor
                                                       </select>
                                                   </div>
                                                   <div class="col-2 text-center">
                                                       <button type="button" class="btn btn-primary btn-success saveEdit"
                                                               id="saveEdit-{{$room->id}}">
                                                           &nbsp; Save &nbsp;
                                                       </button>
                                                   </div>
                                                   <div class="col-2">
                                                       <button type="button" class="btn btn-primary cancelEdit" id="cancelEdit-{{$room->id}}">
                                                           Cancel
                                                       </button>
                                                   </div>
                                               </div>
                                           </div>
                                           {!! Form::close() !!}
                                           <div class="manageform">
                                               <h4>Amenities</h4>
                                               @foreach($room->amenities as $amenity)
                                                   <p>{{"* ".$amenity->name}}</p>
                                               @endforeach
                                           </div>
                                           <div class="clearfix"></div>
                                           <div class="manageform">
                                               <h4>Room Facilities</h4>
                                               @foreach($room->facilities as $facility)
                                                   <p>{{"* ".$facility->name}}</p>
                                               @endforeach
                                           </div>
                                           <div class="clearfix"></div>
                                           <div class="manageform">
                                               <h4>Hotel Facilities</h4>
                                               @foreach($hotel->h_facilities as $h_facility)
                                                   <p>{{"* ".$h_facility->facility->name}}</p>
                                               @endforeach
                                           </div>
                                           <div class="clearfix"></div>
                                           <a class="cancelbooking" href="/booking/room/cancel/{{$booking->id}}/{{$room->id}}">
                                               ⨂Cancel your room
                                           </a>
                                           <div class="clearfix"></div>
                                           </div>
                                       </td>
                                    </tr>
                                        </tbody>
                                    </table>
                           @endforeach
                       </div>
                        {{--@foreach($booking->rooms as $room)--}}
                        {{--<div id="bookingmanage_blog">--}}
                                    {{--<div class="blog_booking">--}}
                                        {{--<div class="col-md-4 col-sm-4 col-xs-12 left_list">--}}
                                            {{--<img class="img-hover img-responsive"--}}
                                                 {{--src="{{$room->category_image}}"--}}
                                                 {{--alt="">--}}
                                        {{--</div>--}}


                                        {{--<div class="col-md-8 col-sm-8 col-xs-12 lead_left">--}}
                                            {{--<h4>{{$room->room_category}}</h4>--}}
                                            {{--<div class="manageform-edit" id="rowEdit{{$room->id}}">--}}
                                                {{--<i>for </i> <span>{{$room->guest_name}}</span>--}}
                                                {{--({{$room->guest_count>1?$room->guest_count.'guests':$room->guest_count.'guest'}})--}}
                                                {{--<button type="button" class="btn-four btn-primary-four btn-edit" id="{{$room->id}}">--}}
                                                    {{--<i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Edit--}}
                                                {{--</button>--}}
                                            {{--</div>--}}
                                            {{--{!! Form::open(array('url'=>'/booking/room/edit',--}}
                                                                 {{--'class'=>'form-inline',--}}
                                                                 {{--'id'=>'form'.$room->id)) !!}--}}
                                            {{--<div class="form-groups row formEdit" id="formEdit{{$room->id}}">--}}
                                                {{--<div class="col-10">--}}
                                                    {{--<input type="hidden" name="r_id" value="{{$room->id}}">--}}
                                                    {{--<input type="hidden" name="b_id" value="{{$booking->id}}">--}}
                                                    {{--<div class="col-2">--}}
                                                        {{--<input type="text" class="floatLabel form-control"--}}
                                                               {{--id="f_name" placeholder="First" name="f_name"--}}
                                                               {{--value="{{isset($room->user_first_name)?$room->user_first_name:''}}">--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-2">--}}
                                                        {{--<input type="text" class="floatLabel form-control"--}}
                                                               {{--id="l_name" placeholder="Last" name="l_name"--}}
                                                               {{--value="{{isset($room->user_last_name)?$room->user_last_name:''}}">--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-2">--}}
                                                        {{--<select class="floatLabel form-control" name="g_count">--}}
                                                            {{--@for($i=1;$i<=$room->max_count;$i++){--}}
                                                            {{--<option value="{{$i}}" {{$i==$room->guest_count?'selected':''}}>--}}
                                                                {{--{{$i>1?$i.'guests':$i.'guest'}}--}}
                                                            {{--</option>--}}
                                                            {{--@endfor--}}
                                                        {{--</select>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-2 text-center">--}}
                                                        {{--<button type="button" class="btn btn-primary btn-success saveEdit"--}}
                                                                {{--id="saveEdit-{{$room->id}}">--}}
                                                            {{--&nbsp; Save &nbsp;--}}
                                                        {{--</button>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-2">--}}
                                                        {{--<button type="button" class="btn btn-primary cancelEdit" id="cancelEdit-{{$room->id}}">--}}
                                                            {{--Cancel--}}
                                                        {{--</button>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--{!! Form::close() !!}--}}
                                            {{--<div class="manageform">--}}
                                                {{--<h4>Amenities</h4>--}}
                                                {{--@foreach($room->amenities as $amenity)--}}
                                                    {{--<p>{{"* ".$amenity->name}}</p>--}}
                                                {{--@endforeach--}}
                                            {{--</div>--}}
                                            {{--<div class="clearfix"></div>--}}
                                            {{--<div class="manageform">--}}
                                                {{--<h4>Room Facilities</h4>--}}
                                                {{--@foreach($room->facilities as $facility)--}}
                                                    {{--<p>{{"* ".$facility->name}}</p>--}}
                                                {{--@endforeach--}}
                                            {{--</div>--}}
                                            {{--<div class="clearfix"></div>--}}
                                            {{--<div class="manageform">--}}
                                                {{--<h4>Hotel Facilities</h4>--}}
                                                {{--@foreach($hotel->h_facilities as $h_facility)--}}
                                                    {{--<p>{{"* ".$h_facility->facility->name}}</p>--}}
                                                {{--@endforeach--}}
                                            {{--</div>--}}
                                            {{--<div class="clearfix"></div>--}}
                                            {{--<a class="cancelbooking" href="/booking/room/cancel/{{$booking->id}}/{{$room->id}}">--}}
                                                {{--⨂Cancel your room--}}
                                            {{--</a>--}}
                                            {{--<div class="clearfix"></div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                             {{--</div>--}}
                                {{--<hr style="border-top: 1px solid red;">--}}
                            {{--@endforeach--}}
                            <div class="payment_formtitle">
                                <!-- First Blog Post Left -->
                                <div class="payment_list">
                                    <h4>Book for Transporation</h4>
                                </div>
                            </div>
                            <div class="payment_form">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="booking_taxi"
                                               value="1" {!! $b_request->booking_taxi==1?'checked':'' !!}
                                        >
                                    </label>
                                    <img src="/assets/shared/images/transporation.png">
                                    <span style="font-size:15px;">I'm interest in booking a taxi in advance</span>
                                </div>
                            </div>
                            <div class="payment_formtitle">
                                <!-- First Blog Post Left -->
                                <div class="payment_list">
                                    <h4>Book for Tour Guide</h4>
                                </div>
                            </div>
                            <div class="payment_form">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="booking_tour_guide"
                                               value="1" {!! $b_request->booking_tour_guide==1?'checked':'' !!}
                                        >
                                    </label>
                                    <img src="/assets/shared/images/tour.png">
                                    <span style="font-size:15px;">I'm interest in booking tour guide.</span>
                                </div>
                            </div>
                            <div class="payment_formtitle">
                                <!-- First Blog Post Left -->
                                <div class="payment_list">
                                    <h4>Talk Here</h4>
                                </div>
                            </div>
                            <div class="last_form">
                                <div class="formtitle_left">
                                    <span>Special Requests</span>
                                </div>
                                <div class="formtitle_left">
                                    <span>We'll forward these to your hotel or host immediately upon booking.</span>
                                </div>
                                <div class="formtitles_text">
                                    <span>Please be aware that all requests are subject to availability.</span>
                                </div>
                                <div class="list_style" style="float:left;">
                                    <input type="checkbox" name="non_smoking_request"
                                           value="1" {!! $b_request->non_smoking_room==1?'checked':'' !!} disabled
                                    >
                                    <span>I'd like a non-smoking room</span><br>
                                    <input type="checkbox" name="late_check_in_request"
                                           value="1" {!! $b_request->late_check_in==1?'checked':'' !!} disabled
                                    >
                                    <span>I'd like a late check-in</span><br>
                                    <input type="checkbox" name="high_floor_request"
                                           value="1" {!! $b_request->high_floor_room==1?'checked':'' !!} disabled
                                    >
                                    <span>I'd like a room on a high floor</span><br>
                                    <input type="checkbox" name="large_bed_request"
                                           value="1" {!! $b_request->large_bed==1?'checked':'' !!} disabled
                                    >
                                    <span>I'd like a large bed</span><br>
                                    <input type="checkbox" name="early_check_in_request"
                                           value="1" {!! $b_request->early_check_in==1?'checked':'' !!} disabled
                                    >
                                    <span>I'd like an early check-in</span><br>
                                </div>
                                <div class="list_style">
                                    <input type="checkbox" name="twin_bed_request"
                                           value="1" {!! $b_request->twin_bed==1?'checked':'' !!} disabled>
                                    <span>I'd like twin beds</span><br>
                                    <input type="checkbox" name="quiet_room_request"
                                           value="1" {!! $b_request->quiet_room==1?'checked':'' !!} disabled>
                                    <span>I'd like a quiet room</span><br>
                                    <input type="checkbox" name="airport_transfer_request"
                                           value="1" {!! $b_request->airport_transfer==1?'checked':'' !!} disabled>
                                    <span>I'd like an airport transfer</span><br>
                                    <input type="checkbox" name="private_parking_request"
                                           value="1" {!! $b_request->private_parking==1?'checked':'' !!} disabled>
                                    <span>I'd like a private parking</span><br>
                                    <input type="checkbox" name="baby_cot_request"
                                           value="1" {!! $b_request->baby_cot==1?'checked':'' !!} disabled>
                                    <span>I'd like to have a baby cot <br>(additional charges may apply)</span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="formtitle_left">
                                    <span>Special Requests</span>
                                </div>

                                @if(isset($communications) && count($communications) > 0)
                                    @foreach($communications as $comm)
                                        @if(!empty($comm->special_request))
                                            <div class="ptext_left" style="width: 100%;">
                                                <h5>{{$comm->type==1?'Admin':'Me'}}</h5>
                                                <h6>[{{$comm->created_at}}]</h6>
                                                <div class="textarea_p">
                                                    <p>{{$comm->special_request}}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                {{--<h5>Me</h5>--}}
                                {{--<h6>[2017-08-17 11:47:10]</h6>--}}
                                {{--<div class="textarea_p">--}}
                                {{--<p></p>--}}
                                {{--</div>--}}

                                {{--<div class="ptext_right" style="width: 100%;">--}}
                                {{--<h5>Admin</h5>--}}
                                {{--<h6>[2017-08-17 12:47:10]</h6>--}}
                                {{--<div class="textarea_p">--}}
                                {{--<p></p>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div class="clearfix"></div>
                                {!! Form::open(array('url'=>'/booking/communication','class'=>'form-inline','id'=>'communication')) !!}
                                <div class="textarea">
                                    <input type="hidden" name="id" value="{{$booking->id}}">
                                    <textarea class="col-xs-7" id="special_request" name="special_request"></textarea>
                                </div>
                                <div class="clearfix"></div>
                                <button type="button" class="btn btn-primary btn-success" id="communication-btn">Say</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Manage Booking Column -->

            </div>
        </div>
    </section>
@stop

@section('script')

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
                $('#saveEdit-'+id).attr("disabled","disabled");
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
                $('#communication-btn').attr("disabled","disabled")
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