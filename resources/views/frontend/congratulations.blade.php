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
                                            <h3>Congratulations! Your booking is now confirmed.</h3>
                                        </div>
                                        <ul class="payment_ul">
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>We sent your confirmation email to {{$booking->user->email}}</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>Your booking at {{$hotel->name}} is already confirmed</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>You can <a href="#">make changes or cancel your booking</a> any time</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="paymentfour_left pull-right">
                                            <h4>PRINT CONFIRMATION</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.col-md-12 -->
                    <div class="col-md-12">
                        <div class="paymentfour_title">
                            <h3>Check Your Details</h3>
                        </div>
                        <div class="paymentform_one">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="paymentform_left">
                                        <h5>{{$hotel->name}}</h5>
                                        <table class="paymentfour_table">
                                            <tbody>
                                            <tr>
                                                <td width="72%">Booking Number</td>
                                                <td>{{$booking->booking_no}}</td>
                                            </tr>
                                            <tr>
                                                <td width="72%">Booking Details</td>
                                                <td>{{$number_of_nights}} {{$number_of_nights > 1 ? "Nights" : "Night"}}, {{$number_of_rooms}} {{$number_of_rooms > 1 ? "Rooms" : "Room"}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        &nbsp;
                                        <table class="paymentfour_table">
                                            <tbody>
                                            <tr>
                                                <td width="50%">Check-in</td>
                                                <td>{{$booking->check_in_date}} ( from {{$booking->check_in_time}} )</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">Check-out</td>
                                                <td>{{$booking->check_out_date}} ( until {{$booking->check_out_time}} )</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        &nbsp;
                                        <ul class="paymenttable_ul">
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>{{$number_of_rooms}} {{$number_of_rooms > 1 ? "Rooms" : "Room"}}</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>{{$booking->total_government_tax_percentage}}% GOVERNMENT TAX</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>{{$booking->total_service_tax_percentage}}% SERVICE TAX</li>
                                            {{--<li><i class="fa fa-check fa-lg" aria-hidden="true"></i>Today you'll pay</li>--}}
                                        </ul>
                                    </div>
                                    <table class="paymentfour_table">
                                        <tbody>
                                        <tr>
                                            <td width="30%" style="color:#5c5c5c;"><h3>Price</h3></td>
                                            <td style="color:#5c5c5c;"><h2>US ${{$booking->total_payable_amt}}</h2></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>You'll pay when you stay at <span style="color:#D63090;">{{$hotel->name}}</span></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="color:#337ab7;">You'll pay in the local currency</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>The amount shown is the net price. Additional applicable taxes may be charged by the property if you don't show up or if you cancel.</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-3 paymentform_right">
                                <span>
                                    <h5>Is everything correct?</h5>
                                </span>
                                    <p>You can always view or change your booking online - no registration required.</p>
                                    <a href="#"><i class="fa fa-times" aria-hidden="true"></i>Cancel your booking</a>
                                    <button type="submit" class="btn btn-primary">VIEW BOOKING</button>
                                    <p style="color:#ccc;padding-top:15px;font-size:13px;">Tip: You can make changes to this booking anytime by signing in.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.col-md-12 -->
                    <p>&nbsp;</p>
                    <div class="col-md-9">
                        <div class="paymentfour_title">
                            <h3>Property Details</h3>
                        </div>
                        <div class="paymentform_one">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="paymentform_left">
                                        <table class="paymentfour_table">
                                            <tbody>
                                            <tr>
                                                <td width="40%">Address</td>
                                                <td>{{$hotel->address}}</td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Phone</td>
                                                <td>{{$hotel->phone}}<br> <span><a target="_blank" href="/hotel_detail/{{$hotel->id}}#good_to_know">Policies</a></span></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">GPS Coordinates</td>
                                                <td>{{$hotel->latitude}}, {{$hotel->longitude}}</td>
                                            </tr>
                                            <tr>
                                                <td width="30%"></td>
                                                <td>
                                                    {{--<button type="submit" class="btn-four btn-primary-four"><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>Show Directions</button>--}}
                                                    <a target="_blank" href="/get_directions/{{$hotel->id}}"><button type="button" class="btn-four btn-primary-four"><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>Show Directions</button></a>
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
                                        <div class="col-md-9">
                                            <div class="paymentfourtable">
                                                <div class="row">
                                                    <h4>{{$booking_room->room->name}}</h4>

                                                    <div class="paymentfourbutton">
                                                        <button type="button" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Change your room</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    @if(isset($booking_room->facilities) && count($booking_room->facilities)>0)
                                                    <div class="col-md-6">
                                                        <span>Room Facilities</span>
                                                        <ul class="room_facility">
                                                            @foreach($booking_room->facilities as $booking_room_facility)
                                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$booking_room_facility->facility->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                    @if(isset($booking_room->amenities) && count($booking_room->amenities)>0)
                                                    <div class="col-md-6">
                                                        <span>Room Amenities</span>
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
                                                    <td width="40%">Guest name
                                                    </td>
                                                    <td>
                                                        @if($booking_room->user_first_name == "" && $booking_room->user_last_name == "")
                                                        {{$booking->user->first_name}} {{$booking->user->last_name}} <button type="submit" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Edit guest name</button>
                                                        @else
                                                        {{$booking_room->user_first_name}} {{$booking_room->user_last_name}} <button type="submit" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Edit guest name</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>for {{$booking_room->guest_count}} {{$booking_room->guest_count > 1 ? "people" : "person"}}  <button type="submit" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Edit number of guest</button><br>({{$booking_room->smoking == 1 ? "smoking" : "non-smoking"}} preference)</td>
                                                </tr>
                                                <tr>
                                                    <td>Meal Plan</td>
                                                    <td>Breakfast is included in the room rate.</td>
                                                </tr>
                                                {{--<tr>--}}
                                                    {{--<td>Prepayment</td>--}}
                                                    {{--<td>No prepayment is needed.</td>--}}
                                                {{--</tr>--}}
                                                @if($free_cancellation !== null || $charge_date !== null || $second_cancellation_date !== null)
                                                <tr>
                                                    @if(isset($free_cancellation) && $free_cancellation !== null)
                                                        <td>Cancellation cost</td>
                                                        <td><span style="color:#D63090">Free cancellation within :{{$free_cancellation}}</span></td>
                                                    @endif
                                                </tr>
                                                @if(isset($charge_date) && $charge_date !== null)
                                                <tr>
                                                    @if(!isset($free_cancellation) && $free_cancellation == null)
                                                        <td>Cancellation cost</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>Until <span style="color:#D63090">{{$charge_date}}</span> : US $0</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    @if(!isset($free_cancellation) && $free_cancellation == null && !isset($charge_date) && $charge_date == null)
                                                        <td>Cancellation cost</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    @if(isset($charge_date) && $charge_date !== null && isset($second_cancellation_date) && $second_cancellation_date !== null)
                                                    <td>From <span style="color:#D63090">{{$charge_date}}</span> until <span style="color:#D63090">{{$second_cancellation_date}}</span> : US ${{$half_amt}}</td>
                                                    @elseif(isset($second_cancellation_date) && $second_cancellation_date !== null)
                                                    <td>Until <span style="color:#D63090">{{$second_cancellation_date}}</span> : US ${{$half_amt}}</td>
                                                    @endif
                                                </tr>
                                                @endif
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
                                <h4>Your Payment Details</h4>
                            </div>
                        </div>
                        <div class="payment_form">
                            <p>Your booking is now confirmed.Payment will be taken during you stay at <span>{{$hotel->name}}</span> </p>
                            <p>Reservations made with <span>myanmarpolestar.com</span> are always free.We never take any extra fees from guests for our services.</p>
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