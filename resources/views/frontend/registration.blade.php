<!-- Modal -->
  <div class="modal fade" id="registerModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body create_form">
          <button type="button" class="close" data-dismiss="modal">&bigotimes;</button>
            <div class="imgcontainer">
                <img src="/assets/shared/images/Edit.png">
            </div>
            <h2>{{trans('frontend_header.create_account')}}</h2>
                {!! Form::open(array('url' => '/register', 'class'=> 'form-horizontal', 'id'=>'registration')) !!}

                <div class="formgroup">
                    <div class="col-sm-6 pd_rg_10">
                        <input type="text" class="formcontrols" id="first_name" placeholder="{{trans('frontend_header.first_name')}}" name="first_name">
                    </div>
                    <div class="col-sm-6 pd_lf_5">
                        <input type="text" class="formcontrols" id="last_name" placeholder="{{trans('frontend_header.last_name')}}" name="last_name">
                    </div>
                </div>

                <div class="formgroup">
                    <div class="col-sm-12 pd_lf_5">
                        <input type="email" class="formcontrols" id="email" placeholder="{{trans('frontend_header.email_address')}} " name="email">
                    </div>
                </div>
                <div class="formgroup">
                    <div class="col-sm-12 pd_lf_5">
                        <input type="password" class="formcontrols" id="password" placeholder="{{trans('frontend_header.password')}}" name="password">
                    </div>
                </div>
                <div class="formgroup">
                    <div class="col-sm-12 pd_lf_5">
                        <input type="password" class="formcontrols" id="confirm_password" placeholder="{{trans('frontend_header.retype_password')}}" name="confirm_password">
                    </div>
                </div>

                <div class="formgroup">
                    <div class="col-sm-6 gender-radio">
                        <input type="radio" id="male" class="" name="gender" value="1" checked />
                        <label for="male">Male</label>
                    </div>
                    <div class="col-sm-6 gender-radio">
                        <input type="radio" id="female" class="" name="gender"  value="2" />
                        <label for="female">Female</label>
                    </div>
                </div>

                <div class="col-sm-12 pd_lf_5">
                    <button type="button" class="btn btn-default formcontrols register-btn" id="create-btn">{{trans('frontend_header.create_account')}}</button>
                </div>
                <div class="formgroup">
                    <div class="col-md-12 control">
                        <div class="form_text text-center">
                            <span>{{trans('frontend_header.by_creating_an_account')}}, </span>
                            <a href="#"> Terms </a>
                        </div>
                    </div>
                </div>
                <div class="formgroup text-center">
                    <div class="col-md-12 control">
                        <div class="form_textone">
                            <span>{{trans('frontend_header.already_a_member')}}</span>
                            <a href="#" id="sign_in"> {{trans('frontend_header.login_here')}} </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
        </div>
      </div><!-- Modal content end-->
    </div>
  </div>
<!-- start form validation -->
<script>
    $(document).ready(function() {
        function showLogin(){
            $("#registerModal").removeClass("fade").modal("hide");
            $("#loginModal").modal("show").addClass("fade");
        }

        $('#sign_in').click(function(){
            showLogin();
        });
    });
</script>
<!-- end form validation -->

<!-- start login ajax-->
<script>

    $(document).ready(function(){
            $('.register-btn').click(function(){
                $('#registration').submit();
                // $('#create-btn').attr("disabled","disabled");
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
                    $('#create-btn').attr('disabled','disabled');
                    var serializedData = $('#registration').serialize();
                    $.ajax({
                        url: '/register',
                        type: 'POST',
                        data: serializedData,
                        success: function(data){
                            if(data.aceplusStatusCode == '200'){
                                /*location.reload(true);*/
                                /*
                                swal("Done!", "Register Succeed", "success");
                                window.setTimeout(function(){location.reload()},5000)
                                */
                                /*
                                localStorage.setItem("swal",
                                        swal({
                                            title: "Success!",
                                            text:  "Register succeed",
                                            type: "success",
                                            timer: 8000,
                                            showConfirmButton: true
                                        })
                                );
                                location.reload();
                                localStorage.getItem("swal");*/
                                swal({title: "Success", text: "Please verify your email to complete your registration!", type: "success"},
                                        function(){
                                            location.reload();
                                        }
                                );
                            }
                            else{
                                swal({title: "Fail", text: "Register Fail!", type: "error"},
                                        function(){
                                            location.reload();
                                        }
                                );
                            }

                        },
                        error: function(data){

                            swal({title: "Error", text: "Register Error!", type: "error"},
                                    function(){
                                        location.reload();
                                    }
                            );
                            return;
                        }
                    });

                }
            });

    });
</script>
<!-- end login ajax-->
