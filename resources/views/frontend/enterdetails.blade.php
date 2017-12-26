@extends('layouts_frontend.master_frontend')
@section('title','Enter Details')
@section('content')
        <div id="header_id">
            <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
        </div>
    </div>
    </section>

    <section id="popular">
        <!-- Page Content -->
        <div class="container">
            <div class="row">

                @include('frontend.booking_include')

                <!-- Blog Entries Column -->
                <div class="col-md-9 search_list">
                    <!-- Service Tabs -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="border-bottom:1px solid #ccc;">
                                <ul id="myTab" class="nav nav-tabs nav-justified nav-ff">
                                    {{--<li class=""><a href="#" data-toggle="tab"> 1.Choose your rooms </a>--}}
                                    <li class=""><a href="#"> 1.Choose your rooms </a>
                                    </li>
                                    <li class="active"><a href="#service-one" data-toggle="tab"> 2.Enter your details </a>
                                    </li>
                                    {{--<li class=""><a href="#service-two" data-toggle="tab"> 3.Confirm your reservation </a>--}}
                                    <li class=""><a href="#service-two"> 3.Confirm your reservation </a>
                                    </li>
                                </ul>
                            </div>

                            <!--Tab-->
                            <div id="myTabContent" class="tab-content">
                                <!--Choose Your Room-->
                                <div class="tab-pane fade" id="#">

                                </div>
                                <!--Enter Your Detail-->
                                <div class="tab-pane fade active in" id="service-one">
                                    <div id="payment_blogs">
                                        <div class="blog_booking">
                                            <div class="col-md-4 left_list">
                                                {{--<img class="img-responsive img-hover" src="/assets/shared/images/UserBookingList_img.png" alt="img">--}}
                                                <img src="/images/upload/{{$hotel->logo}}" alt="img" style="width:100%; height:140px; ">
                                            </div>
                                            <div class="col-md-8 lead_left">
                                                <h4>{{$hotel->name}}</h4>
                                                <p class="payment_lead">
                                                    <img src="/assets/shared/images/map.png"> {{$hotel->address}}
                                                </p>
                                                <table>
                                                    <tr>
                                                        <td>Check In</td>
                                                        <td class="table_right">@if(Session::has('check_in')) {{session('check_in')}} (d-m-Y) @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Check Out</td>
                                                        <td class="table_right">@if(Session::has('check_out')) {{session('check_out')}} (d-m-Y) @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Length of Stay</td>
                                                        @if(isset($nights) && $nights > 1)
                                                            <td class="table_right">{{$nights}} nights</td>
                                                        @else
                                                            <td class="table_right">{{$nights}} night</td>
                                                        @endif
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{--<form>--}}
                                    {!! Form::open(array('url' => '/confirm_reservation','files'=>true, 'id'=>'enter_detail_form', 'class'=> 'form-horizontal user-form-border')) !!}
                                        <input type="hidden" id="hotel_id" name="hotel_id" value="{{$hotel->id}}">
                                        <div class="payment_formtitle">
                                            <!-- First Blog Post Left -->
                                            <div class="payment_list">
                                                @if(\Illuminate\Support\Facades\Session::has('customer'))
                                                    <h4>Enter Your Details</h4>
                                                @else
                                                    <h4>Enter Your Details (Please sign in to continue!!)</h4>
                                                @endif
                                            </div>
                                            <!-- First Blog Post Right -->
                                            <div class="payment_right">
                                                <ul>
                                                    <li style="padding-right:15px;"><img src="/assets/shared/images/people.png"></li>
                                                    @if(\Illuminate\Support\Facades\Session::has('customer'))
                                                        <li>You are signed in</li>
                                                    @else
                                                        <a href="#" data-toggle="modal" data-target="#loginModal">
                                                            Login
                                                            <span class="glyphicon glyphicon-arrow-right"></span>
                                                        </a>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="payment">
                                            <div class="payment_form">
                                                <div class="formtitle_left">
                                                    <span>Are you travelling for work</span>
                                                </div>
                                                <div class="formtitle_right">
                                                    <span>Almost done! Just fill in the * required info</span>
                                                </div>
                                                <div class="paymentformgroup">
                                                    <div class="col-sm-2 pd_rg_10">
                                                        <label>
                                                            <input class="form-check-input" type="radio" name="travel_for_work" id="inlineRadio1" value="1"> Yes
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-2 pd_rg_10">
                                                        <label>
                                                            <input class="form-check-input" type="radio" name="travel_for_work" id="inlineRadio2" value="0" checked> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="payment_formgroup">
                                                    <div class="col-sm-3 pd_rg_10">
                                                        <label>First Name <span style="color:red;">*</span></label>
                                                        @if(\Illuminate\Support\Facades\Session::has('customer'))
                                                            <input type="text" class="formcontrols" id="first_name" name="first_name" autocomplete="off" value="{{session('customer')['first_name']}}" readonly>
                                                        @else
                                                            <input type="text" class="formcontrols" id="first_name" name="first_name" readonly>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-3 pd_lf_5">
                                                        <label>Last Name <span style="color:red;">*</span></label>
                                                        @if(\Illuminate\Support\Facades\Session::has('customer'))
                                                            <input type="text" class="formcontrols" id="last_name" name="last_name" autocomplete="off" value="{{session('customer')['last_name']}}" readonly>
                                                        @else
                                                            <input type="text" class="formcontrols" id="last_name" name="last_name" readonly>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="payment_formgroup">
                                                    <div class="col-sm-6 pd_rg_10">
                                                        <label>Email Address <span style="color:red;">*</span></label>
                                                        @if(\Illuminate\Support\Facades\Session::has('customer'))
                                                            <input type="email" class="formcontrols" id="email_address" name="email" autocomplete="off" value="{{session('customer')['email']}}" readonly>
                                                        @else
                                                            <input type="email" class="formcontrols" id="email_address" name="email" readonly>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{--<div class="payment_formgroup">--}}
                                                    {{--<div class="col-sm-6 pd_rg_10">--}}
                                                        {{--<label>Confirm Email Address <span style="color:red;">*</span></label>--}}
                                                        {{--@if(\Illuminate\Support\Facades\Session::has('customer'))--}}
                                                            {{--<input type="email" class="formcontrols" id="confirm_email" name="confirm_email" autocomplete="off">--}}
                                                        {{--@else--}}
                                                            {{--<input type="email" class="formcontrols" id="confirm_email" name="confirm_email" disabled>--}}
                                                        {{--@endif--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                @foreach($available_room_category_array as $available_room_category)
                                                    <input type="hidden" id="available_room_categories" name="available_room_categories[]" value="{{$available_room_category}}">
                                                    @if(isset($available_room_category->number) && $available_room_category->number > 0)
                                                        @for($i = 0; $i < $available_room_category->number; $i++)
                                                        <div class="payment_form">
                                                        <div class="formtitle_left">
                                                            <span>{{$available_room_category->name}}</span><br>
                                                            {{--<span class="form_two"><strong>FREE cancellation</strong> before 11:59 PM on May 28,2017/ Breakfast included<br>Cancel or make changes in just a few clicks-follow the link in your confirmation email!</span>--}}
                                                        </div>
                                                        <div class="payment_formgroup">
                                                            <div class="col-sm-4 pd_rg_10">
                                                                <label class="col-sm-4 col-form-labels">Guests</label>
                                                                <div class="col-sm-8 pd_rg_10">
                                                                    <select class="col-sm-12 pd_rg_12 formcontrols" name="{{$available_room_category->id."_".($i+1)."_guest"}}">
                                                                        @for($j=0; $j<$available_room_category->capacity; $j++)
                                                                            <option value="{{$j+1}}">{{$j+1}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 pd_lf_5">
                                                                <label class="col-sm-4 col-form-labels">Smoking</label>
                                                                <div class="col-sm-8 pd_rg_10">
                                                                    <select class="col-sm-12 pd_rg_12 formcontrols" name="{{$available_room_category->id."_".($i+1)."_smoking"}}">
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no">No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @if($available_room_category->extra_bed_allowed == 1)
                                                            <div class="col-sm-4 pd_lf_5">
                                                                <label class="col-sm-4 col-form-labels">Extrabed</label>
                                                                <div class="col-sm-8 pd_rg_10">
                                                                    <!-- <select class="col-sm-12 pd_rg_12 formcontrols extrabed" name="{{$available_room_category->id."_".($i+1)."_extrabed"}}" id="extra-{{$i}}"> -->
                                                                    <select class="col-sm-12 pd_rg_12 formcontrols extrabed" name="{{$available_room_category->id."_".($i+1)."_extrabed"}}" id="extra-{{$available_room_category->id."_".($i+1)}}">
                                                                        <option value="no">No</option>
                                                                        <option value="yes">Yes</option>
                                                                    </select>
                                                                </div>
                                                                <!-- <label class="col-sm-12 col-form-labels" style="visibility:hidden" id="extra-price-{{$i}}"> -->
                                                                <label class="col-sm-12 col-form-labels" style="visibility:hidden" id="extra-price-{{$available_room_category->id."_".($i+1)}}">
                                                                    Extrabed Price: $ {{$available_room_category->extra_bed_price}}
                                                                </label>
                                                            </div>
                                                            @endif
                                                        </div>

                                                        {{--<div class="row">--}}
                                                                {{--<label class="col-sm-4 col-form-labels">Extra Bed</label>--}}
                                                                {{--<div class="col-sm-8 pd_rg_10">--}}
                                                                {{--</div>--}}
                                                        {{--</div>--}}

                                                        <div class="payment_formgroup">
                                                            <div class="col-sm-3 pd_rg_10 flast">
                                                                {{--<input type="text" class="formcontrols" id="name" placeholder="First name, Last name">--}}
                                                                <input type="text" class="formcontrols" id="{{$available_room_category->id."_".($i+1)."_firstname"}}" name="{{$available_room_category->id."_".($i+1)."_firstname"}}" placeholder="First name" autocomplete="off">
                                                            </div>
                                                             <div class="col-sm-3 pd_rg_10 flast">
                                                                {{--<input type="text" class="formcontrols" id="name" placeholder="First name, Last name">--}}
                                                                <input type="text" class="formcontrols" id="{{$available_room_category->id."_".($i+1)."_lastname"}}" name="{{$available_room_category->id."_".($i+1)."_lastname"}}" placeholder="Last name" autocomplete="off">
                                                            </div>
                                                            <div class="col-sm-6 pd_lf_5 flast">
                                                                <input type="email" class="formcontrols" id="{{$available_room_category->id."_".($i+1)."_email"}}" name="{{$available_room_category->id."_".($i+1)."_email"}}" placeholder="Email Address" >
                                                            </div>
                                                        </div>
                                                        <div class="checkbox">
                                                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                             <span class="included">INCLUDED</span><span style="padding-left:30px;"><strong>Breakfast</strong><br></span>
                                                            <span style="padding-left: 148px;">
                                                            Yes,we'd like breakfast during our stay at no additional cost.
                                                            </span>
                                                        </div>
                                                    </div>
                                                        &nbsp;
                                                        @endfor
                                                    @endif
                                                @endforeach

                                            </div>
                                            <div class="payment_formtitle">
                                                <!-- First Blog Post Left -->
                                                <div class="payment_list">
                                                    <h4>Book for Transportation</h4>
                                                </div>
                                            </div>
                                            <div class="payment_form">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="booking_taxi" value="1">
                                                    </label>
                                                    <a target="_blank" href="/transportation_information"><img src="/assets/shared/images/transporation.png"></a>
                                                    <span style="font-size:15px;">I'm interested in booking a taxi in advance</span>
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
                                                        <input type="checkbox" name="booking_tour_guide" value="1">
                                                    </label>
                                                    <a target="_blank" href="/tour_information"><img src="/assets/shared/images/tour.png"></a>
                                                    <span style="font-size:15px;">I'm interested in booking tour guide.</span>
                                                </div>
                                            </div>
                                            &nbsp;
                                            <div class="payment_formtitle">
                                                <!-- First Blog Post Left -->
                                                <div class="payment_list">
                                                    <h4>Ask a Question</h4>
                                                </div>
                                            </div>
                                            <div class="last_form">
                                                <div class="formtitle_left">
                                                    <span>Special Requests</span>
                                                </div>
                                                <div class="formtitle_left">
                                                    <span>We'll forward these to your hotel or host immediately upon booking.</span>
                                                </div>
                                                <div>
                                                    <textarea class="col-xs-7" id="special_request" name="special_request"></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="formtitle_text">
                                                    <span>Please be aware that all requests are subject to availability.</span>
                                                </div>
                                                <div class="list_style" style="float:left;">
                                                    <input type="checkbox" name="non_smoking_request" value="1"> <span>I'd like a non-smoking room</span><br>
                                                    <input type="checkbox" name="late_check_in_request" value="1"> <span>I'd like a late check-in</span><br>
                                                    <input type="checkbox" name="high_floor_request" value="1"> <span>I'd like a room on a high floor</span><br>
                                                    <input type="checkbox" name="large_bed_request" value="1"> <span>I'd like a large bed</span><br>
                                                    <input type="checkbox" name="early_check_in_request" value="1"> <span>I'd like an early check-in</span><br>
                                                </div>
                                                <div class="list_style">
                                                    <input type="checkbox" name="twin_bed_request" value="1"> <span>I'd like twin beds</span><br>
                                                    <input type="checkbox" name="quiet_room_request" value="1"> <span>I'd like a quiet room</span><br>
                                                    <input type="checkbox" name="airport_transfer_request" value="1"> <span>I'd like an airport transfer</span><br>
                                                    <input type="checkbox" name="private_parking_request" value="1"> <span>I'd like a private parking</span><br>
                                                    <input type="checkbox" name="baby_cot_request" value="1"> <span>I'd like to have a baby cot <br>(additional charges may apply)</span>
                                                </div>
                                                <br>

                                            </div>
                                            <div class="continue">
                                                @if(\Illuminate\Support\Facades\Session::has('customer'))
                                                    <button class="btn btn-primary">CONTINUE</button>
                                                @else
                                                    <label>Please sign in to continue!</label>
                                                @endif
                                                <P>Don't worry - you won't be charged yet!</P>
                                            </div>
                                    {{--</form>--}}
                                    {!! Form::close() !!}
                                </div>
                                <!--Enter Your Detail-->
                            </div>
                                <!--Confirm your reservation-->
                                <div class="tab-pane fade" id="service-two">
                                    <div id="payment_blog">
                                        <div class="blog_booking">
                                            <div class="left_img">
                                                <img class="img-responsive img-hover" src="/assets/shared/images/UserBookingList_img.png" alt="">
                                            </div>
                                            <div>
                                                <div class="payment_left">
                                                    <h4>Chartrium Hotel Royal Lake Yangon</h4>
                                                    <p class="payment_lead">
                                                        <img src="/assets/shared/images/map.png">No.62, Bogyoke Street, Tamwe Township,<br> Yangon, Myanmar
                                                    </p>
                                                    <table>
                                                        <tr>
                                                            <td>Check In</td>
                                                            <td class="table_right">Thuesday, March 2, 2017</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Check Out</td>
                                                            <td class="table_right">Wednesday, March 3, 2017 until 12:00 from 14:00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Length of Stay</td>
                                                            <td class="table_right">1 night</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment_form">
                                        <form>
                                            <div class="paymentformgroups">
                                                <div class="col-sm-6 pd_rg_10">
                                                    <label>Country<span style="color:red;">*</span></label>
                                                    <input type="text" class="formcontrols" id="country" autocomplete="off">
                                                    <span style="padding:5px;">No address needed for this reservation</span>
                                                </div>
                                            </div>
                                            <div class="paymentformgroups">
                                                <div class="col-sm-6 pd_rg_10">
                                                    <label>Telephone (mobile number preferred) <span style="color:red;">*</span></label>
                                                    <div class="col-10 input-group">
                                                        <input id="phone" class="formcontrols font_sz_11" type="text" value="" autocomplete="off">
                                                        <div class="input-group-addons">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 pd_rg_10">
                                                    <div class="button_paynow">
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-lock" aria-hidden="true"></i> &nbsp;BOOK & PAY NOW!</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <!--Tab-->
                        </div>
                    </div> <!--row-->
                </div><!--col-md-9-->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
@stop

@section('page_script')
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
            $('.extrabed').on('change', function() {
                var id      = $(this).attr('id');
                var l_id    = id.split('-');
                var extra   = $(this).val();
                if(extra == 'yes'){
                    // $('#extra-price-'+l_id[1]).css({"visibility":"visible"});
                    $('#extra-price-'+l_id[1]).css({"visibility":"visible"});
                }
                else{
                    // $('#extra-price-'+l_id[1]).css({"visibility":"hidden"});
                    $('#extra-price-'+l_id[1]).css({"visibility":"hidden"});
                }

            });
        });

    </script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function(){
            //validate form
            $('#enter_detail_form').validate({
                rules: {
                    first_name          : 'required',
                    last_name           : 'required',
                    email: {
                        required        : true,
                        email           : true,
                        },
//                    confirm_email: {
//                        required        : true,
//                        email           : true,
//                        equalTo         : "#email_address"
//                        },

                },
                messages: {
                    first_name          : 'First Name is required',
                    last_name           : 'Last Name is required',
                    email: {
                        required        : 'Email address is required',
                        email           : 'Please enter a valid email address',
                    },
//                    confirm_email: {
//                        required        : 'Confirm Email address is required',
//                        email           : 'Please enter a valid email address',
//                        equalTo         : "Email and Confirm Email do not match"
//                    },
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
        });

    </script>
@stop
