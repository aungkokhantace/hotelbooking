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
                <form>
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

                </form>
            </div>
        </div>
    </div>
    </section>

    <section id="popular">
        <div class="container">
            <div class="row destination">
                <h1>Popular Destination</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-1.jpg" alt="">
                        <div class="portfolio-caption">
                            <h4>HOT</h4>
                            <h3><strong>Yangon</strong><small>,Myanmar</small></h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-2.jpg" alt="">
                        <div class="portfolio-caption">
                            <!-- <h4>HOT</h4> -->
                            <h3><strong>Yangon</strong><small>,Myanmar</small></h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-3.jpg" alt="">
                        <div class="portfolio-caption">
                            <!-- <h4>HOT</h4> -->
                            <h3><strong>Yangon</strong><small>,Myanmar</small></h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-4.jpg" alt="">
                        <div class="portfolio-caption">
                            <!-- <h4>HOT</h4> -->
                            <h3><strong>Yangon</strong><small>,Myanmar</small></h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-5.jpg" alt="">
                        <div class="portfolio-caption">
                            <!-- <h4>HOT</h4> -->
                            <h3><strong>Yangon</strong><small>,Myanmar</small></h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-6.jpg" alt="">
                        <div class="portfolio-caption">
                            <h4>HOT</h4>
                            <h3><strong>Yangon</strong><small>,Myanmar</small></h3>
                        </div>
                    </a>
                </div>
            </div>
            <div class="pagination">
                <a href="#">1</a>
                <a class="active" href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row destination">
                <h1>Remonmended Hotels</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-7.jpg" alt="">
                        <div class="portfolio-caption2">
                            <h5><strong>NayPyiTaw Hotel</strong><small> > NayPyiTaw</small></h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-8.jpg" alt="">
                        <div class="portfolio-caption2">
                            <h5><strong>NayPyiTaw Hotel</strong><small> > NayPyiTaw</small></h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-9.jpg" alt="">
                        <div class="portfolio-caption2">
                            <h5><strong>NayPyiTaw Hotel</strong><small> > NayPyiTaw</small></h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-10.jpg" alt="">
                        <div class="portfolio-caption2">
                            <h5><strong>NayPyiTaw Hotel</strong><small> > NayPyiTaw</small></h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 img-portfolio">
                    <a href="portfolio-item.html">
                        <img class="img-responsive img-hover" src="shared/images/Img-11.jpg" alt="">
                        <div class="portfolio-caption2">
                            <h5><strong>NayPyiTaw Hotel</strong><small> > NayPyiTaw</small></h5>
                        </div>
                    </a>
                </div>
            </div><!-- /.row -->
            <a href="#" class="link">more >> </a>
        </div><!-- /.container -->
    </section><!-- /.section -->

    <section>
        <div class="container">
            <div class="row destination">
                <h1>Promotion for this month</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>
        </div>
        <div class="container">
            <!-- Projects Row -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="thumbnail">
                        <img class="img-responsive" src="shared/images/Img-12.jpg" alt="">
                        <div class="caption">
                            <h5>Paradise Bay Resort<samp>25%</samp><br>
                                <small>Yangon, Myanmar</small><br>
                                <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>
                            </h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste saepe et quisquam nesciunt maxime.</p>
                            <a href="#" class="caption_link">.......</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="thumbnail">
                        <img class="img-responsive" src="shared/images/Img-13.jpg" alt="">
                        <div class="caption">
                            <h5>Paradise Bay Resort<samp>15%</samp><br>
                                <small>Yangon, Myanmar</small><br>
                                <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span><i class="fa fa-wifi" aria-hidden="true"></i><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>
                            </h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste saepe et quisquam nesciunt maxime.</p>
                            <a href="#" class="caption_link">.......</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="thumbnail">
                        <img class="img-responsive" src="shared/images/Img-14.jpg" alt="">
                        <div class="caption">
                            <h5>Paradise Bay Resort<samp>10%</samp><br>
                                <small>Yangon, Myanmar</small><br>
                                <small><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <span class="glyphicon glyphicon-star" aria-hidden="true"><i class="fa fa-wifi" aria-hidden="true"></i></span><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></small>
                            </h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste saepe et quisquam nesciunt maxime.</p>
                            <a href="#" class="caption_link">.......</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.section -->

@stop

@section('page_script')
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
        });
    </script>
@stop