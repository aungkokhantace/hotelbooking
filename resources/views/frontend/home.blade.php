@extends('layouts_frontend.master_frontend')
@section('title','Home Page')
@section('content')

    <div id="header_id">
        <!-- Header Carousel -->
        <header id="myCarousel" class="carousel slide">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="fill"><img src="shared/images/slider.png"></div>
                    <div class="carousel-caption">
                        <h1 class="container">Where your journey begins.</h1>
                        <p class="container">Discover your next great adventure, become an explorer to get started!</p>
                    </div>
                </div>
                <div class="item">
                    <div class="fill"><img src="shared/images/slider.png"></div>
                    <div class="carousel-caption">
                        <h1 class="container">Where your journey begins.</h1>
                        <p class="container">Discover your next great adventure, become an explorer to get started!</p>
                    </div>
                </div>
                <div class="item">
                    <div class="fill"><img src="shared/images/slider.png">
                    </div>
                    <div class="carousel-caption">
                        <h1 class="container">Where your journey begins.</h1>
                        <p class="container">Discover your next great adventure, become an explorer to get started!</p>
                    </div>
                </div>
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
                            <input class="form-control font_sz_11" type="text" value="" id="destination">
                            <div class="input-group-addon">
                                <i class="fa fa-plane" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label" for="check_in">Check In</label>
                        <div class="col-10 input-group date" data-provide="datepicker">
                            <input type="text" class="form-control">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label" for="check_out">Check Out</label>
                        <div class="col-10 input-group date" data-provide="datepicker">
                            <input type="text" class="form-control">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-10">
                            <div class="col-3">
                                <label for="street-number" class="control-label">Room</label>
                                <input type="number" id="street-number" class="floatLabel form-control" name="street-number">
                            </div>
                            <div class="col-3">
                                <label class="control-label" for="check_out">Adults</label>
                                <input type="number" id="street-number" class="floatLabel form-control" name="street-number">
                            </div>
                            <div class="col-3">
                                <label class="control-label" for="check_out">Children</label>
                                <input type="number" id="street-number" class="floatLabel form-control" name="street-number">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-default">Search Hotel Now</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </section>

    <section id="popular">
        <div class="container">
            <div class="row destination">
                <h1>Popular Destinations</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>
        </div>

        <div class="container">
            {{--Start dynamic popular destination content--}}
                {{--$counter is to create a row for every three elements--}}
                <?php $counter = 0; ?>
                <div class="row">
                @foreach($popular_cities as $popular_city)
                {{--If elements are up to 3, they will be in the same row--}}
                @if($counter <3)
                    {{--Plus 1 to counter for each element rendered--}}
                    <?php $counter++; ?>
                    <div class="col-md-4 img-portfolio">
                        <a href="portfolio-item.html">
                            <img class="img-responsive img-hover" src="/images/upload/{{$popular_city->image}}" alt="">
                            <div class="portfolio-caption">
                                {{--<h4>HOT</h4>--}}
                                <h3><strong>{{$popular_city->name}}</strong><small>, {{$popular_city->country->name}}</small></h3>
                            </div>
                        </a>
                    </div>
                @else
                    {{--For the fourth element, reset the counter to 0 and close the current row--}}
                    </div>
                    <?php $counter = 0; ?>
                    {{--And open another row--}}
                    <div class="row">
                        {{--Plus 1 to counter for each element rendered--}}
                        <?php $counter++; ?>
                        <div class="col-md-4 img-portfolio">
                            <a href="portfolio-item.html">
                                <img class="img-responsive img-hover" src="/images/upload/{{$popular_city->image}}" alt="">
                                <div class="portfolio-caption">
                                    {{--<h4>HOT</h4>--}}
                                    <h3><strong>{{$popular_city->name}}</strong><small>, {{$popular_city->country->name}}</small></h3>
                                </div>
                            </a>
                        </div>
                @endif
                @endforeach

                {{--render close tag for the last row--}}
                </div>

            {{--start rendering paginator--}}
                <div class="row">
                    {!! $popular_cities->render() !!}
                </div>
            {{--end rendering paginator--}}

            {{--End dynamic popular destination content--}}
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
            {{--Start dynamic recommended hotels content--}}
            {{--$counter is to create a row for every three elements--}}
            <?php $counter = 0; ?>
            <div class="row">
                @foreach($recommended_hotels as $recommended_hotel)
                    {{--If elements are up to 3, they will be in the same row--}}
                    @if($counter <3)
                        {{--Plus 1 to counter for each element rendered--}}
                        <?php $counter++; ?>
                        <div class="col-md-4 img-portfolio">
                            <a href="portfolio-item.html">
                                <img class="img-responsive img-hover" src="/images/upload/{{$recommended_hotel->logo}}" alt="">
                                <div class="portfolio-caption2">
                                    <h5><strong>{{$recommended_hotel->name}}</strong><small> > {{$recommended_hotel->city->name}}</small></h5>
                                </div>
                            </a>
                        </div>
                    @else
                        {{--For the fourth element, reset the counter to 0 and close the current row--}}
                    </div>
                    <?php $counter = 0; ?>
                    {{--And open another row--}}
                    <div class="row">
                        {{--Plus 1 to counter for each element rendered--}}
                        <?php $counter++; ?>
                        <div class="col-md-4 img-portfolio">
                            <a href="portfolio-item.html">
                                <img class="img-responsive img-hover" src="/images/upload/{{$recommended_hotel->logo}}" alt="">
                                <div class="portfolio-caption2">
                                    <h5><strong>{{$recommended_hotel->name}}</strong><small> > {{$recommended_hotel->city->name}}</small></h5>
                                </div>
                            </a>
                        </div>
                @endif
                @endforeach
                {{--render close tag for the last row--}}
            </div>
            {{--End dynamic recommended hotels content--}}

            <a href="#" class="link">more >> </a>
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
            {{--Start dynamic promotion hotels content--}}
            {{--$counter is to create a row for every three elements--}}
            <?php $counter = 0; ?>
            <div class="row">
                @foreach($percent_promotions as $percent_promotion)
                    {{--If elements are up to 3, they will be in the same row--}}
                    @if($counter <3)
                        {{--Plus 1 to counter for each element rendered--}}
                        <?php $counter++; ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <img class="img-responsive" src="/images/upload/{{$percent_promotion->logo}}" alt="">
                                <div class="caption">
                                    <h5>{{$percent_promotion->name}}<samp>{{$percent_promotion->discount_percent}}%</samp><br>
                                        <small>{{$percent_promotion->city->name}}, {{$percent_promotion->country->name}}</small><br>
                                        {{--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>--}}
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
                    {{--For the fourth element, reset the counter to 0 and close the current row--}}
                    </div>
                    <?php $counter = 0; ?>
                    {{--And open another row--}}
                    <div class="row">
                        {{--Plus 1 to counter for each element rendered--}}
                        <?php $counter++; ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <img class="img-responsive" src="/images/upload/{{$percent_promotion->logo}}" alt="">
                                <div class="caption">
                                    <h5>{{$percent_promotion->name}}<samp>{{$percent_promotion->discount_percent}}%</samp><br>
                                        <small>{{$percent_promotion->city->name}}, {{$percent_promotion->country->name}}</small><br>
                                        {{--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>--}}
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
                {{--render close tag for the last row--}}
            {{--</div>--}}
            {{--End dynamic promotion hotels content--}}

            {{--Start dynamic promotion hotels content--}}
            {{--$counter is to create a row for every three elements--}}
            <?php //$counter = 0; ?>
            {{--<div class="row">--}}
                @foreach($amount_promotions as $amount_promotion)
                    {{--If elements are up to 3, they will be in the same row--}}
                    @if($counter <3)
                        {{--Plus 1 to counter for each element rendered--}}
                        <?php $counter++; ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <img class="img-responsive" src="/images/upload/{{$amount_promotion->logo}}" alt="">
                                <div class="caption">
                                    <h5>{{$amount_promotion->name}}<samp class="amount_promotion">{{$amount_promotion->discount_amount}}</samp><br>
                                        <small>{{$amount_promotion->city->name}}, {{$amount_promotion->country->name}}</small><br>
                                        {{--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>--}}
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
                        {{--For the fourth element, reset the counter to 0 and close the current row--}}
                    </div>
                    <?php $counter = 0; ?>
                    {{--And open another row--}}
                    <div class="row">
                        {{--Plus 1 to counter for each element rendered--}}
                        <?php $counter++; ?>
                        <div class="col-sm-4">
                            <div class="thumbnail">
                                <img class="img-responsive" src="/images/upload/{{$amount_promotion->logo}}" alt="">
                                <div class="caption">
                                    <h5>{{$amount_promotion->name}}<samp class="amount_promotion">{{$amount_promotion->discount_amount}}</samp><br>
                                        <small>{{$amount_promotion->city->name}}, {{$amount_promotion->country->name}}</small><br>
                                        {{--<small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>--}}
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
                {{--render close tag for the last row--}}
            </div>
            {{--End dynamic promotion hotels content--}}

        </div><!-- /.container -->
    </section><!-- /.section -->

@stop

@section('page_script')
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
        });
    </script>
@stop