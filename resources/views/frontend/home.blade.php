@extends('layouts_frontend.master_frontend')
@section('title','Home Page')
@section('content')

    <div id="header_id">
        <!-- Header Carousel -->
        <header id="myCarousel" class="carousel slide">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="fill"><img src="/assets/shared/images/slider.png"></div>
                    <div class="carousel-caption">
                        <h1 class="container">Where your journey begins.</h1>
                        <p class="container">Discover your next great adventure, become an explorer to get started!</p>
                    </div>
                </div>
                <div class="item">
                    <div class="fill"><img src="/assets/shared/images/slider.png"></div>
                    <div class="carousel-caption">
                        <h1 class="container">Where your journey begins.</h1>
                        <p class="container">Discover your next great adventure, become an explorer to get started!</p>
                    </div>
                </div>
                <div class="item">
                    <div class="fill"><img src="/assets/shared/images/slider.png">
                    </div>
                    <div class="carousel-caption">
                        <h1 class="container">Where your journey begins.</h1>
                        <p class="container">Discover your next great adventure, become an explorer to get started!</p>
                    </div>
                </div>

                @foreach($sliders as $slider)
                    <div class="item active">
                        <div class="fill"><img src="/assets/shared/images/{{ $slider->image_url }}"></div>
                        <div class="carousel-caption">
                            <h1 class="container">{{ $slider->title }}</h1>
                            <p class="container">{{ $slider->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </header>
    </div>

    <div id="form_id">
        <div class="container">
            <div class="col-md-4 form">
                <h2>Search Hotel</h2>

                {!! Form::open(array('url' => '/search','files'=>true, 'id'=>'search', 'class'=> 'form-horizontal user-form-border')) !!}
                    <div class="form-group row">
                        <label class="control-label" for="destination">Destination</label>
                        <div class="col-10 input-group">
                            <input class="form-control font_sz_11" type="text" value="" id="destination" name="destination" autocomplete="off">
                            <div class="input-group-addon">
                                <i class="fa fa-plane" aria-hidden="true"></i>
                            </div>
                            <p class="text-danger">{{$errors->first('destination')}}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label" for="check_in">Check In</label>
                        <div class="col-10 input-group date" data-provide="datepicker" id="check_in">
                            <input type="text" class="form-control" name="check_in" autocomplete="off">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                            <p class="text-danger">{{$errors->first('check_in')}}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label" for="check_out">Check Out</label>
                        <div class="col-10 input-group date" data-provide="datepicker" id="check_out" autocomplete="off">
                            <input type="text" class="form-control" name="check_out">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                            <p class="text-danger">{{$errors->first('check_out')}}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-10">
                            <div class="col-3">
                                <label for="street-number" class="control-label">Room</label>
                                <input type="number" id="room" class="floatLabel form-control" min="1" name="room">
                            </div>
                            <div class="col-3">
                                <label class="control-label" for="check_out">Adults</label>
                                <input type="number" id="adults" class="floatLabel form-control" min="1" name="adults">
                            </div>
                            <div class="col-3">
                                <label class="control-label" for="check_out">Children</label>
                                <input type="number" id="children" class="floatLabel form-control" min="1" name="children">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-default">Search Hotel Now</button>
                    </div>
                {{--<!--  @include('layouts_frontend.partial_frontend.search_form')-->--}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </section>

    <!-- Start Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Sorry but your session has expired</h4>
                </div>
                <div class="modal-body">
                    <p>You can return to the previous page or search additional properties.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- End Modal -->

    <section id="popular">
        <div class="container">
            <div class="row destination">
                <h1>Popular Destinations</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>
        </div>

        <div class="container">
            <!--Start dynamic popular destination content-->
            <!--$counter is to create a row for every three elements-->
                <?php $counter = 0; ?>
                <div class="row">
                @foreach($popular_cities as $popular_city)
                <!--If elements are up to 3, they will be in the same row-->
                @if($counter <3)
                    <!--Plus 1 to counter for each element rendered-->
                    <?php $counter++; ?>
                    <div class="col-md-4 img-portfolio">
                        {{--<a href="#">--}}
                            <img class="img-responsive img-hover" src="/images/upload/{{$popular_city->image}}" alt="">
                            <div class="portfolio-caption">
                                <!--<h4>HOT</h4>-->
                                <h3><strong>{{$popular_city->name}}</strong><small>, {{$popular_city->country->name}}</small></h3>
                            </div>
                        {{--</a>--}}
                    </div>
                @else
                    <!--For the fourth element, reset the counter to 0 and close the current row-->
                    </div>
                    <?php $counter = 0; ?>
                    <!--And open another row-->
                    <div class="row">
                        <!--Plus 1 to counter for each element rendered-->
                        <?php $counter++; ?>
                        <div class="#">
                            <a href="portfolio-item.html">
                                <img class="img-responsive img-hover" src="/images/upload/{{$popular_city->image}}" alt="">
                                <div class="portfolio-caption">
                                    <!--<h4>HOT</h4>-->
                                    <h3><strong>{{$popular_city->name}}</strong><small>, {{$popular_city->country->name}}</small></h3>
                                </div>
                            </a>
                        </div>
                @endif
                @endforeach

                <!--render close tag for the last row-->
                </div>

            <!--start rendering paginator-->
                <div class="row">
                    {!! $popular_cities->render() !!}
                </div>
            <!--end rendering paginator-->

            <!--End dynamic popular destination content-->
        </div>

    </section>
    <section>
        <div class="container">
            <div class="row destination">
                <h1>Recommended Hotels</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>
        </div>
        <div class="container">
            <!--Start dynamic recommended hotels content-->
            <!--$counter is to create a row for every three elements-->
            <?php $counter = 0; ?>
            <div class="row">
                @foreach($recommended_hotels as $recommended_hotel)
                    <!--If elements are up to 3, they will be in the same row-->
                    @if($counter <3)
                        <!--Plus 1 to counter for each element rendered-->
                        <?php $counter++; ?>
                        <div class="col-md-4 img-portfolio">
                            <a href="/hotel_detail/{{$recommended_hotel->id}}">
                                <img class="img-responsive img-hover" src="/images/upload/{{$recommended_hotel->logo}}" alt="">
                                <div class="portfolio-caption2">
                                    <h5><strong>{{$recommended_hotel->name}}</strong><small> > {{$recommended_hotel->city->name}}</small></h5>
                                </div>
                            </a>
                        </div>
                    @else
                    <!--For the fourth element, reset the counter to 0 and close the current row-->
                    </div>
                    <?php $counter = 0; ?>
                    <!--And open another row-->
                    <div class="row">
                        <!--Plus 1 to counter for each element rendered-->
                        <?php $counter++; ?>
                        <div class="col-md-4 img-portfolio">
                            <a href="/hotel_detail/{{$recommended_hotel->id}}">
                                <img class="img-responsive img-hover" src="/images/upload/{{$recommended_hotel->logo}}" alt="">
                                <div class="portfolio-caption2">
                                    <h5><strong>{{$recommended_hotel->name}}</strong><small> > {{$recommended_hotel->city->name}}</small></h5>
                                </div>
                            </a>
                        </div>
                @endif
                @endforeach
            <!--render close tag for the last row-->
            </div>
            <!--End dynamic recommended hotels content-->

            {{--<a href="#" class="link">more >> </a>--}}
        </div><!-- /.container -->
    </section><!-- /.section -->

    <section>
        <div class="container">
            <div class="row destination">
                <h1>Promotions for this month</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>
        </div>
        <div class="container">
            <!--Start dynamic promotion hotels content-->
            <!--$counter is to create a row for every three elements-->
            <?php $counter = 0; ?>
            <div class="row">
                @foreach($percent_promotions as $percent_promotion)
                        <!--If elements are up to 3, they will be in the same row-->
                    @if($counter <3)
                            <!--Plus 1 to counter for each element rendered-->
                        <?php $counter++; ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <img class="img-responsive" src="/images/upload/{{$percent_promotion->logo}}" alt="">
                                <div class="caption">
                                    <h5>{{$percent_promotion->name}}<samp>{{$percent_promotion->discount_percent}}%</samp><br>
                                        <small>{{$percent_promotion->city->name}}, {{$percent_promotion->country->name}}</small><br>
                                        <!--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>-->
                                        @for ($i = 1; $i <= $percent_promotion->star; $i++)
                                            <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span></small>
                                        @endfor
                                    </h5>
                                    <p>{{$percent_promotion->address}}</p>
                                    <a href="#" class="caption_link">.......</a>
                                </div>
                            </div>
                        </div>
                    @else
                    <!--For the fourth element, reset the counter to 0 and close the current row-->
                    </div>
                    <?php $counter = 0; ?>
                    <!--And open another row-->
                    <div class="row">
                        <!--Plus 1 to counter for each element rendered-->
                        <?php $counter++; ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <img class="img-responsive" src="/images/upload/{{$percent_promotion->logo}}" alt="">
                                <div class="caption">
                                    <h5>{{$percent_promotion->name}}<samp>{{$percent_promotion->discount_percent}}%</samp><br>
                                        <small>{{$percent_promotion->city->name}}, {{$percent_promotion->country->name}}</small><br>
                                        <!--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>-->
                                        @for ($i = 1; $i <= $percent_promotion->star; $i++)
                                            <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span></small>
                                        @endfor
                                    </h5>
                                    <p>{{$percent_promotion->address}}</p>
                                    <a href="#" class="caption_link">.......</a>
                                </div>
                            </div>
                        </div>
                @endif
                @endforeach
                <!--render close tag for the last row-->
            <!--</div>-->
            <!--End dynamic promotion hotels content-->

            <!--Start dynamic promotion hotels content-->
            {{--$counter is to create a row for every three elements--}}
            <?php //$counter = 0; ?>
            {{--<div class="row">--}}
                @foreach($amount_promotions as $amount_promotion)
                    <!--If elements are up to 3, they will be in the same row-->
                    @if($counter <3)
                        <!--Plus 1 to counter for each element rendered-->
                        <?php $counter++; ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <img class="img-responsive" src="/images/upload/{{$amount_promotion->logo}}" alt="">
                                <div class="caption">
                                    <h5>{{$amount_promotion->name}}<samp class="amount_promotion">{{$amount_promotion->discount_amount}}</samp><br>
                                        <small>{{$amount_promotion->city->name}}, {{$amount_promotion->country->name}}</small><br>
                                        <!--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>-->
                                        @for ($i = 1; $i <= $amount_promotion->star; $i++)
                                            <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span></small>
                                        @endfor
                                    </h5>
                                    <p>{{$amount_promotion->address}}</p>
                                    <a href="#" class="caption_link">.......</a>
                                </div>
                            </div>
                        </div>
                    @else
                    <!--For the fourth element, reset the counter to 0 and close the current row-->
                    </div>
                    <?php $counter = 0; ?>
                    <!--And open another row-->
                    <div class="row">
                        <!--Plus 1 to counter for each element rendered-->
                        <?php $counter++; ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <img class="img-responsive" src="/images/upload/{{$amount_promotion->logo}}" alt="">
                                <div class="caption">
                                    <h5>{{$amount_promotion->name}}<samp class="amount_promotion">{{$amount_promotion->discount_amount}}</samp><br>
                                        <small>{{$amount_promotion->city->name}}, {{$amount_promotion->country->name}}</small><br>
                                        <!--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>-->
                                        @for ($i = 1; $i <= $amount_promotion->star; $i++)
                                            <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span></small>
                                        @endfor
                                    </h5>
                                    <p>{{$amount_promotion->address}}</p>
                                    <a href="#" class="caption_link">.......</a>
                                </div>
                            </div>
                        </div>
                @endif
                @endforeach
                <!--render close tag for the last row-->
            </div>
            <!--End dynamic promotion hotels content-->

        </div><!-- /.container -->
    </section><!-- /.section -->

@stop

@section('page_script')
    @if(!empty(Session::get('session_expired')) && Session::get('session_expired') == true)
        <script>
            $(function() {
                $('#myModal').modal('show');
            });
        </script>
    @endif

    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
//            $('#myModal').modal('show');

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

            /*var nowDate = new Date();
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
            });  */

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
        });
    </script>
@stop