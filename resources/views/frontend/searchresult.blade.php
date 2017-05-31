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

                        <p></p>
                    </div>
                    <!-- Blog Search Well -->
                    <div class="bg_block_sm pd_10">

                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">

                        <div class="side_title">
                            <h5>Search Hotel</h5>
                        </div>
                        <div class="list_style">
                            @if(Session::has('room'))
                                <input type="number" id="room" class="floatLabel form-control" name="room" value="{{session('room')}}">
                            @else
                                <input type="number" id="room" class="floatLabel form-control" name="room" value="">
                            @endif
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="0-50000" @if(Session::has('price_filter') && session('price_filter')[0]=="0-50000") checked @endif> <span>MMK 0 - 50,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="50000-100000" @if(Session::has('price_filter') && session('price_filter')[0]=="50000-100000") checked @endif> <span>MMK 50,000 - 100,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="100000-150000" @if(Session::has('price_filter') && session('price_filter')[0]=="100000-150000") checked @endif> <span>MMK 100,000 - 150,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="150000-200000" @if(Session::has('price_filter') && session('price_filter')[0]=="150000-200000") checked @endif> <span>MMK 150,000 - 200,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="200000-250000" @if(Session::has('price_filter') && session('price_filter')[0]=="200000-250000") checked @endif> <span>MMK 200,000 - 250,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="250000-300000" @if(Session::has('price_filter') && session('price_filter')[0]=="250000-300000") checked @endif> <span>MMK 250,000 - 300,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="300000-350000" @if(Session::has('price_filter') && session('price_filter')[0]=="300000-350000") checked @endif> <span>MMK 300,000 - 350,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="350000-400000" @if(Session::has('price_filter') && session('price_filter')[0]=="350000-400000") checked @endif> <span>MMK 350,000 - 400,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="400000-450000" @if(Session::has('price_filter') && session('price_filter')[0]=="400000-450000") checked @endif> <span>MMK 400,000 - 450,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="450000-500000" @if(Session::has('price_filter') && session('price_filter')[0]=="450000-500000") checked @endif> <span>MMK 450,000 - 500,000 per night</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="price_filter[]" value="above500000" @if(Session::has('price_filter') && session('price_filter')[0]=="above500000") checked @endif> <span>Above MMK 500,000 per night</span><br>
                        </div>
                    </div>

                    <!-- Blog Star Rating Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="side_title">
                            <h5>Star Rating</h5>
                        </div>
                        <div class="list_style">
                            <input type="checkbox" class="filter_checkbox one_check" name="star_filter[]" value="1" @if(Session::has('star_filter') && session('star_filter')[0]=="1") checked @endif> <span> 1 Star</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="star_filter[]" value="2" @if(Session::has('star_filter') && session('star_filter')[0]=="2") checked @endif> <span> 2 Stars</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="star_filter[]" value="3" @if(Session::has('star_filter') && session('star_filter')[0]=="3") checked @endif> <span> 3 Stars</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="star_filter[]" value="4" @if(Session::has('star_filter') && session('star_filter')[0]=="4") checked @endif> <span> 4 Stars</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="star_filter[]" value="5" @if(Session::has('star_filter') && session('star_filter')[0]=="5") checked @endif> <span> 5 Stars</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="star_filter[]" value="6" @if(Session::has('star_filter') && session('star_filter')[0]=="6") checked @endif> <span> 6 Stars</span><br>
                            <input type="checkbox" class="filter_checkbox one_check" name="star_filter[]" value="7" @if(Session::has('star_filter') && session('star_filter')[0]=="7") checked @endif> <span> 7 Stars</span><br>
                        </div>
                    </div>
                    <!-- Blog Facility Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="side_title">
                            <h5>Facility</h5>
                        </div>
                        <div class="list_style">
                            @foreach($facilities as $facility)
                                {{--<input type="checkbox" class="filter_checkbox" name="facility_filter[{{$facility->id}}]" value="{{$facility->id}}" @if(Session::has('facility_filter') && in_array($facility->id,session('facility_filter'))) checked @endif> <span> {{$facility->name}}</span><br>--}}
                                <input type="checkbox" class="filter_checkbox" name="facility_filter[]" value="{{$facility->id}}" @if(Session::has('facility_filter') && in_array($facility->id,session('facility_filter'))) checked @endif> <span> {{$facility->name}}</span><br>
                            @endforeach
                        </div>
                    </div>
                    <!-- Blog Popular Places Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="side_title">
                            <h5>Popular Places</h5>
                        </div>
                        <div class="list_style">
                            @foreach($landmarks as $landmark)
                                <input type="checkbox" class="filter_checkbox" name="landmark_filter[]" value="{{$landmark->id}}" @if(Session::has('landmark_filter') && in_array($landmark->id,session('landmark_filter'))) checked @endif> <span> {{$landmark->name}}</span><br>
                            @endforeach
                        </div>
                    </div>
                </div>

                {!! Form::close() !!}

                <input type="hidden" id="searched_destination" name="searched_destination" value="{{isset($destination)? $destination:''}}"/>

                <!-- Blog Entries Column -->
                <div class="col-md-9 search_list">
                    <!-- First Blog Post -->
                    @if(count($hotels)>1)
                        <h2>{{isset($destination) && $destination != "" ? $destination:'Destination'}} : {{count($hotels)}} properties found</h2>
                    @else
                        <h2>{{isset($destination) && $destination != "" ? $destination:'Destination'}} : {{count($hotels)}} property found</h2>
                    @endif

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
                                                <a href="/hotel_detail/{{$hotel->id}}"><img class="img-responsive img-hover" src="/images/upload/{{$hotel->logo}}" alt=""></a>
                                            </div>
                                            <div class="left_blog">
                                                <div class="lead_left">
                                                    <a href="/hotel_detail/{{$hotel->id}}"><h4>{{$hotel->name}}</h4></a>
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
                                                            <a class="btn btn-primary" href="/hotel_detail/{{$hotel->id}}">BOOKING NOW</a>
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
                                                <a href="/hotel_detail/{{$suggestedHotelhotel->id}}"><img class="img-responsive img-hover" src="/images/upload/{{$suggestedHotelhotel->logo}}" alt=""></a>
                                            </div>
                                            <div class="left_blog">
                                                <div class="lead_left">
                                                    <a href="/hotel_detail/{{$suggestedHotelhotel->id}}"><h4>{{$suggestedHotelhotel->name}}</h4></a>
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
                                                            <a class="btn btn-primary" href="/hotel_detail/{{$suggestedHotelhotel->id}}">BOOKING NOW</a>
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
                                    {{--<div class="blog">--}}
                                        {{--<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d244315.84058469086!2d96.1695098!3d16.903821!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1490344960699" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>--}}
                                    {{--</div>--}}
                                    <br>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div id="map" style="width: 100%; height: 450px;"></div>
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
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAJLUg2IEbAOp4gMqRoXpSnjV0w1FDfYNk&sensor=false" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {

            //to display google map after changing bootstrap tab
            $("a[href='#service-two']").on('shown.bs.tab', function(){
                google.maps.event.trigger(map, 'resize');

                //init function after tab opens
                var destination = $("#searched_destination").val(); //get destination

                //get price filter
                var price_filter = [];
                $("input:checkbox[name='price_filter[]']:checked").each(function(){
                    price_filter.push($(this).val());
                });

                //get star filter
                var star_filter = [];
                $("input:checkbox[name='star_filter[]']:checked").each(function(){
                    star_filter.push($(this).val());
                });

                //get facility filter
                var facility_filter = [];
                $("input:checkbox[name='facility_filter[]']:checked").each(function(){
                    facility_filter.push($(this).val());
                });

                //get landmark filter
                var landmark_filter = [];
                $("input:checkbox[name='landmark_filter[]']:checked").each(function(){
                    landmark_filter.push($(this).val());
                });

                setTimeout(executeQuery(destination,price_filter,star_filter,facility_filter,landmark_filter), 3000);
            });

//            //init function
//            google.maps.event.trigger(map, 'resize');
//            var destination = $("#searched_destination").val();
//            setTimeout(executeQuery(destination), 3000);

//            var nowDate = new Date();
//            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
            /* $('#check_in').datepicker({
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
            }); */

            //Date Picker with controls of from date and to date
            $("#check_in").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                showButtonPanel: true,
                startDate: new Date()
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate() + 1);
                $('#check_out').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('#check_out').datepicker('setStartDate',null);
            });

            $("#check_out").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                startDate: new Date()
            }).on('changeDate', function (selected) {
                var endDate = new Date(selected.date.valueOf());
                $('#check_in').datepicker('setEndDate', endDate);
            }).on('clearDate', function (selected) {
                $('#check_in').datepicker('setEndDate',null);
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

        function executeQuery(destination,price_filter,star_filter,facility_filter,landmark_filter) {
            var parameters = $(this).serializeArray();
//            var destination_string = JSON.stringify(a);
            parameters.push({name: '_token', value: $('#token').val()});

            parameters.push({name: 'destination', value: destination});

            var price_filter_string = JSON.stringify(price_filter);
            parameters.push({name: 'price_filter', value: price_filter_string});

            var star_filter_string = JSON.stringify(star_filter);
            parameters.push({name: 'star_filter', value: star_filter_string});

            var facility_filter_string = JSON.stringify(facility_filter);
            parameters.push({name: 'facility_filter', value: facility_filter_string});

            var landmark_filter_string = JSON.stringify(landmark_filter);
            parameters.push({name: 'landmark_filter', value: landmark_filter_string});

            $.ajax({
//                url: 'getlocations/'+destination,
                url: '/getlocations',
                data: parameters,
                type: "post",
                success: function(data) {
                    locations = data;
                    renderMap(locations);
                }
            });
        }

        function renderMap(locations) {
//            google.maps.event.trigger(map, 'resize');
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
//                center: new google.maps.LatLng(16.8978811, 96.17212638),
                center: new google.maps.LatLng(locations[0][1], locations[0][2]), //dynamic center point
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        }
    </script>
@stop