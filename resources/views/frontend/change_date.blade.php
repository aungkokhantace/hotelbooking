<div class="modal fade" id="change_date" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-headers">
                <button type="button" class="closed" data-dismiss="modal">⨂</button>
                <h4 class="modal-title">Change Dates</h4>
            </div>
            {!! Form::open(array('url'=>'/booking/change_date','id'=>'change_date_form', 'method'=>'post')) !!}
            <div class="modalcancel-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{$booking->id}}">
                        <div class="form-group row">
                            <label class="control-label" for="check_in">Check In</label>
                            <div class="col-10 input-group date" data-provide="datepicker" id="check_in">
                                <input type="text" class="form-control" name="check_in" autocomplete="off">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                                <p class="text-danger">{{$errors->first('check_in')}}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label" for="check_out">Check Out</label>
                            <div class="col-10 input-group date" data-provide="datepicker" id="check_out" autocomplete="off">
                                <input type="text" class="form-control" name="check_out">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                                <p class="text-danger">{{$errors->first('check_out')}}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-6 pd_lf_5">
                    <button type="button"
                            class="btn btn-defaulted1 btn-change-ok"
                            data-dismiss="modal">
                        OK
                    </button>
                </div>
                <div class="col-sm-6 pd_lf_5">
                    <button type="button"
                            class="btn btn-defaulted2 btn-change-cancel"
                            data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- Modal content -->
    </div>
</div>
@section('page_script')

    <script>
        $(document).ready(function () {
        
            /* Date Picker with controls of from date and to date */
            $("#check_in").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                showButtonPanel: true,
                startDate: new Date()
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate() + 1);
                $('#check_out').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('#check_out').datepicker('setStartDate',null);
            });

            $("#check_out").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                startDate: new Date()
            }).on('changeDate', function (selected) {
                var endDate = new Date(selected.date.valueOf());
                $('#check_in').datepicker('setEndDate', endDate);
            }).on('clearDate', function (selected) {
                $('#check_in').datepicker('setEndDate',null);
            });

            /* Change Date Ajax */
            $('.btn-change-ok').click(function(){
                /* Disable change date link */
                $('.change_date_link').click(function () {return false;});

                var serializedData = $('#change_date_form').serialize();
                $.ajax({
                    url: '/booking/change_date',
                    type: 'POST',
                    data: serializedData,
                    success: function(data){
                        $('#change_date').modal('hide');
                        if(data.aceplusStatusCode == '200'){
                            swal({title: "Success", text: "An updated confirmation has been sent to your email.Please check your email.", type: "success"},
                                    function(){
//                                        window.location = '/booking/cancel/show/'+data.param;
                                        location.reload();
                                    }
                            );
                            return;
                        }
                        else if(data.aceplusStatusCode == '203'){
                            console.log(data);
                            swal({title: "Warning", text: "Changing your check_in/check_out dates is successful.But email could not send for some reason.", type: "warning"},
                                    function(){
//                                        window.location = '/booking/cancel/show/'+data.param;
                                        location.reload();
                                    }
                            );
                            return;
                        }
                        else if(data.aceplusStatusCode == '404'){
                            console.log(data);
                            swal({title: "Warning", text: "Ajax Fail", type: "warning"},
                                    function(){
//                                        window.location = '/booking/cancel/show/'+data.param;
                                        location.reload();
                                    }
                            );
                            return;
                        }
                        else{
                            swal({title: "Fail", text: "Sorry,we could not make this change.", type: "error"},
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
            /* Change Date Ajax */
        });
    </script>
@stop