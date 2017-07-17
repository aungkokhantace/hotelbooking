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
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>We sent your confirmation email to {{session('email')}}</li>
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
                                                <td>1635811300</td>
                                            </tr>
                                            <tr>
                                                <td width="72%">Booking Details</td>
                                                <td>1 night, 1 room</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        &nbsp;
                                        <table class="paymentfour_table">
                                            <tbody>
                                            <tr>
                                                <td width="50%">Check-in</td>
                                                <td>Thuesday, May 30 2017 ( from 14:00 )</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">Check-out</td>
                                                <td>Wednesday, May 31 2017 ( until 12:00 )</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        &nbsp;
                                        <ul class="paymenttable_ul">
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>1 room</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>5% TAX</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>10% Property service charge</li>
                                            <li><i class="fa fa-check fa-lg" aria-hidden="true"></i>Today you'll pay</li>
                                        </ul>
                                    </div>
                                    <table class="paymentfour_table">
                                        <tbody>
                                        <tr>
                                            <td width="30%" style="color:#5c5c5c;"><h3>Price</h3></td>
                                            <td style="color:#5c5c5c;"><h2>US $ 23</h2></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>You'll pay when you stay at <span style="color:#D63090;">Chartrium Hotel Royal Lake Yangon</span></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="color:#337ab7;">You'll pay in the local currency</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>The amount ashow is the net price.Additional applicable taxes may be charged by the property if you don't show up or if you cancel.</td>
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
                                                <td>193 Seikkantha Street, City Center, Downtown Yangon<br>12322 Yangon, Myanmar</td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Phone</td>
                                                <td>+95 9 250 909 234 <br> <span><a href="#">Policies</a></span></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">GPS Coordinates</td>
                                                <td>No 16 45.533,E 63 9.25</td>
                                            </tr>
                                            <tr>
                                                <td width="30%"></td>
                                                <td>
                                                    <button type="submit" class="btn-four btn-primary-four"><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>Show Directions</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="paymentfourtable">
                                            <h4>Twin Room with Shared Bathroom<p style="font-size:13px;padding-top:10px;">
                                                    This twin room features air conditioning.</p></h4>
                                            <div class="paymentfourbutton">
                                                <button type="submit" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Change your room</button>
                                            </div>
                                        </div>
                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <table class="paymentfour_table">
                                            <tbody>
                                            <tr>
                                                <td width="40%">Guest name
                                                </td>
                                                <td>
                                                    Test Guest <button type="submit" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Edit guest name</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>for max 2 people<button type="submit" class="btn-four btn-primary-four"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i>Edit number of guest</button><br>(non-smoking preference)</td>
                                            </tr>
                                            <tr>
                                                <td>Meal Plan</td>
                                                <td>Breakfast is included in the room rate.</td>
                                            </tr>
                                            <tr>
                                                <td>Prepayment</td>
                                                <td>No prepayment is needed.</td>
                                            </tr>
                                            <tr>
                                                <td>Cancellation cost</td>
                                                <td><span style="color:#D63090">Free cancellation within :1 month 30 days</span></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>untile May 28,2017 11:59PM [Yangon] : US$0</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>From May 28,2017 12:00AM [Yangon] : US$6.5</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="thumbnail">
                                            <a href="shared/images/us.png">
                                                <img src="shared/images/UserBookingList_img.png" alt="Fjords" style="width:100%">
                                            </a>
                                        </div>
                                    </div>
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
                            <p>Your booking is now confirmed.Payment will be taken during you stay at <span>Chartrium Hotel Royal Lake Yangon</span> </p>
                            <p>Reserations made with Myanmarpolestar.com are always free.We never take any extra fees from guests for our services.</p>
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