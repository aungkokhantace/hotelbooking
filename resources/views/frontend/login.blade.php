<div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modalbody">
            <div class="col-md-12">
            <div class="imgcontainer">
                <img src="/assets/shared/images/Edit.png">
                <button type="button" class="close" data-dismiss="modal">⨂</button>
            </div>
            <h2 style="text-align:center;">Login</h2>
            <div id="show-error" class="col-sm-12"></div>
            <!-- <form class="form-horizontal"> -->
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
                   <!-- <button type="submit" class="btn btn-default formcontrolnew">Login</button> -->   
                   <button type="button" class="btn btn-default formcontrols login-btn">Login</button>                         
                </div> 
                {{--  <div class="col-sm-12 pd_lf_5 form_text">
                    <span class="psw"><a href="#">Forgot password?</a></span>
                </div>  --}}
                <div class="formgroup text-center">
                    <div class="col-md-12 control">
                        <div class="form_textone">
                            <a href="#" style="text-decoration:underline;" id="sign_up"> Not a member? Create Account </a>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
            {!! Form::close() !!}
        </div>  
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
</div>
<!-- start login ajax-->
<script>
    $(document).ready(function(){
        function showRegister(){
            $("#loginModal").removeClass("fade").modal("hide");
            $("#registerModal").modal("show").addClass("fade");
        }
        $('#sign_up').click(function(){
            showRegister();
        });
    
    });
</script>
<script>
    $(document).ready(function(){
        $('.login-btn').click(function(){
            var serializedData = $('#login').serialize();
            $.ajax({
                url: '/login',
                type: 'POST',
                data: serializedData,
                success: function(data){
                    if(data.aceplusStatusCode == '200'){
                        location.reload(true);
                    }
                    else if(data.aceplusStatusCode == '401'){
                        $('.alert').remove();
                        var showError    = '<p class="alert alert-danger">';
                        showError       += 'Email or password is incorrect!';
                        showError       += '</p>';
                        $('#show-error').append(showError);
                        return;
                    }
                    else{
                        swal({title: "Fail", text: "Login Fail!Please Try Again!", type: "error"},
                                function(){
                                    location.reload();
                                }
                        );
                        return;
                    }

                },
                error: function(data){
                    swal({title: "Opps", text: "Sorry, Please Try Again!", type: "error"},
                            function(){
                                location.reload();
                            }
                    );
                    return;
                }
            });
        });
    });
</script>
<!-- end login ajax-->


