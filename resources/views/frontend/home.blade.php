@extends('layouts_frontend.master_frontend')
@section('title','Home Page')
@section('content')

    <div id="header_id">
        <!-- Header Carousel -->
        <header id="myCarousel" class="carousel slide">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @if(isset($sliders) && count($sliders) > 0)
                  @foreach($sliders as $slider)
                      @if(isset($first_slider) && $first_slider == 1)
                          <div class="item active">
                              <div class="fill"><img src="/assets/shared/images/{{ $slider->image_url }}"></div>
                              <div class="carousel-caption">
                                  <h1 class="container">{{ $slider->title }}</h1>
                                  <p class="container">{{ $slider->description }}</p>
                              </div>
                          </div>
                          <div class="item">
                              <div class="fill"><img src="/assets/shared/images/{{ $slider->image_url }}"></div>
                              <div class="carousel-caption">
                                  <h1 class="container">{{ $slider->title }}</h1>
                                  <p class="container">{{ $slider->description }}</p>
                              </div>
                          </div>
                          <?php
                            $first_slider = 0; //clear first_slider flag
                            ?>
                       @else
                       <div class="item">
                           <div class="fill"><img src="/assets/shared/images/{{ $slider->image_url }}"></div>
                           <div class="carousel-caption">
                               <h1 class="container">{{ $slider->title }}</h1>
                               <p class="container">{{ $slider->description }}</p>
                           </div>
                       </div>
                     @endif
                  @endforeach
                @else
                <div class="item active">
                    <div class="fill"><img src="/assets/shared/images/slider.png"></div>
                    <div class="carousel-caption">
                        <h1 class="container">{{trans('frontend_home.your_journey_begin')}}</h1>
                        <p class="container">{{trans('frontend_home.discovery_jounery')}}</p>
                    </div>
                </div>
                <div class="item">
                    <div class="fill"><img src="/assets/shared/images/slider.png"></div>
                    <div class="carousel-caption">
                        <h1 class="container">{{trans('frontend_home.your_journey_begin')}}</h1>
                        <p class="container">{{trans('frontend_home.discovery_jounery')}}</p>
                    </div>
                </div>
                <div class="item">
                    <div class="fill"><img src="/assets/shared/images/slider.png">
                    </div>
                    <div class="carousel-caption">
                        <h1 class="container">{{trans('frontend_home.your_journey_begin')}}</h1>
                        <p class="container">{{trans('frontend_home.discovery_jounery')}}</p>
                    </div>
                </div>
                @endif
            </div>
        </header>
    </div>

    <!-- start floating icons on slider -->
    <div class="btn-gp btn-gp2 clearfix">
        @if(!empty(Session::get('locale')) && Session::get('locale') == 'jp')
        <a href="/transportation_information" class="clearfix"><img src="/images/floating_slider_icons/transportation_icn.png" class="img-icn"><img src="/images/floating_slider_icons/transportation_txt_jp.png" class="img-txt"></a>
        <a href="/tour_information" class="clearfix"><img src="/images/floating_slider_icons/tour_icn.png" class="img-icn"><img src="/images/floating_slider_icons/tour_txt_jp.png" class="img-txt"></a>
        <a href="/guide_information" class="clearfix"><img src="/images/floating_slider_icons/guide_icn.png" class="img-icn"><img src="/images/floating_slider_icons/guide_txt_jp.png" class="img-txt"></a>
        @else
        <a href="/transportation_information" class="clearfix"><img src="/images/floating_slider_icons/transportation_icn.png" class="img-icn"><img src="/images/floating_slider_icons/transportation_txt.png" class="img-txt"></a>
        <a href="/tour_information" class="clearfix"><img src="/images/floating_slider_icons/tour_icn.png" class="img-icn"><img src="/images/floating_slider_icons/tour_txt.png" class="img-txt"></a>
        <a href="/guide_information" class="clearfix"><img src="/images/floating_slider_icons/guide_icn.png" class="img-icn"><img src="/images/floating_slider_icons/guide_txt.png" class="img-txt"></a>
        @endif
    </div>
    <!-- end floating icons on slider -->

    <div id="form_id">
        <div class="container">
            <div class="col-md-4 form">
                <h2>{{trans('frontend_search.search_hotel')}}</h2>

                {!! Form::open(array('url' => '/search','files'=>true, 'id'=>'search', 'class'=> 'form-horizontal user-form-border')) !!}
                    <div class="form-group row">
                        <label class="control-label" for="destination">{{trans('frontend_search.destinatin_property')}}</label>
                        <div class="col-10 input-group">
                            <input class="form-control font_sz_11" type="text" value="" id="destination" name="destination" autocomplete="off" placeholder="{{trans('frontend_search.destination-placeholder')}}">
                            <div class="input-group-addon">
                                <i class="fa fa-plane" aria-hidden="true"></i>
                            </div>
                            <p class="text-danger">{{$errors->first('destination')}}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label" for="check_in">{{trans('frontend_search.check_in')}}</label>
                        <div class="col-10 input-group date" data-provide="datepicker" id="check_in">
                            <input type="text" class="form-control" name="check_in" autocomplete="off" placeholder="{{trans('frontend_search.check-in-placeholder')}}">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                            <p class="text-danger">{{$errors->first('check_in')}}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label" for="check_out">{{trans('frontend_search.check_out')}}</label>
                        <div class="col-10 input-group date" data-provide="datepicker" id="check_out">
                            <input type="text" class="form-control" name="check_out" autocomplete="off" placeholder="{{trans('frontend_search.check-out-placeholder')}}">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                            <p class="text-danger">{{$errors->first('check_out')}}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-10">
                            <div class="col-3">
                                <label for="street-number" class="control-label">{{trans('frontend_search.room')}}</label>
                                {{--  <input type="number" id="room" class="floatLabel form-control remove_arrow" min="1" name="room">  --}}
                                <select class="form-control" name="room" id="room">
                                    @for($i = 0; $i <= 10; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-3">
                                <label class="control-label" for="check_out">{{trans('frontend_search.adults')}}</label>
                                {{--  <input type="number" id="adults" class="floatLabel form-control remove_arrow" min="1" name="adults">  --}}
                                <select class="form-control" name="adults" id="adults">
                                    @for($i = 0; $i <= 10; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-3">
                                <label class="control-label" for="check_out">{{trans('frontend_search.children')}}</label>
                                {{--  <input type="number" id="children" class="floatLabel form-control remove_arrow" min="1" name="children">  --}}
                                <select class="form-control" name="children" id="children">
                                    @for($i = 0; $i <= 10; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Start modal for children age -->
                              <div class="modal fade" id="childrenAgeModal" tabindex="-1" role="dialog" aria-labelledby="childrenAgeModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel">Please specify children ages (In years)!</h3>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row" id="children-age-select-box-row">
                                        <!-- @for($i = 0; $i < 10; $i++)
                                        <div class="col-md-2 children-age-select-box">
                                          <select class="form-control" name="children_ages[]" id="children_ages">
                                              @for($ii = 0; $ii < 17; $ii++)
                                                  <option value="{{$ii}}">{{$ii}}</option>
                                              @endfor
                                          </select>
                                        </div>
                                        <div class="col-md-1"></div>
                                        @endfor -->
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <!-- End modal for children age -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-default">{{trans('frontend_search.search_hotel_now')}}</button>
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
                <h1>{{trans('frontend_home.popular_destination')}}</h1>
                <p>{!! $popular_destination_text !!}</p>
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
                    <form id="frm_search_{{$popular_city->id}}" method="post" action="/search" class="form-horizontal user-form-border">
                      <div class="col-md-4 img-portfolio" onclick="submit_search('{{$popular_city->id}}');">
                              {{ csrf_field() }}
                              <input type="hidden" name="destination_name" value="{{$popular_city->name}}">
                              <img class="img-responsive img-hover adjust-img-height" src="/images/upload/{{$popular_city->image}}" alt="">
                              <div class="portfolio-caption">
                                  <h3><strong>{{$popular_city->name}}</strong><small>, {{$popular_city->country->name}}</small></h3>
                              </div>
                      </div>
                    </form>
                @else
                    <!--For the fourth element, reset the counter to 0 and close the current row-->
                    </div>
                    <?php $counter = 0; ?>
                    <!--And open another row-->
                    <div class="row">
                        <!--Plus 1 to counter for each element rendered-->
                        <?php $counter++; ?>
                        <form id="frm_search_{{$popular_city->id}}" method="post" action="/search" class="form-horizontal user-form-border">
                            <div class="col-md-4 img-portfolio" onclick="submit_search('{{$popular_city->id}}');">
                                {{ csrf_field() }}
                                <input type="hidden" name="destination_name" value="{{$popular_city->name}}">
                                <img class="img-responsive img-hover adjust-img-height" src="/images/upload/{{$popular_city->image}}" alt="">
                                <div class="portfolio-caption">
                                    <h3><strong>{{$popular_city->name}}</strong><small>, {{$popular_city->country->name}}</small></h3>
                                </div>
                            </div>
                        </form>

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
                <h1>{{trans('frontend_home.recommended_hotels')}}</h1>
                <p>{!! $recommended_hotel_text !!}</p>
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
                                <img class="img-responsive img-hover adjust-img-height" src="/images/upload/{{$recommended_hotel->logo}}" alt="">
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
                                <img class="img-responsive img-hover adjust-img-height" src="/images/upload/{{$recommended_hotel->logo}}" alt="">
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
                <h1>{{trans('frontend_home.promotions_for_month')}}</h1>
                <p>{!! $promotion_text !!}</p>
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
                                <a href="/hotel_detail/{{$percent_promotion->id}}">
                                  <img class="img-responsive adjust-img-height" src="/images/upload/{{$percent_promotion->logo}}" alt="">
                                </a>
                                <div class="caption">
                                    <!-- <h5>{{$percent_promotion->name}}<samp>{{$percent_promotion->discount_percent}}% off</samp><br> -->
                                    <h5>{{$percent_promotion->name}}<samp>{{$percent_promotion->discount_percent_text}}</samp><br>
                                        <small>{{$percent_promotion->city->name}}, {{$percent_promotion->country->name}}</small><br>
                                        <!--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>-->
                                        @for ($i = 1; $i <= $percent_promotion->star; $i++)
                                            <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span></small>
                                        @endfor
                                    </h5>
                                    <div class="row">
                                    <a href="/hotel_detail/{{$percent_promotion->id}}" class="caption_link"><button class="btn btn-primary">{{trans('frontend_search.book_now')}} >></button></a>
                                    </div>
                                    <p>{{$percent_promotion->address}}</p>
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
                                <a href="/hotel_detail/{{$percent_promotion->id}}">
                                  <img class="img-responsive adjust-img-height" src="/images/upload/{{$percent_promotion->logo}}" alt="">
                                </a>
                                <div class="caption">
                                    <!-- <h5>{{$percent_promotion->name}}<samp>{{$percent_promotion->discount_percent}} % off</samp><br> -->
                                    <h5>{{$percent_promotion->name}}<samp>{{$percent_promotion->discount_percent_text}}</samp><br>
                                        <small>{{$percent_promotion->city->name}}, {{$percent_promotion->country->name}}</small><br>
                                        <!--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>-->
                                        @for ($i = 1; $i <= $percent_promotion->star; $i++)
                                            <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span></small>
                                        @endfor
                                    </h5>
                                    <div class="row">
                                      <a href="/hotel_detail/{{$percent_promotion->id}}" class="caption_link"><button class="btn btn-primary">{{trans('frontend_search.book_now')}} >></button></a>
                                    </div>
                                    <p>{{$percent_promotion->address}}</p>
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
                                <a href="/hotel_detail/{{$amount_promotion->id}}">
                                  <img class="img-responsive adjust-img-height" src="/images/upload/{{$amount_promotion->logo}}" alt="">
                                </a>
                                <div class="caption">
                                    <!-- <h5>{{$amount_promotion->name}}<samp class="amount_promotion">{{$amount_promotion->discount_amount}}</samp><br> -->
                                    <h5>{{$amount_promotion->name}}<samp class="amount_promotion">{{$amount_promotion->discount_amount_text}}</samp><br>
                                        <small>{{$amount_promotion->city->name}}, {{$amount_promotion->country->name}}</small><br>
                                        <!--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>-->
                                        @for ($i = 1; $i <= $amount_promotion->star; $i++)
                                            <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span></small>
                                        @endfor
                                    </h5>
                                    <div class="row">
                                      <a href="/hotel_detail/{{$amount_promotion->id}}" class="caption_link"><button class="btn btn-primary">{{trans('frontend_search.book_now')}} >></button></a>
                                    </div>
                                    <p>{{$amount_promotion->address}}</p>
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
                                <a href="/hotel_detail/{{$amount_promotion->id}}">
                                  <img class="img-responsive adjust-img-height" src="/images/upload/{{$amount_promotion->logo}}" alt="">
                                </a>
                                <div class="caption">
                                    <!-- <h5>{{$amount_promotion->name}}<samp class="amount_promotion">{{$amount_promotion->discount_amount}}</samp><br> -->
                                      <h5>{{$amount_promotion->name}}<samp class="amount_promotion">{{$amount_promotion->discount_amount_text}}</samp><br>
                                        <small>{{$amount_promotion->city->name}}, {{$amount_promotion->country->name}}</small><br>
                                        <!--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>-->
                                        @for ($i = 1; $i <= $amount_promotion->star; $i++)
                                            <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span></small>
                                        @endfor
                                    </h5>
                                    <div class="row">
                                      <a href="/hotel_detail/{{$amount_promotion->id}}" class="caption_link"><button class="btn btn-primary">{{trans('frontend_search.book_now')}} >></button></a>
                                    </div>
                                    <p>{{$amount_promotion->address}}</p>
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

            $("#children").on("change", function () {
                // console.log($('#children').val());
                $('.modal-body #children-age-select-box-row').html('');
                var count = $('#children').val();

                for (i = 1; i <= count; i++) {
                  $(".modal-body #children-age-select-box-row").append('<div class="col-md-2 children-age-select-box-div"><select class="form-control children-age-select-box" id="children-age-select-box_'+ i +'" name="children_ages[]" id="children_ages"></select></div>');
                  $("#children-age-select-box_"+i).append('<option selected value="<1"> <1 </option>')
                  for(ii = 1; ii <= 17; ii++){
                    $("#children-age-select-box_"+i).append('<option value="'+ ii +'">'+ ii +'</option>')
                  }
                  // $(".modal-body #children-age-select-box-row").append('</select></div>')
                  // $(".modal-body #children-age-select-box-row").append('<div class="col-md-1"></div>')
                }

                //append
                // $('.modal-body #children-age-select-box-row').html(html_var);

                $modal = $('#childrenAgeModal');
                $modal.modal('show');
            });

        });

    </script>
@stop
