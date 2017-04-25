@extends('layouts.master')
@section('title','Samples')
@section('content')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAJLUg2IEbAOp4gMqRoXpSnjV0w1FDfYNk&sensor=false" type="text/javascript"></script>
        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Google Map Api Sample</h1>
    <input type="hidden" id="hidden_input" name="hidden_input">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="map" style="width: 500px; height: 400px;"></div>
            <script type="text/javascript">

                function renderMap(locations1) {

//                    var locations = [
//                    ['Bondi Beach', -33.890542, 151.274856, 4],
//                    ['Coogee Beach', -33.923036, 151.259052, 5],
//                    ['Cronulla Beach', -34.028249, 151.157507, 3],
//                    ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
//                    ['Maroubra Beach', -33.950198, 151.259302, 1]
//                ];

                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 10,
                        center: new google.maps.LatLng(-33.92, 151.25),
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
        </div>
    </div>
</div>
@stop

@section('page_script')
<script>


    function executeQuery() {
        $.ajax({
        url: 'getlocations',
        success: function(data) {
            locations = data;
            renderMap(locations);
        }
        });
    }

    $(document).ready(function() {
        setTimeout(executeQuery, 1);

    });
</script>

@stop