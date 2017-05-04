<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="col-md-offset-2 modal-content modal-content-width">
            <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 col-md-4 create_form">
                                <button type="button" class="close" data-dismiss="modal">&bigotimes;</button>
                                <div class="imgcontainer">
                                    <img src="shared/images/Edit.png">
                                </div>
                                <h2>Login</h2>

                                <div id="show-error" class="col-sm-12"></div>
                                {!! Form::open(array('url' => '/login', 'class'=> 'form-horizontal', 'id'=>'login','method'=>'get')) !!}

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
                                    <button type="button" class="btn btn-default formcontrols login-btn">Login</button>
                                </div>
                                <div class="col-sm-12 pd_lf_5 form_text">
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
            </div>
        </div>
    </div>
</div>

<!-- start login ajax-->
<script>
    $(document).ready(function(){
        $('.login-btn').click(function(){
            var email = $('#email').val();
            var password = $('#password').val();
            $.ajax({
                url: '/login',
                type: 'GET',
                data: {
                    email: email,
                    password: password
                },
                success: function(data){
                    if(data == 'Status 200'){
                        location.reload(true);
                        console.log('success');
                    }
                    else{
                        console.log('fail fail');
                        $('.alert').remove();
                        var showError    = '<p class="alert alert-danger">';
                        showError       += 'Email or password is incorrect!';
                        showError       += '</p>';
                        $('#show-error').append(showError);
                        return;
                    }

                },
                error: function(data){
                    return;
                },
                complete: function () {
                    return;

                }
            });
        });
    });
</script>
<!-- end login ajax-->


