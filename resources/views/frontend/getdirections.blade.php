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

            <div class="row hotel_info">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <span class="glyphicon glyphicon-map-marker"></span>{{trans('frontend_details.direction_to')}}<br>
                        <span>{{$hotel->name}}</span><br>
                        <img class="fit_in_div" src="/images/upload/{{$hotel->logo}}"><br>
                        {{$hotel->address}}<br>
                        {{trans('frontend_details.latitude')}} : {{$hotel->latitude}}, {{trans('frontend_details.longitude')}} : {{$hotel->longitude}}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="map" style="width: 100%; height: 450px;"></div>
                </div>
            </div>
        </div><!-- /.container -->
    </section><!-- /.section -->
@stop

@section('page_script')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAJLUg2IEbAOp4gMqRoXpSnjV0w1FDfYNk&sensor=false" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function(){
            //init function
            google.maps.event.trigger(map, 'resize');
            var latitude  = $("#latitude").val();
            var longitude = $("#longitude").val();
            setTimeout(renderMap(latitude,longitude), 3000);
        });

        function renderMap(latitude,longitude) {
//            google.maps.event.trigger(map, 'resize');
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: new google.maps.LatLng(latitude, longitude), //dynamic center point
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

//            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(latitude, longitude),
                map: map
            });

//            google.maps.event.addListener(marker, 'click', (function (marker, i) {
//                return function () {
////                    infowindow.setContent(locations[i][0]);
//                    infowindow.setContent('hello world');
//                    infowindow.open(map, marker);
//                }
//            })(marker, i));
        }

    </script>
@stop
