@extends('layouts_frontend.master_frontend')
@section('title','Search Hotels')
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
                </div>

                <!-- Blog Entries Column -->
                <div class="col-md-9">
                    <!-- First Blog Post Left -->
                    <div class="search_list">
                        <h2>Vintage Luxury Yacht Hotel</h2>
                        <p class="lead">
                            Egestas dignissim a enim lorem a mus egestas risus porta? Sed. Scelerisque,
                        </p>
                    </div>
                    <!-- First Blog Post Right -->
                    <div class="detail_righttwo">
                        <samp>6378 reviews</samp>
                        <samp>Excellent 8.3</samp>
                    </div>
                    <div class="detail_rightone">
                        <samp>15 % off</samp>
                    </div>
                    <div id="jssor_1" class="slider_one">
                        <div data-u="slides" class="slider_images">
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/01.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-01.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/02.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-02.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/03.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-03.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/04.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-04.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/05.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-05.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/06.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-06.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/07.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-07.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/08.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-08.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/09.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-09.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/10.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-10.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/11.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-11.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/12.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-12.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/01.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-01.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/02.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-02.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/03.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-03.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/04.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-04.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/05.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-05.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/06.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-06.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/07.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-07.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/08.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-08.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/09.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-09.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/10.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-10.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/11.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-11.jpg" />
                            </div>
                            <div>
                                <img data-u="image" src="/assets/shared/images/img/12.jpg" />
                                <img data-u="thumb" src="/assets/shared/images/img/thumb-12.jpg" />
                            </div>
                        </div>
                        <div data-u="slides" class="slider_imagess">
                            <div>
                                <img data-u="image" src="/assets/shared/images/UserBookingList_img.png"  width="100%" height="125px" />
                            </div>
                            <p></p>
                            <div>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d244315.84058469086!2d96.1695098!3d16.903821!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1490344960699" width="100%" height="120" frameborder="0" style="border:1px solid #ccc;padding:3px;" allowfullscreen></iframe>
                            </div>
                        </div>
                        <!-- Thumbnail Navigator -->
                        <div data-u="thumbnavigator" class="jssort01" style="position:absolute;left:0px;bottom:0px;width:800px;height:100px;" data-autocenter="1">
                            <!-- Thumbnail Item Skin Begin -->
                            <div data-u="slides" >
                                <div data-u="prototype" class="p">
                                    <div class="w">
                                        <div data-u="thumbnailtemplate" class="t"></div>
                                    </div>
                                    <div class="c"></div>
                                </div>
                            </div>
                            <!-- Thumbnail Item Skin End -->
                        </div>
                    </div>
                    <div class="detail_text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim .</p>
                    </div>
                    <!-- Service Blocks -->
                    <div class="row margin-bottom-30">
                        <div class="col-md-4">
                            <div class="service">
                                <img class="fa fa-university service-icon" src="/assets/shared/images/main.jpg">
                                <div class="desc">
                                    <h4>Fully Responsive</h4>
                                    <ul>
                                        <li>Free breakfast and free wifi</li>
                                        <li>24-hour front desk</li>
                                        <li>Air conditioning</li>
                                        <li>Daily housekeeping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service">
                                <div class="desc">
                                    <h4>&nbsp;</h4>
                                    <ul>
                                        <li>Front desk safe</li>
                                        <li>Self-server laundry</li>
                                        <li>Luggage storage</li>
                                        <li>Tour/ticket assistance</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service">
                                <img class="fa fa-university service-icon" src="/assets/shared/images/around.jpg">
                                <div class="desc">
                                    <h4>Fully Responsive</h4>
                                    <ul>
                                        <li>Yangon General Hospital (12-minute walk)</li>
                                        <li>Yangon General Hospital (12-minute walk)</li>
                                        <li>Yangon General Hospital (12-minute walk)</li>
                                        <li>Yangon General Hospital (12-minute walk)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Service Blokcs -->
                    <hr>
                    <div class="table-responsive room_table">
                        <h3>Available Rooms</h3>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="150px">Booking Type</th>
                                <th width="220px">Included</th>
                                <th width="65px">Capacity</th>
                                <th width="130px">Price Per Night</th>
                                <th width="80px">Rooms</th>
                                <th width="110px">Booking</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <ul class="fa-ul">
                                        <li class="title_fa">Superior Single</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/cityview.png">City View</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/16sqm.png">16 sq.m</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/signlebed.png">1 single bed</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="fa-ul price_night">
                                        <li><i class="fa-li fa fa-wifi" aria-hidden="true"></i>Free Wifi</li>
                                        <li><span class="fa-li glyphicon glyphicon-cutlery" aria-hidden="true"></span>Good Breakfast</li>
                                        <li class="text_fa">Prices are per room</li>
                                        <li class="text_fa">Included:5% VAT.10% Property</li>
                                        <li class="text_fa">Service Charge</li>
                                    </ul>
                                </td>
                                <td>
                                    <i class="fa-td fa fa-user" aria-hidden="true"></i>
                                </td>
                                <td>
                                    <ul class="fa-ul price_night">
                                        <li>MMK 92,000</li>
                                        <li>Today</li>
                                        <li>Value Deat</li>
                                    </ul>
                                </td>
                                <td>
                                    <input type="number" name="number" class="floatLabel form-control">
                                </td>
                                <td  rowspan="4">
                                    <div class="table_buttom">Book Now</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul class="fa-ul">
                                        <li class="title_fa">Superior Single</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/cityview.png">City View</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/16sqm.png">16 sq.m</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/signlebed.png">1 single bed</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="fa-ul price_night">
                                        <li><i class="fa-li fa fa-wifi" aria-hidden="true"></i>Free Wifi</li>
                                        <li><span class="fa-li glyphicon glyphicon-cutlery" aria-hidden="true"></span>Good Breakfast</li>
                                        <li class="text_fa">Prices are per room</li>
                                        <li class="text_fa">Included:5% VAT.10% Property</li>
                                        <li class="text_fa">Service Charge</li>
                                    </ul>
                                </td>
                                <td>
                                    <i class="fa-td fa fa-user" aria-hidden="true"></i>
                                </td>
                                <td>
                                    <ul class="fa-ul price_night">
                                        <li>MMK 92,000</li>
                                        <li>Today</li>
                                        <li>Value Deat</li>
                                    </ul>
                                </td>
                                <td>
                                    <input type="number" name="number" class="floatLabel form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul class="fa-ul">
                                        <li class="title_fa">Superior Single</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/cityview.png">City View</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/16sqm.png">16 sq.m</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/signlebed.png">1 single bed</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="fa-ul price_night">
                                        <li><i class="fa-li fa fa-wifi" aria-hidden="true"></i>Free Wifi</li>
                                        <li><span class="fa-li glyphicon glyphicon-cutlery" aria-hidden="true"></span>Good Breakfast</li>
                                        <li class="text_fa">Prices are per room</li>
                                        <li class="text_fa">Included:5% VAT.10% Property</li>
                                        <li class="text_fa">Service Charge</li>
                                    </ul>
                                </td>
                                <td>
                                    <i class="fa-td fa fa-user" aria-hidden="true"></i>
                                </td>
                                <td>
                                    <ul class="fa-ul price_night">
                                        <li>MMK 92,000</li>
                                        <li>Today</li>
                                        <li>Value Deat</li>
                                    </ul>
                                </td>
                                <td>
                                    <input type="number" name="number" class="floatLabel form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul class="fa-ul">
                                        <li class="title_fa">Superior Single</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/cityview.png">City View</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/16sqm.png">16 sq.m</li>
                                        <li><img class="fa-lis" src="/assets/shared/images/signlebed.png">1 single bed</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="fa-ul price_night">
                                        <li><i class="fa-li fa fa-wifi" aria-hidden="true"></i>Free Wifi</li>
                                        <li><span class="fa-li glyphicon glyphicon-cutlery" aria-hidden="true"></span>Good Breakfast</li>
                                        <li class="text_fa">Prices are per room</li>
                                        <li class="text_fa">Included:5% VAT.10% Property</li>
                                        <li class="text_fa">Service Charge</li>
                                    </ul>
                                </td>
                                <td>
                                    <i class="fa-td fa fa-user" aria-hidden="true"></i>
                                </td>
                                <td>
                                    <ul class="fa-ul price_night">
                                        <li>MMK 92,000</li>
                                        <li>Today</li>
                                        <li>Value Deat</li>
                                    </ul>
                                </td>
                                <td>
                                    <input type="number" name="number" class="floatLabel form-control">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="room_table">
                        <h3>Facilities of Vintage Luxury Yacht Hotel</h3>
                        <div class="row margin-bottom-30">
                            <div class="col-md-4">
                                <div class="service">
                                    <i class="fa fa-check service-icons" aria-hidden="true"></i>
                                    <div class="desc">
                                        <h5>All Rooms</h5>
                                        <ul class="fa-ul-li">
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Wardrobe Closet</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Sitting area</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Sofa</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Desk</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Minibar</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Satellite channels</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Flat-screen TV</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Telephone</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Cable channels</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Slippers</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Towels</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Toilet</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Shower</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Bathroom</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Linens</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Bathrobe</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Free toiletries</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Hairdryer</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Wake-up service</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Executive Lounge Access</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Soundproof</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Safe</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Carpeted</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="service">
                                    <i class="fa fa-check service-icons" aria-hidden="true"></i>
                                    <div class="desc">
                                        <h5>Some Rooms</h5>
                                        <ul class="fa-ul-li">
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>View</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>River View</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Balcony</li>
                                        </ul>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <div class="service">
                                    <i class="fa fa-check service-icons" aria-hidden="true"></i>
                                    <div class="desc">
                                        <h5>Outdoors</h5>
                                        <ul class="fa-ul-li">
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Sun Desk</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Terrace</li>
                                        </ul>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <div class="service">
                                    <i class="fa fa-check service-icons" aria-hidden="true"></i>
                                    <div class="desc">
                                        <h5>Internet</h5>
                                        <ul class="fa-ul-li">
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Free ! Wifi is available in all areas and free of charge</li>
                                        </ul>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <div class="service">
                                    <i class="fa fa-check service-icons" aria-hidden="true"></i>
                                    <div class="desc">
                                        <h5>Parking</h5>
                                        <ul class="fa-ul-li">
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Free ! Free pirvate parking is available on site <br> ( reservation is note needed )</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="service">
                                    <i class="fa fa-check service-icons" aria-hidden="true"></i>
                                    <div class="desc">
                                        <h5>General</h5>
                                        <ul class="fa-ul-li">
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Room Service</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Airport Shuttle ( surcharge )</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Car Rental</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>VIP Room Facilities</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Airport Shuttle</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Honeymoon Suite</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Packed Lunches</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Designaed Smoking Area</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Newspapers</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Air Conditioning</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Non-smoking Rooms</li>
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>Safe</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Service Blokcs -->
                    </div>
                    <hr>
                    <div class="room_table">
                        <h3>Area Info : </h3>
                        <!-- Service Blocks -->
                        <div class="row margin-bottom-30">
                            <div class="col-md-4">
                                <div class="service">
                                    <img class="service-icon" src="/assets/shared/images/closet.png">
                                    <div class="desc">
                                        <h4> Glosest Landmarks</h4>
                                        <ul class="fa-ul-li">
                                            <li>Botataung Pagoda</li>
                                            <li>British Embassy</li>
                                            <li>Australian Embassy</li>
                                            <li>Pansodan Jetty</li>
                                            <li>Embassy of India</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="service">
                                    <img class="service-icon" src="/assets/shared/images/popu.png">
                                    <div class="desc">
                                        <h4>Most Popular LandMarks</h4>
                                        <ul class="fa-ul-li">
                                            <li>Yangon City Hall</li>
                                            <li>Sule Pagoda</li>
                                            <li>CB Bank Head Office</li>
                                            <li>United Nations Information Center Yangon</li>
                                            <li>Shwedagon Pagoda</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Service Blokcs -->
                        <!-- Service Blocks -->
                        <div class="row margin-bottom-30">
                            <div class="col-md-4">
                                <div class="service">
                                    <img class="service-icon" src="/assets/shared/images/rest.png">
                                    <div class="desc">
                                        <h4>Restaurants & Markets</h4>
                                        <ul class="fa-ul-li">
                                            <li>Monsson</li>
                                            <li>abc supermarket</li>
                                            <li>Bogyoke Market</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="service">
                                    <img class="service-icon" src="/assets/shared/images/natural.png">
                                    <div class="desc">
                                        <h4>Natural Beauty</h4>
                                        <ul class="fa-ul-li">
                                            <li>Yangon River</li>
                                            <li>Inya Lake</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Service Blokcs -->
                    </div>	 <!-- /.room-tabel -->
                    <hr>
                    <div class="room_table">
                        <h3>Good to Know</h3>
                        <div class="hc_m_content">
                            <h4>Check-in</h4>
                            <p>From 14:00</p>
                            <h4>Check-out</h4>
                            <p>Until 12:00</p>
                            <h4>Cancellation<br>Prepayment</h4>
                            <p>Cancellation and prepayment policies vary according to room type.Please check what <a href="#">room conditions</a>may apply when selection your room above</p>
                            <h4>Children and Extra Beds</h4>
                            <p>All Children are welcome.<br>The maximum number of extra beds in a room is 1</p>
                            <h4>Pets</h4>
                            <p>Pets are not allowed</p>
                            <h4>Cards accepted at this property</h4>
                            <p><img src="/assets/shared/images/visa.jpg"></p>
                        </div>
                    </div>	 <!-- /.room-tabel -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div>
    </section>
@stop

@section('page_script')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAJLUg2IEbAOp4gMqRoXpSnjV0w1FDfYNk&sensor=false" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
            $('#check_in').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true,
            });

            $('#check_out').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true,
            });

            $("#destination").autocomplete({
                source: "/autocompletedestination"
            });

            $(function(){
                $('.filter_checkbox').on('change',function(){
                    $('#search').submit();
                });
            });

            // the selector will match all input controls of class="one_check"
            // and attach a click event handler
            $(".one_check").on('click', function() {
                // in the handler, 'this' refers to the box clicked on
                var $box = $(this);
                if ($box.is(":checked")) {
                    // the name of the box is retrieved using the .attr() method
                    // as it is assumed and expected to be immutable
                    var group = "input:checkbox[name='" + $box.attr("name") + "']";
                    // the checked state of the group/box on the other hand will change
                    // and the current value is retrieved using .prop() method
                    $(group).prop("checked", false);
                    $box.prop("checked", true);
                } else {
                    $box.prop("checked", false);
                }
            });

            $('#search').validate({
                rules: {
                    destination                    : 'required',
                },
                messages: {
                    destination                    : 'Destination is required',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });

        });

    </script>
@stop