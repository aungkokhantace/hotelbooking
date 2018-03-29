@extends('layouts_frontend.master_frontend')
@section('title','Booking List')
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
                            <h3>{{isset($customer)?$customer->first_name.' '.$customer->last_name:''}}</h3>
                        </div>
                        <div class="side_gmail">
                            <p>{{isset($customer)?$customer->email:''}}</p>
                        </div>
                        <div class="left_menu">
                            <ul>
                                <li><a class="active"href="#">{{trans('frontend_header.booking_list')}}</a></li>
                                <li><a href="/profile">{{trans('frontend_details.my_profile')}}</a></li>
                            </ul>
                        </div>
                    </div>

                </div><!-- Blog Entries Column -->
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="border-bottom:1px solid #ccc;">
                                <ul id="myTab" class="nav nav-tabs nav-justified">
                                    <li class="active">
                                        <a href="#service-one" data-toggle="tab">
                                            {{trans('frontend_details.total_booking')}}({{isset($bookings)?count($bookings):0}})
                                        </a>
                                    </li>
                                    <li class=""><a href="#service-two" data-toggle="tab"> {{trans('frontend_details.cancelled')}}({{isset($booking_cancel)?count($booking_cancel):0}}) </a>
                                    </li>
                                </ul>
                            </div>

                            <div id="myTabContent" class="tab-content">
                                <!--Hotel-->
                                <div class="tab-pane fade active in" id="service-one">
                                    @if(isset($bookings) && count($bookings) > 0)
                                        @foreach($bookings as $booking)
                                        <div id="bookinglist_blog">
                                            <div class="blog_booking">
                                                <div class="col-md-4 left_list">
                                                    <img class="img-responsive img-hover" src="/images/upload/{{$booking->hotel->logo}}" alt="">
                                                </div>
                                                <div>
                                                    <div class="col-md-8 listing_left">
                                                        <div class="listing_tableright pull-right">
                                                            <!-- <h4>status-{{$booking->status_txt}}</h4> -->
                                                            <h3>{{$currency.' '.$booking->total_payable_amt}}</h3>
                                                        </div>
                                                        <h4>{{$booking->hotel->name}}</h4>
                                                        <p>&nbsp;</p>
                                                        <p class="lead">
                                                          <img src="/assets/shared/images/map.png">{{$booking->hotel->address}}
                                                        </p>
                                                        <h4>Status - {{$booking->status_txt}}</h4>

                                                        <table>
                                                            <tr>
                                                                <td>{{trans('frontend_details.booking')}}</td>
                                                                <td>{{$booking->booking_no}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{trans('frontend_details.check_in')}}</td>
                                                                <td>
                                                                    {{Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y')}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{trans('frontend_details.check_out')}}</td>
                                                                <td>
                                                                    {{Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y')}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{trans('frontend_details.number_of_room')}}</td>
                                                                <td>{{$booking->number_of_room}}</td>
                                                            </tr>
                                                        </table>
                                                        <p>&nbsp;</p>
                                                        @if($booking->status == 1)
                                                            <a class="bookinglist-manage" href="#">{{$booking->button_status}}</a>
                                                        @elseif($booking->status == 2 || $booking->status == 5)
                                                            <a class="bookinglist-manage" href="#" onclick='manage("{{$booking->id}}")'>
                                                                {{$booking->button_status}}
                                                            </a>
                                                        @elseif($booking->status == 7 || $booking->status == 9)
                                                         <a class="bookinglist-primary" href="/hotel_detail/{!! $booking->hotel_id!!}">
                                                                {{$booking->button_status}}
                                                            </a>
                                                        @else
                                                            <a class="bookinglist-primary" href="/hotel_detail/{!! $booking->hotel_id!!}">{{$booking->button_status}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif

                                </div>
                                <!--Map-->
                                <!-- For Booking Cancel Tab-->
                                <div class="tab-pane fade" id="service-two">
                                    @if(isset($booking_cancel) && count($booking_cancel) > 0)
                                        @foreach($booking_cancel as $b_cancel)
                                        <div id="bookinglist_blog">
                                            <div class="blog_booking">
                                                <div class="col-md-4 left_list">
                                                    <img class="img-responsive img-hover" src="/images/upload/{{$b_cancel->hotel->logo}}" alt="">
                                                </div>
                                                <div>
                                                    <div class="col-md-8 listing_left">

                                                        <div class="listing_tableright pull-right">
                                                            <!-- <h4>status-{{$b_cancel->status_txt}}</h4> -->
                                                            <h3>{{$currency.' '.number_format($b_cancel->total_payable_amt,2)}}</h3>
                                                        </div>
                                                        <h4>{{$b_cancel->hotel->name}}</h4>
                                                        <p>&nbsp;</p>
                                                        <p class="lead">
                                                            <img src="/assets/shared/images/map.png">{{$b_cancel->hotel->address}}
                                                        </p>
                                                        <h4>Status - {{$b_cancel->status_txt}}</h4>
                                                        <!-- <h3>{{$currency.' '.number_format($b_cancel->total_payable_amt,2)}}</h3> -->
                                                        <table>
                                                            <tr>
                                                                <td>{{trans('frontend_details.booking')}}</td>
                                                                <td>{{$b_cancel->booking_no}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{trans('frontend_details.check_in')}}</td>
                                                                <td>
                                                                    {{Carbon\Carbon::parse($b_cancel->check_in_date)->format('M d, Y')}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{trans('frontend_details.check_out')}}</td>
                                                                <td>
                                                                    {{Carbon\Carbon::parse($b_cancel->check_out_date)->format('M d, Y')}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{trans('frontend_details.number_of_room')}}</td>
                                                                <td>{{$b_cancel->number_of_room}}</td>
                                                            </tr>
                                                        </table>
                                                        <p>&nbsp;</p>
                                                        <a class="bookinglist-primary" href="/hotel_detail/{!! $b_cancel->hotel_id!!}">{{trans('frontend_details.book_again')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script>
        function manage(id) {
            window.location ='/booking/manage/' + id;
        }
    </script>

@stop
