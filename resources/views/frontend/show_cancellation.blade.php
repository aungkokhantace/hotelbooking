@extends('layouts_frontend.master_frontend')
@section('title','Booking Cancellation')
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
                                <li><a class="active"href="#">{{trans('frontend_details.booking_list')}}</a></li>
                                <li><a href="/profile">{{trans('frontend_details.my_profile')}}</a></li>
                            </ul>
                        </div>
                    </div>

                </div><!-- Blog Entries Column -->
                <div class="col-md-9 user_list"><!-- Booking Cancellation Show Column-->
                    <div class="search_list">
                        <h2>{{trans('frontend_details.bookings')}}</h2>
                        <h4 style="margin-top: 30px;">
                            <a href="/bookingList" style="color: #626262;">{{trans('frontend_details.back_all_bookings')}}</a>
                        </h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="booking_manage">
                                <h3>Hi {{$customer['first_name']}}, your reservation at {{$hotel->name}} has been cancelled.</h3>
                                <p><strong>We have sent an email confirming your cancellation to {{$customer['email']}}.</strong></p>
                                <p>{{trans('frontend_details.we_are_in_the_process')}}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="blog_booking">
                            <div class="col-md-4">
                                <img class="img-hover" src="/images/upload/{{$hotel->logo}}" alt="">
                            </div>
                            <div class="col-md-8">
                                <h4>{{$hotel->name}} <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></h4>
                                <p>{{$hotel->address}} <a href="#">{{trans('frontend_details.show_map')}}</a></p>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <ul class="cancel_ul price_night">
                                            <li class="text-center">{{trans('frontend_details.check_in')}}</li>
                                            <li class="text-center">{{$booking->check_in_date_fmt}}</li>
                                            {{--<li class="text-center"><h3>2</h3></li>--}}
                                            {{--<li class="text-center">FEB 2017</li>--}}
                                            {{--<li class="text-center">Friday</li>--}}
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="cancel_ul1 price_night">
                                            <li class="text-center">{{trans('frontend_details.check_in')}}</li>
                                            <li class="text-center">{{$booking->check_out_date_fmt}}</li>
                                            {{--<li class="text-center"><h3>3</h3></li>--}}
                                            {{--<li class="text-center">FEB 2017</li>--}}
                                            {{--<li class="text-center">Saturday</li>--}}
                                        </ul>
                                    </div>
                                    <div class="col-md-4 cancelled">
                                        <h3>{{trans('frontend_details.cancelled')}}</h3>
                                    </div>
                                    <div class="col-md-8 text-center">
                                        <div class="nroom">
                                            <p>{{$booking->total_day}}{{trans('frontend_details.night')}}, {{$booking->room_count}} {{trans('frontend_details.rooms')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Booking Cancellation Show Column-->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
@stop

@section('page_script')

    <script>
        $(document).ready(function(){
            //
        });
    </script>

@stop