@extends('layouts_frontend.master_frontend')
@section('title','About Us')
@section('content')
        <div id="header_id">
            <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
        </div>
    </div>
    </section>

    <section id="popular">
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <!-- Blog Sidebar Widgets Column -->
                @include('frontend.booking_include')

                <!-- Blog Entries Column -->
                <div class="col-md-9 search_list">
                    <!-- Service Tabs -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="border-bottom:1px solid #ccc;">
                                <ul id="myTab" class="nav nav-tabs nav-justified nav-ff">
                                    <li class=""><a href="#"> 1.Choose your rooms </a>
                                    </li>
                                    <li class=""><a href="#service-one"> 2.Enter your details </a>
                                    </li>
                                    <li class="active"><a href="#service-two" data-toggle="tab"> 3.Confirm your reservation </a>
                                    {{--<li class=""><a href="#service-two"> 3.Confirm your reservation </a>--}}
                                    </li>
                                </ul>
                            </div>

                            <!--Tab-->
                            <div id="myTabContent" class="tab-content">
                                <!--Choose Your Room-->
                                <div class="tab-pane fade" id="#">

                                </div>
                                <!--Enter Your Detail-->
                                <div class="tab-pane fade" id="service-one">
                                </div>
                                <!--Confirm your reservation-->
                                <div class="tab-pane fade active in" id="service-two">
                                    <div id="payment_blog">
                                        <div class="blog_booking">
                                            <div class="left_img">
                                                {{--<img class="img-responsive img-hover" src="/assets/shared/images/UserBookingList_img.png" alt="">--}}
                                                <img src="/images/upload/{{$hotel->logo}}" alt="" style="width:100%; height:140px; ">
                                            </div>
                                            <div>
                                                <div class="payment_left">
                                                    <h4>{{$hotel->name}}</h4>
                                                    <p class="payment_lead">
                                                        <img src="/assets/shared/images/map.png"> {{$hotel->address}}
                                                    </p>
                                                    <table>
                                                        <tr>
                                                            <td>Check In</td>
                                                            <td class="table_right">@if(Session::has('check_in')) {{session('check_in')}} (d-m-Y) @endif</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Check Out</td>
                                                            <td class="table_right">@if(Session::has('check_out')) {{session('check_out')}} (d-m-Y) @endif</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Length of Stay</td>
                                                            @if(isset($nights) && $nights > 1)
                                                                <td class="table_right">{{$nights}} nights</td>
                                                            @else
                                                                <td class="table_right">{{$nights}} night</td>
                                                            @endif
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment_form confirm-reserve-body">
                                        {!! Form::open(array('url' => '/book_and_pay','files'=>true, 'id'=>'book_and_pay_form', 'class'=> 'form-horizontal user-form-border')) !!}
                                            <div class="paymentformgroups">
                                                <div class="col-sm-6 pd_rg_10">
                                                    <label>Country<span style="color:red;">*</span></label>
                                                    <input type="text" class="formcontrols" id="country" name="country">
                                                    <br>
                                                    <span style="padding:5px;">No address needed for this reservation</span>
                                                </div>
                                            </div>
                                            <div class="paymentformgroups">
                                                <div class="col-sm-6 pd_rg_10">
                                                    <label>Telephone (mobile number preferred) <span style="color:red;">*</span></label>
                                                    <div class="col-10 input-group">
                                                        <input id="phone" class="formcontrols font_sz_11" type="text" value="" name="phone">
                                                        <div class="input-group-addons">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 pd_rg_10">
                                                    <div class="button_paynow">
                                                        <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-lock" aria-hidden="true"></i> &nbsp;BOOK & PAY NOW!</button>
                                                    </div>
                                                </div>
                                            </div>
                                        {{--</form>--}}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            <!--Tab-->
                        </div>
                    </div> <!--row-->
                </div><!--col-md-9-->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
@stop

@section('page_script')
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function(){
            //validate form
            $('#book_and_pay_form').validate({
                rules: {
                    country          : 'required',
                    phone: {
                        required     : true,
                        numeric      : true,
                        },
                },
                messages: {
                    country          : 'Country is required',
                    phone: {
                        required     : 'Phone number is required',
                        numeric      : 'Phone number must be numeric',
                    },
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
        });

        function nextTab(){
//            alert('this is next tab!!');
        }
    </script>
@stop