@extends('layouts_frontend.master_frontend')
@section('title','Registration')
@section('content')
            <div id="header_id">
                <img class="img-responsive img-hover" src="shared/images/slider1.png">
            </div>
        </div>
    </section>

    <section>
        <div class="container" id="aboutus">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4 create_form">
                    <div class="imgcontainer">
                        <img src="shared/images/Edit.png">
                    </div>
                    <h2>Create Account</h2>

                    {!! Form::open(array('url' => '/store', 'class'=> 'form-horizontal', 'id'=>'customer')) !!}

                        <div class="formgroup">
                            <div class="col-sm-6 pd_rg_10">
                                <input type="text" class="formcontrols" id="first_name" placeholder="First Name"
                                       name="first_name"
                                       data-validation-required-message=
                                       "You must agree to the terms and conditions>
                            </div>
                            <div class="col-sm-6 pd_lf_5">
                                <input type="text" class="formcontrols" id="last_name" placeholder="Last Name" name="last_name">
                            </div>
                        </div>
                        <div class="formgroup">
                            <div class="col-sm-12 pd_lf_5">
                                <input type="email" class="formcontrols" id="email" placeholder="Email Address" name="email">
                            </div>
                        </div>
                        <div class="formgroup">
                            <div class="col-sm-12 pd_lf_5">
                                <input type="password" class="formcontrols" id="password" placeholder="Password" name="password">
                            </div>
                        </div>
                        <div class="formgroup">
                            <div class="col-sm-12 pd_lf_5">
                                <input type="password" class="formcontrols" id="confirm_password" placeholder="Retype Password" name="confirm_password">
                            </div>
                        </div>
                        <div class="col-sm-12 pd_lf_5">
                            <button type="submit" class="btn btn-default formcontrols">CREAT ACCOUNT</button>
                        </div>
                        <div class="formgroup">
                            <div class="col-md-12 control">
                                <div class="form_text">
                                    <span>By creating an account, you agree to our</span>
                                    <a href="#"> Terms </a>
                                </div>
                            </div>
                        </div>
                        <div class="formgroup text-center">
                            <div class="col-md-12 control">
                                <div class="form_textone">
                                    <span>Already a member?</span>
                                    <a href="login.html"> Login Here </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>

@stop
@section('page_script')

    <script>
        $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
    </script>

    <script>
        $(document).ready(function() {
            $('#datePicker')
                    .datepicker({
                        autoclose: true,
                        format: 'mm/dd/yyyy'
                    })
                    .on('changeDate', function(e) {
                        // Revalidate the date field
                        $('#eventForm').formValidation('revalidateField', 'date');
                    });
        });
    </script>


    <!-- Script to Activate the Carousel -->
    <script>
        $('.carousel').carousel({
            interval: 5000 //changes the speed
        })
    </script>
@stop