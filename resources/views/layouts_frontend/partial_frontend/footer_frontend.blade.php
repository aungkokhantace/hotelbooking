<hr>
<section id="section_four">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="title">
                    <h5>Term & Conditions</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elitconsectetur adipisicing elit........</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="title">
                    <h5>Accepted Cards</h5>
                    <img src="/assets/shared/images/visa.jpg">
                </div>
            </div>
            <div class="col-md-4">
                <div class="title">
                    <h5>Follow us</h5>
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
                <p>All right reserved</p>
            </div>
        </div>
    </div>
</footer>


{{-- <script>
    $(document).ready(function() {

    });
</script> --}}

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