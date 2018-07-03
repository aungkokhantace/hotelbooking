@extends('layouts_frontend.master_frontend')
@section('title','User Profile')
@section('content')
    <div id="header_id">
        <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
    </div>
    </div>

    <section id="popular">
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <!-- Blog Sidebar Widgets Column -->
                <div class="col-md-3">
                    <!-- Blog-->
                    <div>
                        <div class="side_profile">
                            <img src="/assets/shared/images/user.png">
                            <h3>{{isset($customer)?$customer->first_name.' '.$customer->last_name:''}}</h3>
                        </div>
                        <div class="side_gmail">
                            <p>{{isset($customer)?$customer->email:''}}</p>
                        </div>
                        <div class="left_menu">
                            <ul>
                                <li><a href="/bookingList">{{trans('frontend_details.booking_list')}}</a></li>
                                <li><a class="active" href="#">{{trans('frontend_details.my_profile')}}</a></li>
                            </ul>
                        </div>
                    </div>

                </div><!-- Blog Entries Column -->
                <div class="col-md-9">
                    <!-- Blog Search Well -->
                    <div>
                        <div class="side_title">
                            <h4>{{trans('frontend_details.my_profile')}}</h4>
                            @if ($errors->has())
                                <p class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </p>
                            @endif
                        </div>
                        {!! Form::open(array('url' => '/profile', 'id'=>'profile')) !!}
                            <input type="hidden" name="id" value="{{isset($customer)? $customer->id:''}}"/>
                            <div class="my_profile">
                                <div class="profile row">
                                    <label for="first_name" class="col-sm-2 profile-form-labels">{{trans('frontend_header.first_name')}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="profile-form-controls" id="first_name" placeholder="First Name" name="first_name" value="{{isset($customer)? $customer->first_name:Request::old('first_name')}}">
                                        <p class="text-danger">{{$errors->first('first_name')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="my_profile">
                                <div class="profile row">
                                    <label for="last_name" class="col-sm-2 profile-form-labels">{{trans('frontend_header.last_name')}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="profile-form-controls" id="last_name" placeholder="Last Name" name="last_name" value="{{isset($customer)? $customer->last_name:Request::old('last_name')}}">
                                        <p class="text-danger">{{$errors->first('last_name')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="my_profile">
                                <div class="profile row">
                                    <label for="email" class="col-sm-2 profile-form-labels">{{trans('frontend_header.email_address')}}</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="profile-form-controls" id="email" placeholder="Email" name="email" value="{{isset($customer)? $customer->email:Request::old('email')}}">
                                        <p class="text-danger">{{$errors->first('email')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="my_profile">
                                <div class="profile row">
                                    <label for="address" class="col-sm-2 profile-form-labels">{{trans('frontend_details.address')}}</label>
                                    <div class="col-sm-10">
                                        <textarea class="profile-form-controls" rows="5" id="address" placeholder="{{trans('frontend_details.address')}}" name="address">{{isset($customer)? $customer->address:Request::old('address')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="profile row">
                                <label for="submit" class="col-sm-2 col-form-labels"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn profile-btn-default1">{{trans('frontend_details.update')}}</button>
                                    <!-- <button type="submit" class="btn">{{trans('frontend_details.update')}}</button> -->
                                    <!-- <button type="button" onclick="cancel_profile()" class="btn profile-btn-default2">{{trans('frontend_details.Cancel')}}</button> -->

                                    <button type="button" onclick="cancel_profile()" class="btn profile-btn-default2">{{trans('frontend_details.Cancel')}}</button>
                                    <!-- <button type="button" class="btn">{{trans('frontend_details.Cancel')}}</button> -->
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
@stop

@section('page_script')
    <!-- Start Validation -->
    <script>
        $(document).ready(function(){
            $('#profile').validate({
                rules: {
                    first_name      : 'required',
                    last_name       : 'required',
                    email   	        : {
                        required 	: true,
                        email	 	: true,
                        remote: {
                            url: "{{route('profile/check_email')}}",
                            type: "get",
                            data:
                            {
                                email: function()
                                {
                                    return $('#email').val();
                                }
                            }
                        }
                    }
                },
                messages: {
                    first_name      : 'Require!',
                    last_name       : 'Require!',
                    email     	        : {
                        required 	: 'Require!',
                        email 	 	: 'Email is invalid format',
                        remote		: jQuery.validator.format("{0} is already taken.")
                    },
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
        });
    </script>
    <!-- End Validation -->
@stop
