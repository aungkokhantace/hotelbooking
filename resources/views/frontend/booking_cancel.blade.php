<div class="modal fade" id="cancelbooking" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-headers">
                <button type="button" class="closed" data-dismiss="modal">⨂</button>
                <h4 class="modal-title">{{trans('frontend_details.cancel_your_booking')}}</h4>
            </div>
            {!! Form::open(array('url'=>'/booking/cancel','id'=>'booking_cancel', 'method'=>'post')) !!}
            <div class="modalcancel-body">
                <div class="col-md-12">
                    <div class="row">
                        <h5>Cancellation Policy</h5>
                        <p style="padding: 15px 0px;">
                            {{$booking->room_count.' Room(s)  .................   '}}<b>{{$booking->charge}}</b>
                        </p>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{$booking->id}}">
                        @foreach($reasons as $reason)
                            <div class="radio">
                                <label>
                                    <input type="radio"
                                           name="reason"
                                           id="radio"
                                           value="{{$reason->value}}"
                                    >
                                    {{$reason->description}}
                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-6 pd_lf_5">
                    <button type="button"
                            class="btn btn-defaulted1 btn-yes"
                            data-dismiss="modal">
                       {{trans('frontend_details.cancel_booking')}}
                    </button>
                </div>
                <div class="col-sm-6 pd_lf_5">
                    <button type="button"
                            class="btn btn-defaulted2 btn-no"
                            data-dismiss="modal">
                       {{trans('frontend_details.no_i_want_cancel')}}
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- Modal content -->
    </div>
</div>
<!-- start login ajax-->
<script>
    $(document).ready(function(){
        $('.btn-yes').click(function(){
            /* Disable change date link */
            $('.cancel_link').click(function () {return false;});

            var serializedData = $('#booking_cancel').serialize();
            $.ajax({
                url: '/booking/cancel',
                type: 'POST',
                data: serializedData,
                success: function(data){
                    $('#cancelBooking').modal('hide');
                    if(data.aceplusStatusCode == '200'){
                        swal({title: "Success", text: "Booking cancellation is successful.Please check your email.", type: "success"},
                                function(){
                                    window.location = '/booking/cancel/show/'+data.param;
                                }
                        );
                        return;
                    }
                    else if(data.aceplusStatusCode == '503'){
                        console.log(data);
                        swal({title: "Warning", text: "Booking cancellation is successful.But email can't send for some reason.", type: "warning"},
                                function(){
                                    window.location = '/booking/cancel/show/'+data.param;
                                }
                        );
                        return;
                    }
                    else{
                        swal({title: "Fail", text: "Something Wrong!", type: "error"},
                                function(){
                                    location.reload();
                                }
                        );
                        return;
                    }

                },
                error: function(data){
                    console.log(data);
                    swal({title: "Opps", text: "Sorry, Please Try Again!", type: "error"},
                            function(){
                                location.reload();
                            }
                    );
                    return;
                }
            });
        });

        $('.btn-no').click(function(){
            location.reload();
        });
    });
</script>
<!-- end login ajax-->
