<div class="modal fade" id="cancelBooking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="col-md-offset-2 modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&bigotimes;</button>
                <h4>Cancel Your Booking</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7 col-md-7">
                            <h5><b>Cancellation Policy</b></h5>
                            {{$booking->room_count.' Rooms  .................   '}}<b>{{$booking->charge}}</b>
                            {!! Form::open(array('url'=>'/booking/cancel','class'=> 'form-horizontal', 'id'=>'booking_cancel')) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{$booking->id}}">
                            <div class="row">
                                <div class="col-md-12" style="padding: 15px;">
                                    @foreach($reasons as $reason)
                                        <input type="radio" id="radio" name="reason" value="{{$reason->value}}">
                                        {{$reason->description}}
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success btn-yes">Yes, Cancel this booking.</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-no">No, I don't want to cancel.</button>
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
        $('.btn-yes').click(function(){
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
                    alert(data);
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


