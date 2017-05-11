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
                        @include('layouts_frontend.partial_frontend.search_form')
                    </div>
                </div>

                <!-- Blog Entries Column -->
                <div class="col-md-9">
                    <!-- First Blog Post Left -->
                    <div class="search_list">
                        <h2>{{$hotel->name}}</h2>
                        <p class="lead">
                            {{$hotel->address}}
                        </p>
                    </div>
                    <!-- First Blog Post Right -->
                    <!-- <div class="detail_righttwo">
                        <samp>6378 reviews</samp>
                        <samp>Excellent 8.3</samp>
                    </div> -->
                    <div class="detail_rightone">
                        @if(isset($hotel->discount) && $hotel->discount != null)
                            <samp>{{$hotel->discount}} off</samp>
                        @endif
                    </div>
                    <div id="jssor_1" class="slider_one">
                        <div data-u="slides" class="slider_images">
                            @if(isset($roomCategoryImages) && count($roomCategoryImages)>0)
                                @foreach($roomCategoryImages as $roomCategoryImage)
                                    <div>
                                        <img data-u="image" src="{{$roomCategoryImage->img_path}}" />
                                        <img data-u="thumb" src="{{$roomCategoryImage->img_path}}" />
                                    </div>
                                @endforeach
                            @else
                                <div>
                                    <img data-u="image" src="/images/upload/{{$hotel->logo}}" />
                                    <img data-u="thumb" src="/images/upload/{{$hotel->logo}}" />
                                </div>
                            @endif
                        </div>
                        <div data-u="slides" class="slider_imagess">
                            <div>
                                <img data-u="image" src="/images/upload/{{$hotel->logo}}"  width="100%" height="125px" />
                            </div>
                            <p></p>
                            <div>
                                {{--<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d244315.84058469086!2d96.1695098!3d16.903821!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1490344960699" width="100%" height="120" frameborder="0" style="border:1px solid #ccc;padding:3px;" allowfullscreen></iframe>--}}
                                <div id="map" style="width: 100%; height: 122px;"></div>
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
                        <p>{{$hotel->description}}</p>
                    </div>

                    <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                    <input type="hidden" id="latitude" name="latitude" value="{{isset($hotel)? $hotel->latitude:''}}"/>
                    <input type="hidden" id="longitude" name="longitude" value="{{isset($hotel)? $hotel->longitude:''}}"/>

                    <!-- Service Blocks -->
                    <div class="row margin-bottom-30">
                        <div class="col-md-6">
                            <div class="service">
                                <img class="fa fa-university service-icon" src="/assets/shared/images/main.jpg">
                                <div class="desc">
                                    <h4>Main amenities</h4>
                                    <ul>
                                        @foreach($amenities as $amenity)
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$amenity->amenity->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="service">
                                <img class="fa fa-university service-icon" src="/assets/shared/images/around.jpg">
                                <div class="desc">
                                    <h4>What's around</h4>
                                    <ul>
                                        <!-- airport -->
                                        @foreach($hotel_nearby['airport'] as $nearby_airport)
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$nearby_airport->name}} ( {{$nearby_airport->distance}} )</li>
                                        @endforeach

                                        <!-- station -->
                                        @foreach($hotel_nearby['station'] as $nearby_station)
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$nearby_station->name}} ( {{$nearby_station->distance}} )</li>
                                        @endforeach

                                        <!-- hospital -->
                                        @foreach($hotel_nearby['hospital'] as $nearby_hospital)
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$nearby_hospital->name}} ( {{$nearby_hospital->distance}} )</li>
                                        @endforeach

                                        <!-- convenience store -->
                                        @foreach($hotel_nearby['convenience_store'] as $nearby_convenience_store)
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$nearby_convenience_store->name}} ( {{$nearby_convenience_store->distance}} )</li>
                                        @endforeach

                                        <!-- drug store -->
                                        @foreach($hotel_nearby['drug_store'] as $nearby_drug_store)
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$nearby_drug_store->name}} ( {{$nearby_drug_store->distance}} )</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Service Blocks -->
                    <hr>
                    <div class="table-responsive room_table">
                        <h3>Available Rooms</h3>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="150px">Room Category</th>
                                <th width="220px">Included</th>
                                <th width="65px">Capacity</th>
                                <th width="130px">Price Per Night</th>
                                <th width="80px">Rooms</th>
                                <th width="110px">Booking</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($roomCategories as $roomCategory)
                                @if($roomCategory->available_room_count > 0)
                                <tr>
                                    <td>
                                        <ul class="fa-ul">
                                            <li class="title_fa">{{$roomCategory->name}}</li>
                                            <li><img class="fa-lis" src="/assets/shared/images/cityview.png">City View</li>
                                            <li><img class="fa-lis" src="/assets/shared/images/16sqm.png">{{$roomCategory->square_metre}} s.q.m</li>
                                            <li><img class="fa-lis" src="/assets/shared/images/signlebed.png">{{$roomCategory->bed_type}}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="fa-ul price_night">
                                            @foreach($roomCategory->room_amenities as $room_amenity)
                                                <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$room_amenity->amenity->name}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= $roomCategory->capacity; $i++)
                                            <i class="fa-td fa fa-user" aria-hidden="true"></i>
                                        @endfor

                                    </td>
                                    <td>
                                        <ul class="fa-ul price_night">
                                            <li>MMK {{$roomCategory->price}}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <input type="number" name="number" class="floatLabel form-control" min="0" max="{{$roomCategory->available_room_count}}">
                                    </td>

                                    <td>
                                        <div class="table_buttom">Book Now</div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="room_table">
                        <h3>Facilities of {{$hotel->name}}</h3>
                        <div class="row margin-bottom-30">
                            @foreach($facilityGroupArray as $facilityGroup)
                                @if(isset($facilityGroup->facilities) && count($facilityGroup->facilities)>0)
                                    <div class="col-md-4">
                                        <div class="service">
                                            <i class="fa fa-check service-icons" aria-hidden="true"></i>
                                            <div class="desc">
                                                <h5>{{$facilityGroup->name}}</h5>
                                                <ul class="fa-ul-li">
                                                    @foreach($facilityGroup->facilities as $facility)
                                                        <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$facility->facility->name}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div><!-- End Service Blocks -->
                    </div>
                    <hr>
                    <div class="room_table">
                        <h3>Area Info : </h3>
                        <!-- Service Blocks -->
                        <div class="row margin-bottom-30">
                            <div class="col-md-6">
                                <div class="service">
                                    <img class="service-icon" src="/assets/shared/images/closet.png">
                                    <div class="desc">
                                        <h4> Closest Landmarks</h4>
                                        <ul class="fa-ul-li">
                                            @foreach($landmarks as $landmark)
                                                <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$landmark->landmark->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if(isset($popularLandmarks))
                            <div class="col-md-6">
                                <div class="service">
                                    <img class="service-icon" src="/assets/shared/images/popu.png">
                                    <div class="desc">
                                        <h4>Most Popular LandMarks</h4>
                                        <ul class="fa-ul-li">
                                            @foreach($popularLandmarks as $popularLandmark)
                                                <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$popularLandmark->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div><!-- End Service Blokcs -->
                        <!-- Service Blocks -->
                        <!--    <div class="row margin-bottom-30">
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
                            <p>From {{$hotel->check_in_time}}</p>
                            <h4>Check-out</h4>
                            <p>Until {{$hotel->check_out_time}}</p>
                            <h4>Extra Bed</h4>
                            <p>The maximum number of extra beds in a room is 1</p>
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
            //init function
            google.maps.event.trigger(map, 'resize');
            var latitude  = $("#latitude").val();
            var longitude = $("#longitude").val();
//            setTimeout(executeQuery(latitude,longitude), 3000);
            setTimeout(renderMap(latitude,longitude), 3000);

            var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
            $('#check_in').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true,
                startDate: today
            });

            $('#check_out').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true,
                startDate: today
            });

            $("#destination").autocomplete({
                source: "/autocompletedestination"
            });

            $(function(){
                $('.filter_checkbox').on('change',function(){
                    $('#search').submit();
                });
            });

            $('#search').validate({
                rules: {
                    destination                    : 'required',
                    check_in                       : 'required',
                    check_out                      : 'required',
                },
                messages: {
                    destination                    : 'Destination is required',
                    check_in                       : 'Check-in Date is required',
                    check_out                      : 'Check-out Date is required',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });

        });

        function renderMap(latitude,longitude) {
//            google.maps.event.trigger(map, 'resize');
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: new google.maps.LatLng(latitude, longitude), //dynamic center point
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var marker, i;

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(latitude, longitude),
                map: map
            });
        }

    </script>


@stop