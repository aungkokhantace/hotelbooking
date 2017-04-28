@extends('layouts_frontend.master_frontend')
@section('title','Login')
@section('content')
    <div id="header_id">
        <img class="img-responsive img-hover" src="shared/images/slider1.png">
    </div>
    </div>
    </section>

    <section id="aboutus">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4 create_form">
                    <div class="imgcontainer">
                        <img src="shared/images/Edit.png">
                    </div>
                    <h2>Login</h2>
                    @if ($errors->has())
                        <p class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </p>
                    @endif
                    {!! Form::open(array('url' => '/login', 'class'=> 'form-horizontal', 'id'=>'login')) !!}
                        <div class="formgroup">
                            <div class="col-sm-12 pd_lf_5">
                                <input type="email" class="formcontrols" id="email" placeholder="Email" name="email">
                            </div>
                        </div>
                        <div class="formgroup">
                            <div class="col-sm-12 pd_lf_5">
                                <input type="password" class="formcontrols" id="password" placeholder="Password" name="password">
                            </div>
                        </div>
                        <div class="col-sm-12 pd_lf_5">
                            <button type="submit" class="btn btn-default formcontrols">Login</button>
                        </div>
                        <div class="col-sm-12 pd_lf_5 form_text">
                            <input type="checkbox" checked="checked"> Remember me
                            <span class="psw"><a href="#">Forgot password?</a></span>
                        </div>
                        <div class="formgroup text-center">
                            <div class="col-md-12 control">
                                <div class="form_textone">
                                    <a href="createacc.html" style="text-decoration:underline;"> Not a member? Create Account </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.section -->



@stop
@section('page_script')

    <script>
        $(document).ready(function() {

        });
    </script>


    <!-- Script to Activate the Carousel -->
    <script>
        $('.carousel').carousel({
            interval: 5000 //changes the speed
        })
    </script>
@stop