<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="col-md-offset-2 modal-content modal-content-width">
            <div class="modal-body">
                <div class="container">
                    <div class="row">

                        <div class="col-sm-6 col-md-4 create_form">
                            <button type="button" class="close" data-dismiss="modal">&bigotimes;</button>
                            <div class="imgcontainer">
                                <img src="/assets/shared/images/Edit.png">
                            </div>
                            <h2>Create Account</h2>

                            {!! Form::open(array('url' => '/register', 'class'=> 'form-horizontal', 'id'=>'registration')) !!}

                            <div class="formgroup">
                                <div class="col-sm-6 pd_rg_10">
                                    <input type="text" class="formcontrols" id="first_name" placeholder="First Name" name="first_name">
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
                                <button type="button" class="btn btn-default formcontrols register-btn">CREATE ACCOUNT</button>
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
            </div>
        </div>
    </div>
</div>

<!-- start form validation -->
<script>
    $(document).ready(function() {

    });
</script>
<!-- end form validation -->

<!-- start login ajax-->
<script>
    $(document).ready(function(){
        $('.register-btn').click(function(){
            $('#registration').submit();
        });
            $('#registration').validate({
                rules: {
                    first_name          : 'required',
                    last_name           : 'required',
                    email   	        : {
                        required 	: true,
                        email	 	: true,
                        remote: {
                            url: "{{route('register/check_email')}}",
                            type: "get",
                            data:
                            {
                                email: function()
                                {
                                    return $('#email').val();
                                }
                            }
                        }
                    },
                    password            : {
                        required  : true,
                        minlength : 6
                    },
                    confirm_password    : {
                        required  : true,
                        minlength : 6,
                        equalTo   : "#password"
                    }
                },
                messages: {
                    first_name          : 'Require!',
                    last_name           : 'Require!',
                    email     	        : {
                        required 	: 'Require!',
                        email 	 	: 'Email is invalid format',
                        remote		: jQuery.validator.format("{0} is already taken.")
                    },
                    password            : {
                        required  : 'Require!',
                        minlength : 'Password must be at least 6 characters'
                    },
                    confirm_password    : {
                        required  : 'Please retype your password!',
                        minlength : 'Retyped Password must be at least 6 characters',
                        equalTo   : "Password and Retyped Password must match"
                    }
                },
                submitHandler: function(form) {
                    $('button[type="submit"]').attr('disabled','disabled');
                    //form.submit();
                    var serializedData = $('#registration').serialize();
                    $.ajax({
                        url: 'register',
                        type: 'POST',
                        data: serializedData,
                        success: function(data){
                            if(data == 'Status 200'){
                                location.reload(true);
                                console.log('success');
                            }
                            else{
                                console.log('fail');
                                return;
                            }

                        },
                        error: function(data){
                            console.log('error');
                            return;
                        },
                        complete: function (data) {
                            console.log('complete');
                            return;

                        }
                    });

                }
            });
        //});
    });
</script>
<!-- end login ajax-->


