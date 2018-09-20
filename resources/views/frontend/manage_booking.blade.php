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
                            <!-- <h3>{{isset($customer)&&count($customer)?$customer['display_name']:''}}</h3> -->
                            <h3>{{isset($customer)&&count($customer)?$customer['first_name'] .' '. $customer['last_name']:''}}</h3>
                        </div>
                        <div class="side_gmail">
                            <p>{{isset($customer)?$customer['email']:''}}</p>
                        </div>
                        <div class="left_menu">
                            <ul>
                                <li><a class="active"href="/bookingList">{{trans('frontend_details.booking_list')}}</a></li>
                                <li><a href="/profile">{{trans('frontend_details.my_profile')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Blog Sidebar Widget Column -->
                <!-- Manage Booking Column -->
                <div class="col-md-9 user_list">
                    <div class="search_list">
                        <h2>{{trans('frontend_details.bookings')}}</h2>
                        <h4 style="margin-top: 30px;"><a href="/bookingList" style="color: #626262;"><< {{trans('frontend_details.back_all_bookings')}}</a></h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive room_table">
                                <h3 style="color:#D63090;">{{trans('frontend_details.you_confirmed_booking_at')}}
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
                                                        <!-- <a href="shared/images/us.png"> -->
                                                            <img src="/images/upload/{{$booking->hotel->logo}}" alt="logo" style="width:100%">
                                                        <!-- </a> -->
                                                    </div>
                                                </li>
                                                {{--<li style="float:right;">--}}
                                                    {{--<a href="#">{{trans('frontend_details.show_map')}}</a>--}}
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
                                                <li class="text_fa">{{trans('frontend_details.booking_number')}}: <strong>{{$booking->booking_no}}</strong> </li>
                                                {{--<li class="text_fa">PIN code: <strong>3050</strong></li>--}}
                                            </ul>
                                            <ul class="fa-uls price_night">
                                                <li class="text_fa">{{trans('frontend_details.check_in')}} </li>
                                                <li class="text_fa">
                                                    <strong>
                                                        {{Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y')}}
                                                    </strong>
                                                </li>
                                                <li class="text_fa">{{trans('frontend_details.from')}} {{$booking->check_in_time}}</li>
                                            </ul>
                                            <ul class="fa-uls price_night manage-form">
                                                <li class="text_fa">{{trans('frontend_details.check_out')}} </li>
                                                <li class="text_fa">
                                                    <strong>
                                                        {{Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y')}}
                                                    </strong>
                                                </li>
                                                <li class="text_fa">{{trans('frontend_details.until')}} {{$booking->check_out_time}}</li>
                                            </ul>

                                            <ul class="fa-uls price_night manage-form">
                                                <li class="text_fa">
                                                    <strong>{{$booking->total_day}} @if($booking->total_day>1){{trans('frontend_details.nights')}}@else {{trans('frontend_details.night')}} @endif</strong><br>
                                                    <strong>{{$booking->room_count}} @if($booking->room_count>1) {{trans('frontend_details.rooms')}} @else {{trans('frontend_details.room')}} @endif</strong>
                                                </li>
                                            </ul>

                                            <ul class="fa-uls price_night">
                                                <!--<li style="float:right;">
                                                    <a href="#">Price details</a>
                                                </li> -->
                                                <li class="text_fa">Price</li>
                                                <li class="text_fa">
                                                    <h4>{{$currency.' '.$booking->total_payable_amt}}</h4>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="manageform_right">
                                            <ul class="fa-ul price_night">
                                                <li class="text_fa">
                                                    <a href="#" data-toggle="modal" data-target="#change_date" class="change_date_link">{{trans('frontend_details.chage_date')}}</a>
                                                    <!-- Modal for Change Date -->
                                                    @include('frontend.change_date')
                                                    <!-- Modal for Change Date -->
                                                </li>
                                                <li class="text_fa">
                                                    <a href="/congratulations/{{$booking->id}}">{{trans('frontend_details.view_confirmation')}}</a>
                                                </li>
                                                <li class="text_fa">
                                                    <a href="/booking/manage/print/{{$booking->id}}" target="_blank">
                                                       {{trans('frontend_details.print_confirmation')}}
                                                    </a>
                                                </li>
                                                <li class="text_fa">
                                                    <a href="#" data-toggle="modal" data-target="#cancelbooking" class="cancel_link">{{trans('frontend_details.cancel_booking')}}</a>
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
                                @if($room->default_image == 1 || !isset($room->default_image))
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <td class="b-manage-table booking_manage_table" width="40%" >
                                                @if(isset($room->category_image) && $room->category_image != null)
                                                  <img class="img-hover img-responsive" src="/images/upload/{{$room->category_image}}" alt="">
                                                @else
                                                  <img class="img-hover img-responsive" src="/images/upload/{{$hotel->logo}}" alt="">
                                                @endif
                                            </td>
                                            <td class="lead_left booking_manage_table">
                                           <div class="booking_data_fix">

                                           <h4>{{$room->room_category}}</h4>
                                           <div class="manageform-edit" id="rowEdit{{$room->id}}">
                                               <i>for </i> <span>{{$room->guest_name}}</span>
                                               ({{$room->guest_count>1?$room->guest_count.'guests':$room->guest_count.'guest'}})
                                               @if($allow_edit == 1)
                                               <button type="button" class="btn-four btn-primary-four btn-edit" id="{{$room->id}}">
                                                   <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>{{trans('frontend_details.edit')}}
                                               </button>
                                               @endif
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
                                                           @for($i=1;$i<=$room->guest_count;$i++){
                                                           <option value="{{$i}}" {{$i==$room->guest_count?'selected':''}}>
                                                               {{$i>1?$i.' guests':$i.' guest'}}
                                                           </option>
                                                           @endfor
                                                       </select>
                                                   </div>
                                                   <div class="col-2 text-center">
                                                       <button type="button" class="btn btn-primary btn-success saveEdit"
                                                               id="saveEdit-{{$room->id}}">
                                                           &nbsp; {{trans('frontend_details.save')}} &nbsp;
                                                       </button>
                                                   </div>
                                                   <div class="col-2">
                                                       <button type="button" class="btn btn-primary cancelEdit" id="cancelEdit-{{$room->id}}">
                                                           {{trans('frontend_details.cancel')}}
                                                       </button>
                                                   </div>
                                               </div>
                                           </div>
                                           {!! Form::close() !!}

                                           <!-- start extrabed information -->
                                           <div class="manageform">
                                               <h4>{{trans('frontend_details.added_extra_bed_text')}} : {{$room->added_extra_bed_text}}</h4>
                                               @if($room->added_extra_bed == 1)
                                               <h4>{{trans('frontend_details.extra_bed_price')}} : ${{$room->extra_bed_price}}</h4>
                                               @endif
                                           </div>
                                           <!-- end extrabed information -->

                                           @if(isset($room->amenities) && count($room->amenities)>0)
                                           <div class="manageform">
                                               <h4>{{trans('frontend_details.amenities')}}</h4>
                                                 @foreach($room->amenities as $amenity)
                                                     <p>{{"* ".$amenity->name}}</p>
                                                 @endforeach
                                           </div>
                                           @endif

                                           @if(isset($room->facilities) && count($room->facilities)>0)
                                           <div class="clearfix"></div>
                                           <div class="manageform">
                                                 <h4>{{trans('frontend_details.room_facilties')}}</h4>
                                                 @foreach($room->facilities as $facility)
                                                     <p>{{"* ".$facility->name}}</p>
                                                 @endforeach
                                           </div>
                                           @endif

                                           @if(isset($hotel->h_facilities) && count($hotel->h_facilities)>0)
                                           <div class="clearfix"></div>
                                           <div class="manageform">
                                               <h4>{{trans('frontend_details.hotel_facilities')}}</h4>
                                               @foreach($hotel->h_facilities as $h_facility)
                                                   <p>{{"* ".$h_facility->facility->name}}</p>
                                               @endforeach
                                           </div>
                                           @endif
                                           <div class="clearfix"></div>
                                           <!-- <a class="cancelbooking" href="/booking/room/cancel/{{$booking->id}}/{{$room->id}}"> -->
                                           <a class="cancelbooking" id="cancelbooking" href="#" onclick="cancel_room('{{$booking->id}}','{{$room->id}}','{{$booking->charge}}','{{trans('frontend_details.are_you_sure')}}','{{trans('frontend_details.you_will_not_recover')}}','{{trans('frontend_details.cancel')}}','{{trans('frontend_details.confirm')}}');">
                                               ⨂ {{trans('frontend_details.cancel_your_room')}}
                                           </a>
                                           <div class="clearfix"></div>
                                           </div>
                                       </td>
                                    </tr>
                                        </tbody>
                                    </table>
                                @endif
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
                                    <h4>{{trans('frontend_details.book_for_transportation')}}</h4>
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
                                    <span style="font-size:15px;">{{trans('frontend_details.inserted_booking_taxi')}}</span>
                                </div>
                            </div>
                            <div class="payment_formtitle">
                                <!-- First Blog Post Left -->
                                <div class="payment_list">
                                    <h4>{{trans('frontend_details.book_for_guide')}}</h4>
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
                                    <span style="font-size:15px;">{{trans('frontend_details.inserted_in_tour_guid')}}.</span>
                                </div>
                            </div>
                            <div class="payment_formtitle">
                                <!-- First Blog Post Left -->
                                <div class="payment_list">
                                    <h4>{{trans('frontend_details.talk_here')}}</h4>
                                </div>
                            </div>
                            <div class="last_form">
                                <div class="formtitle_left">
                                    <span>{{trans('frontend_details.special_request')}}</span>
                                </div>
                                <div class="formtitle_left">
                                    <span>{{trans('frontend_details.we_forward_upon_booking')}}.</span>
                                </div>
                                <div class="formtitles_text">
                                    <span>{{trans('frontend_details.please_aware_subject')}}.</span>
                                </div>
                                <div class="list_style" style="float:left;">
                                    <input type="checkbox" name="non_smoking_request"
                                           value="1" {!! $b_request->non_smoking_room==1?'checked':'' !!} disabled
                                    >
                                    <span>{{trans('frontend_details.non_like_smoking')}}</span><br>
                                    <input type="checkbox" name="late_check_in_request"
                                           value="1" {!! $b_request->late_check_in==1?'checked':'' !!} disabled
                                    >
                                    <span>{{trans('frontend_details.non_like_late_check')}}</span><br>
                                    <input type="checkbox" name="high_floor_request"
                                           value="1" {!! $b_request->high_floor_room==1?'checked':'' !!} disabled
                                    >
                                    <span>{{trans('frontend_details.non_like_room_high')}}</span><br>
                                    <input type="checkbox" name="large_bed_request"
                                           value="1" {!! $b_request->large_bed==1?'checked':'' !!} disabled
                                    >
                                    <span>{{trans('frontend_details.non_like_bed')}}</span><br>
                                    <input type="checkbox" name="early_check_in_request"
                                           value="1" {!! $b_request->early_check_in==1?'checked':'' !!} disabled
                                    >
                                    <span>{{trans('frontend_details.non_like_check')}}</span><br>
                                </div>
                                <div class="list_style">
                                    <input type="checkbox" name="twin_bed_request"
                                           value="1" {!! $b_request->twin_bed==1?'checked':'' !!} disabled>
                                    <span>{{trans('frontend_details.like_twin_bed')}}</span><br>
                                    <input type="checkbox" name="quiet_room_request"
                                           value="1" {!! $b_request->quiet_room==1?'checked':'' !!} disabled>
                                    <span>{{trans('frontend_details.like_quiet_room')}}</span><br>
                                    <input type="checkbox" name="airport_transfer_request"
                                           value="1" {!! $b_request->airport_transfer==1?'checked':'' !!} disabled>
                                    <span>{{trans('frontend_details.like_ariport_transfer')}}</span><br>
                                    <input type="checkbox" name="private_parking_request"
                                           value="1" {!! $b_request->private_parking==1?'checked':'' !!} disabled>
                                    <span>{{trans('frontend_details.like_private_parking')}}</span><br>
                                    <input type="checkbox" name="baby_cot_request"
                                           value="1" {!! $b_request->baby_cot==1?'checked':'' !!} disabled>
                                    <span>{{trans('frontend_details.have_baby_cot')}} <br>({{trans('frontend_details.additional_charge_may_apply')}})</span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="formtitle_left">
                                    <span>{{trans('frontend_details.special_request')}}</span>
                                </div>

                                @if(isset($communications) && count($communications) > 0)
                                    @foreach($communications as $comm)
                                        @if(!empty($comm->special_request))
                                            <div class="ptext_left" style="width: 100%;">
                                                <h5 class="@if($comm->type == 2) {{'text-right'}} @endif">{{$comm->type==1?'Admin':'Me'}}</h5>
                                                <h6 class="@if($comm->type == 2) {{'text-right'}} @endif">[{{$comm->created_at}}]</h6>
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
                                <div class="textarea ptext_left">
                                    <input type="hidden" name="id" value="{{$booking->id}}">
                                    <!-- <textarea class="col-xs-7" id="special_request" name="special_request"></textarea> -->
                                    <textarea class="textarea_p special_request_textarea" id="special_request" name="special_request"></textarea>
                                </div>
                                <div class="clearfix"></div>
                                <button type="button" class="btn btn-primary btn-success communication_btn" id="communication-btn">{{trans('frontend_details.say')}}</button>
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
                ////////////////////
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55 ",
                        confirmButtonText: "Confirm",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
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
                        } else {
                            return;
                        }
                    });
            });

        });

        function cancel_room(booking_id,room_id,booking_charge,cancel_room,recover,cancel,confirm) {
            if(booking_charge == "free"){
              var alert_text = recover;
            }
            else{
              var alert_text = booking_charge;
            }

            swal({
                    title: cancel_room,
                    // text: "You will not be able to recover!",
                    text: alert_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55 ",
                    confirmButtonText: confirm,
                    cancelButtonText: cancel,
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        // window.location = "/" + type + "/destroy/" + data;
                        window.location = "/booking/room/cancel/"+ booking_id + "/" + room_id;
                    } else {
                        return;
                    }
                });
            }

    </script>
@stop
