<?php
$terms_and_condition_text    = \App\Core\Utility::getTermsAndCondition();

?>
<hr>
<section id="section_four">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="title">
                    <h5>{{trans('frontend_header.term_condition')}}</h5>
                    <p>{!! $terms_and_condition_text !!}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="title">
                    <h5>{{trans('frontend_header.accepted_carts')}}</h5>
                    <img src="/assets/shared/images/Visa.jpg">
                    <!-- <img src="/assets/shared/images/cards.jpg"> -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="title">
                    <h5>{{trans('frontend_header.follow_us')}}</h5>
                    <ul class="list-inline">
                        <li>
                            <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-square-o fa-stack-2x"></i>
                                        <i class="fa fa-youtube fa-stack-1x"></i>
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-square-o fa-stack-2x"></i>
                                        <i class="fa fa-twitter fa-stack-1x"></i>
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-square-o fa-stack-2x"></i>
                                        <i class="fa fa-instagram fa-stack-1x"></i>
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-square-o fa-stack-2x"></i>
                                        <i class="fa fa-facebook fa-stack-1x"></i>
                                    </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.section -->
<hr>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>{{trans('frontend_details.all_right_reserved')}}</p>
            </div>
        </div>
    </div>
</footer>
<a href="#" class="scrollToTop btn btn-icon btn-circle "><i class="fa fa-angle-double-up"></i></a>

<script>
    $(document).ready(function() {


      //for scroll to top
            $(window).scroll(function(){
              if($(this).scrollTop() > 100){
                 $('.scrollToTop').fadeIn();
              } else {
            $('.scrollToTop').fadeOut();
             }
           });

          //Click event to scroll to top
         $('.scrollToTop').click(function(){
         $('html, body').animate({scrollTop : 0},800);
        return false;
    });

    });
</script>

<!-- Script to Activate the Carousel -->
<script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
</script>

<!-- Sweet Alert -->
<script src="/assets/js/sweetalert-dev.js"></script>

</body>

</html>
