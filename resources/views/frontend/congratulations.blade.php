@extends('layouts_frontend.master_frontend')
@section('title','Congratulations')
@section('content')
        <div id="header_id">
            <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
        </div>
    </div>
    </section>

        <section id="aboutus">
            <div class="container">
                <input type="hidden" id="latitude" name="latitude" value="{{isset($hotel)? $hotel->latitude:''}}"/>
                <input type="hidden" id="longitude" name="longitude" value="{{isset($hotel)? $hotel->longitude:''}}"/>

                <div class="row">
                    <div class="col-md-12">
                        <div id="paymentfour">
                            <div class="paymentfour">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="paymentfour_left">
                                            <h3>{{trans('frontend_details.booking_is_now_confirmed')}}.</h3>
                                        </div>
                                        <ul class="payment_ul">
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>{{trans('frontend_details.sent_your_confirmation_email')}} {{$booking->user->email}}</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>Your booking at {{$hotel->name}} is already confirmed</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i> <a href="/booking/manage/{{$booking->id}}">{{trans('frontend_details.you_can_make_change')}} </a> </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="paymentfour_left pull-right">
                                            {{--<h4>PRINT CONFIRMATION</h4>--}}
                                            <a target="_blank" href="/booking/manage/print/{{$booking->id}}"><button type="button" class="btn btn-primary">{{trans('frontend_details.print_confirmation')}}</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.col-md-12 -->
                    <div class="col-md-12">
                        <div class="paymentfour_title">
                            <h3>{{trans('frontend_details.check_your_details')}}</h3>
                        </div>
                        <div class="paymentform_one">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="paymentform_left">
                                        <h5>{{$hotel->name}}</h5>
                                        <table class="paymentfour_table">
                                            <tbody>
                                            <tr>
                                                <td width="72%">{{trans('frontend_details.booking_number')}}</td>
                                                <td>{{$booking->booking_no}}</td>
                                            </tr>
                                            <tr>
                                                <td width="72%">{{trans('frontend_details.booking_details')}}</td>
                                                <td>{{$number_of_nights}} {{$number_of_nights > 1 ? trans('frontend_details.nights') : trans('frontend_details.night')}}, {{$number_of_rooms}} {{$number_of_rooms > 1 ? trans('frontend_details.rooms') : trans('frontend_details.room')}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        &nbsp;
                                        <table class="paymentfour_table">
                                            <tbody>
                                            <tr>
                                                <td width="50%">{{trans('frontend_details.check_in')}}</td>
                                                <td>{{$booking->check_in_date}} ( {{trans('frontend_details.from')}} {{$booking->check_in_time}} )</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">{{trans('frontend_details.check_out')}}</td>
                                                <td>{{$booking->check_out_date}} ( {{trans('frontend_details.until')}} {{$booking->check_out_time}} )</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        &nbsp;
                                        <ul class="paymenttable_ul">
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>{{$number_of_rooms}} {{$number_of_rooms > 1 ? trans('frontend_details.rooms') : trans('frontend_details.room')}}</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>{{$booking->total_government_tax_percentage}}% {{trans('frontend_details.goverment_tax')}}</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>{{$booking->total_service_tax_percentage}}% {{trans('frontend_details.service_tax')}}</li>
                                            {{--<li><i class="fa fa-check fa-lg" aria-hidden="true"></i>{{trans('frontend_details.today_you_will_pay')}}</li>--}}
                                        </ul>
                                    </div>
                                    <table class="paymentfour_table">
                                        <tbody>
                                        <tr>
                                            <td width="30%" style="color:#5c5c5c;"><h3>{{trans('frontend_details.price')}}</h3></td>
                                            <td style="color:#5c5c5c;"><h2>US ${{$booking->total_payable_amt}}</h2></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>{{trans('frontend_details.you_pay_stay_at')}} <span style="color:#D63090;">{{$hotel->name}}</span></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="color:#337ab7;">{{trans('frontend_details.you_pay_USD')}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>{{trans('frontend_details.the_amount_show_net_price')}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-3 paymentform_right">
                                <span>
                                    <h5>{{trans('frontend_details.is_everything_correct')}}</h5>
                                </span>
                                    <p>{{trans('frontend_details.you_can_always_view_change_booking')}}.</p>
                                    {{--<a href="#"><i class="fa fa-times" aria-hidden="true"></i>Cancel your booking</a>--}}
                                    <a href="/booking/manage/{{$booking->id}}"><button type="button" class="btn btn-primary">{{trans('frontend_details.view_booking')}}</button></a>
                                    <p style="color:#ccc;padding-top:15px;font-size:13px;">{{trans('frontend_details.tip')}}: {{trans('frontend_details.you_can_make_change')}}.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.col-md-12 -->
                    <p>&nbsp;</p>
                    <div class="col-md-9">
                        <div class="paymentfour_title">
                            <h3>{{trans('frontend_details.property_details')}}</h3>
                        </div>
                        <div class="paymentform_one">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="paymentform_left">
                                        <table class="paymentfour_table">
                                            <tbody>
                                            <tr>
                                                <td width="40%">{{trans('frontend_details.address')}}</td>
                                                <td>{{$hotel->address}}</td>
                                            </tr>
                                            <tr>
                                                <td width="30%">{{trans('frontend_details.phone')}}</td>
                                                <td>{{$hotel->phone}}<br> <span><a target="_blank" href="/hotel_detail/{{$hotel->id}}#good_to_know">{{trans('frontend_details.policies')}}</a></span></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">{{trans('frontend_details.gps_coordinates')}}</td>
                                                <td>{{$hotel->latitude}}, {{$hotel->longitude}}</td>
                                            </tr>
                                            <tr>
                                                <td width="30%"></td>
                                                <td>
                                                    {{--<button type="submit" class="btn-four btn-primary-four"><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>Show Directions</button>--}}
                                                    <a target="_blank" href="/get_directions/{{$hotel->id}}"><button type="button" class="btn-four btn-primary-four"><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>{{trans('frontend_details.show_directions')}}</button></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @foreach($booking_rooms as $booking_room)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                        </div>
                                        {{--<div class="col-md-9">--}}
                                        <div class="col-md-10">
                                            <div class="paymentfourtable">
                                                <div class="row">
                                                    <h4>{{$booking_room->room->name}}</h4>

                                                    <div class="paymentfourbutton">
                                                        <a href="/booking/manage/{{$booking->id}}"><button type="button" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>{{trans('frontend_details.change_room')}}</button></a>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    @if(isset($booking_room->facilities) && count($booking_room->facilities)>0)
                                                    <div class="col-md-6">
                                                        <span>{{trans('frontend_details.room_facilties')}}</span>
                                                        <ul class="room_facility">
                                                            @foreach($booking_room->facilities as $booking_room_facility)
                                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$booking_room_facility->facility->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                    @if(isset($booking_room->amenities) && count($booking_room->amenities)>0)
                                                    <div class="col-md-6">
                                                        <span>{{trans('frontend_details.room_amenities')}}</span>
                                                        <ul class="room_amenity">
                                                            @foreach($booking_room->amenities as $booking_room_amenity)
                                                                <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$booking_room_amenity->amenity->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            {{--<p>&nbsp;</p>--}}
                                            {{--<p>&nbsp;</p>--}}
                                            <table class="paymentfour_table">
                                                <tbody>
                                                <tr>
                                                    <td width="40%">{{trans('frontend_details.guest_name')}}
                                                    </td>
                                                    <td>
                                                        @if($booking_room->user_first_name == "" && $booking_room->user_last_name == "")
                                                        {{$booking->user->first_name}} {{$booking->user->last_name}} <a href="/booking/manage/{{$booking->id}}"><button type="button" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>{{trans('frontend_details.edit')}} {{trans('frontend_details.guest_name')}}</button></a>
                                                        @else
                                                        {{$booking_room->user_first_name}} {{$booking_room->user_last_name}} <a href="/booking/manage/{{$booking->id}}"><button type="button" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>{{trans('frontend_details.edit')}} {{trans('frontend_details.guest_name')}}</button></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>for {{$booking_room->guest_count}} {{$booking_room->guest_count > 1 ? "people" : "person"}}  <a href="/booking/manage/{{$booking->id}}"><button type="button" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>{{trans('frontend_details.edit_number_of_guest')}}</button></a><br>({{$booking_room->smoking == 1 ? "smoking" : "non-smoking"}} preference)</td>
                                                </tr>
                                                <tr>
                                                    <td>{{trans('frontend_details.meal_plan')}}</td>
                                                    <td>{{trans('frontend_details.breakfast_is_included')}}.</td>
                                                </tr>
                                                <tr>
                                                    <td>{{trans('frontend_details.cancellation_cost')}}</td>
                                                    <td>{{trans('frontend_details.until')}} <span style="color:#D63090">{{$charge_date}}</span> : US $0 ({{trans('frontend_details.free')}})</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>{{trans('frontend_details.from')}}<span style="color:#D63090">{{$charge_date}}</span> {{trans('frontend_details.until')}} <span style="color:#D63090">{{$second_cancellation_date}}</span> : US ${{number_format($half_amt,2)}} (50%)</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>{{trans('frontend_details.from')}} <span style="color:#D63090">{{$second_cancellation_date}}</span> : US ${{number_format($booking->total_payable_amt,2)}} (100%)</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        {{--<div class="col-md-3">--}}
                                            {{--<div class="thumbnail">--}}
                                                {{--<a href="shared/images/us.png">--}}
                                                    {{--<img src="shared/images/UserBookingList_img.png" alt="Fjords" style="width:100%">--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="payment_formtitle">
                            <!-- First Blog Post Left -->
                            <div class="payment_list">
                                <h4> {{trans('frontend_details.your_payment_details')}}</h4>
                            </div>
                        </div>
                        <div class="payment_form">
                            <p>{{trans('frontend_details.your_booking_is_now_confirmed')}} <span>{{$hotel->name}}</span> </p>
                            <p>{{trans('frontend_details.reservations_made_with_myanmarposter')}}.</p>
                        </div>
                    </div><!-- /.col-md-9 -->

                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.section -->
@stop

@section('page_script')
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function(){

        });

    </script>
@stop
