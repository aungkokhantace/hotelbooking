@extends('layouts_frontend.master_frontend')
@section('title','Search Hotels')
@section('content')
        <div id="header_id">
            <img class="img-responsive img-hover" src="shared/images/slider1.png">
        </div>
    </div>

    </section>

    <section id="popular">
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <!-- Blog Sidebar Widgets Column -->
                <div class="col-md-3">
                    <!-- Blog Search Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="side_title">
                            <h5>Search Hotel</h5>
                        </div>
                        <p></p>
                        <form role="form" class="sr_news">
                            <label class="control-label" for="destination">Destination</label>
                            <div class="col-10 input-group">
                                <input class="form-control font_sz_11" type="text" value="" id="destination">
                                <div class="input-group-addon">
                                    <i class="fa fa-plane" aria-hidden="true"></i>
                                </div>
                            </div>
                            <p></p>
                            <label class="control-label" for="check_in">Check In</label>
                            <div class="col-10 input-group date" data-provide="datepicker">
                                <input type="text" class="form-control">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <label class="control-label" for="check_out">Check Out</label>
                            <div class="col-10 input-group date" data-provide="datepicker">
                                <input type="text" class="form-control">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 pd_rg_10">
                                    <label class="control-label" for="check_out">Room</label>
                                    <input type="number" id="street-number" class="floatLabel form-control" name="street-number">
                                </div>
                                <div class="col-sm-4 pd_lf_5">
                                    <label class="control-label" for="check_out">Adults</label>
                                    <input type="number" id="street-number" class="floatLabel form-control" name="street-number">
                                </div>
                                <div class="col-sm-4 pd_lf_5">
                                    <label class="control-label" for="check_out">Children</label>
                                    <input type="number" id="street-number" class="floatLabel form-control" name="street-number">
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-xs">Search Hotel</button>
                                </div>
                            </div>
                            <p></p>
                        </form>
                    </div>
                    <!-- Blog Search Well -->
                    <div class="bg_block_sm pd_10">
                        <!-- <div class="search_form">
                            <div class="input-group">
                                <input type="text" class="formcontrol font_sz_11" placeholder="Filter By : ">
                                <div class="input-group-addon">
                                     <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </div>

                            </div>
                        </div>   -->
                        <div class="side_title">
                            <h5>Search Hotel</h5>
                        </div>
                        <div class="list_style">
                            <input type="checkbox"> <span>MMK 0-MMK 70,000 per night</span><br>
                            <input type="checkbox"> <span>MMK 70,000-MMK 140,000 per night</span><br>
                            <input type="checkbox"> <span>MMK 70,000-MMK 140,000 per night</span><br>
                            <input type="checkbox"> <span>MMK 70,000-MMK 140,000 per night</span><br>
                            <input type="checkbox"> <span>MMK 70,000-MMK 140,000 per night</span><br>
                        </div>
                    </div>
                    <!-- Blog Filter By Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="search_form">
                            <div class="input-group">
                                <input type="text" class="formcontrol font_sz_11" placeholder="Filter By : ">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </div>

                            </div>
                        </div>
                        <div class="list_style">
                            <input type="checkbox"> <span>MMK 0-MMK 70,000 per night</span><br>
                            <input type="checkbox"> <span>MMK 70,000-MMK 140,000 per night</span><br>
                            <input type="checkbox"> <span>MMK 70,000-MMK 140,000 per night</span><br>
                            <input type="checkbox"> <span>MMK 70,000-MMK 140,000 per night</span><br>
                            <input type="checkbox"> <span>MMK 70,000-MMK 140,000 per night</span><br>
                        </div>
                    </div>
                    <!-- Blog Star Rating Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="side_title">
                            <h5>Star Rating</h5>
                        </div>
                        <div class="list_style">
                            <input type="checkbox"> <span> No Preference</span><br>
                            <input type="checkbox"> <span> 1 Stars</span><br>
                            <input type="checkbox"> <span> 2 Stars</span><br>
                            <input type="checkbox"> <span> 3 Stars</span><br>
                            <input type="checkbox"> <span> 4 Stars</span><br>
                            <input type="checkbox"> <span> 5 Stars</span><br>
                            <input type="checkbox"> <span> 6 Stars</span><br>
                            <input type="checkbox"> <span> 7 Stars</span><br>
                            <input type="checkbox"> <span> Unrated</span><br>
                        </div>
                    </div>
                    <!-- Blog Facility Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="side_title">
                            <h5>Facility</h5>
                        </div>
                        <div class="list_style">
                            <input type="checkbox"> <span> Airport Shuttle</span><br>
                            <input type="checkbox"> <span> Free WIFI</span><br>
                            <input type="checkbox"> <span> Non-smoking Rooms</span><br>
                            <input type="checkbox"> <span> Parking</span><br>
                            <input type="checkbox"> <span> Room Service</span><br>
                            <input type="checkbox"> <span> Restaurant</span><br>
                            <input type="checkbox"> <span> Spa</span><br>
                            <input type="checkbox"> <span> Swimming Pool</span><br>
                            <input type="checkbox"> <span> Fitness Center</span><br>
                            <input type="checkbox"> <span> Restaurant</span><br>
                            <input type="checkbox"> <span> Family Rooms</span><br>
                            <input type="checkbox"> <span> Facilities for Disabled Guests</span><br>
                            <input type="checkbox"> <span> Pet Friendly</span><br>
                        </div>
                    </div>
                    <!-- Blog Popular Places Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="side_title">
                            <h5>Popular Places</h5>
                        </div>
                        <div class="list_style">
                            <input type="checkbox"> <span> Shwe Dagon Pagoda</span><br>
                            <input type="checkbox"> <span> Sule Pagoda</span><br>
                            <input type="checkbox"> <span> Inya Lake</span><br>
                            <input type="checkbox"> <span> Saint Mary's Cathedral</span><br>
                            <input type="checkbox"> <span> Kandawgyi Park</span><br>
                            <input type="checkbox"> <span> Bogyoke Aung San Market</span><br>
                            <input type="checkbox"> <span> National Museum</span><br>
                        </div>
                    </div>
                </div>

                <!-- Blog Entries Column -->
                <div class="col-md-9 search_list">
                    <!-- First Blog Post -->
                    @if(count($hotels)>1)
                        <h2>Yangon: {{count($hotels)}} properties found</h2>
                    @else
                        <h2>Yangon: {{count($hotels)}} property found</h2>
                    @endif

                    {{ isset($hotel)? $hotel->name:Request::old('name') }}
                    <p class="lead">
                        3 Reasons to Visit: people watching, local food & shopping
                    </p>
                    <!-- Service Tabs -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="border-bottom:1px solid #ccc;">
                                <ul id="myTab" class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#service-one" data-toggle="tab"> Hotels </a>
                                    </li>
                                    <li class=""><a href="#service-two" data-toggle="tab"> Map View </a>
                                    </li>
                                </ul>
                            </div>


                            <div id="myTabContent" class="tab-content">
                                <!--Hotel-->
                                <div class="tab-pane fade active in" id="service-one">
                                    @foreach($hotels as $hotel)
                                        <div class="blog">
                                            <div class="left_img">
                                                <img class="img-responsive img-hover" src="/images/upload/{{$hotel->logo}}" alt="">
                                            </div>
                                            <div class="left_blog">
                                                <div class="lead_left">
                                                    <h4>{{$hotel->name}}</h4>
                                                    <p class="lead">
                                                        <i class="fa fa-map-marker" aria-hidden="true"></i>   {{$hotel->township->name}}, {{$hotel->city->name}}
                                                    </p>
                                                </div>
                                                <div class="lead_right pull-right">
                                                    @for ($i = 1; $i <= $hotel->star; $i++)
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="right_blog">
                                                <div class="lead-left">
                                                    <ul>
                                                        <li> {{ isset($hotel->room_type)? $hotel->room_type:'' }} </li>
                                                        <li>
                                                            <table border="1">
                                                                <tr>
                                                                    <td>
                                                                        <i class="fa fa-wifi" aria-hidden="true"></i>
                                                                    </td>
                                                                    <td>&nbsp;</td>
                                                                    <td>
                                                                        <i class="fa fa-wifi" aria-hidden="true"></i>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="lead-right">
                                                    <ul>
                                                        {{--<li><small style="text-decoration: line-through;">MMK 140000</small></li>--}}
                                                        {{--<li>MMK {{$hotel->min_price}}</li>--}}
                                                        <li>{{ isset($hotel->min_price)? 'MMK '.$hotel->min_price:'' }}</li>
                                                        <li>
                                                            <a class="btn btn-primary" href="#">BOOKING NOW</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!--Suggested Hotels are shown if search result count is less than 10 -->
                                    @if(isset($suggestedHotels) && count($suggestedHotels)>0 && count($hotels)<10)
                                    <br><br>
                                    <h2>Suggested Hotels</h2>
                                    <!--Suggested Hotels-->
                                    @foreach($suggestedHotels as $suggestedHotelhotel)
                                        <div class="blog">
                                            <div class="left_img">
                                                <img class="img-responsive img-hover" src="/images/upload/{{$suggestedHotelhotel->logo}}" alt="">
                                            </div>
                                            <div class="left_blog">
                                                <div class="lead_left">
                                                    <h4>{{$suggestedHotelhotel->name}}</h4>
                                                    <p class="lead">
                                                        <i class="fa fa-map-marker" aria-hidden="true"></i>   {{$suggestedHotelhotel->township->name}}, {{$suggestedHotelhotel->city->name}}
                                                    </p>
                                                </div>
                                                <div class="lead_right pull-right">
                                                    @for ($i = 1; $i <= $suggestedHotelhotel->star; $i++)
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="right_blog">
                                                <div class="lead-left">
                                                    <ul>
                                                        <li> {{ isset($suggestedHotelhotel->room_type)? $suggestedHotelhotel->room_type:'' }} </li>
                                                        <li>
                                                            <table border="1">
                                                                <tr>
                                                                    <td>
                                                                        <i class="fa fa-wifi" aria-hidden="true"></i>
                                                                    </td>
                                                                    <td>&nbsp;</td>
                                                                    <td>
                                                                        <i class="fa fa-wifi" aria-hidden="true"></i>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="lead-right">
                                                    <ul>
                                                        {{--<li><small style="text-decoration: line-through;">MMK 140000</small></li>--}}
                                                        {{--<li>MMK {{$suggestedHotelhotel->min_price}}</li>--}}
                                                        <li>{{ isset($suggestedHotelhotel->min_price)? 'MMK '.$suggestedHotelhotel->min_price:'' }}</li>
                                                        <li>
                                                            <a class="btn btn-primary" href="#">BOOKING NOW</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    <!--Suggested Hotels-->
                                    @endif
                                </div>
                                <!--Map-->
                                <div class="tab-pane fade" id="service-two">
                                    <div class="blog">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d244315.84058469086!2d96.1695098!3d16.903821!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1490344960699" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
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
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
        });
    </script>
@stop