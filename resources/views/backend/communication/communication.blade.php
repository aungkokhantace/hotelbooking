@extends('layouts.master')
@section('title','Communication Channel')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_communication.title-list')}}</h1>
    @if(isset($booking))
    <div class="row">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
            <!-- {!! Form::open(array('url' => '/backend_mps/communication/reply/store','id'=>'communication', 'onsubmit'=>'return validate()', 'class'=> 'form-horizontal user-form-border')) !!} -->
            {!! Form::open(array('url' => '/backend_mps/communication/reply/store','id'=>'communication', 'class'=> 'form-horizontal user-form-border')) !!}
            <input type="hidden" name="id" value="{{ $booking->id }}" />
                <div class="form-wrapper">
                    <div class="field-row row">
                        <div class="input-field col-md-8 col-xs-8 col-md-offset-2">
                            <label><span class="text-title">{{trans('setup_communication.place-hotel')}}</span></label>
                            <input id="hotel" value="{{ $booking->hotel->name }}" type="text" readonly>
                        </div>
                    </div>

                    <div class="field-row row">
                        <div class="input-field col-md-4 col-xs-8 col-md-offset-2">
                            <label class="">{{trans('setup_communication.place-check-in')}}</label>
                            <input id="check-in" value="{{ $booking->check_in_date }}" type="text" readonly>
                        </div>

                        <div class="input-field col-md-4 col-xs-8">
                            <label>{{trans('setup_communication.place-check-out')}}</label>
                            <input id="check-out" value="{{ $booking->check_out_date }}" type="text" readonly>
                        </div>
                    </div>

                    @foreach($booking_rooms as $booking_room)
                    <div class="field-row row">
                        <div class="input-field field-wrapper col-md-8 col-xs-8 col-md-offset-2">
                            <div class="spacer-20px"></div>
                            <div class="row">
                                <div class="input-field col-md-6 col-xs-12 search-fields">
                                    <label class="">{{trans('setup_communication.guest')}}</label>
                                    <select name="room-type" id="search-field2" disabled>
                                        <option value="1" @if ($booking_room->guest_count == 1) {{ 'selected' }} @endif >1</option>
                                        <option value="2" @if ($booking_room->guest_count == 2) {{ 'selected' }} @endif>2</option>
                                        <option value="3" @if ($booking_room->guest_count == 3) {{ 'selected' }} @endif>3</option>
                                        <option value="4" @if ($booking_room->guest_count == 4) {{ 'selected' }} @endif>4</option>
                                        <option value="5" @if ($booking_room->guest_count == 5) {{ 'selected' }} @endif>5</option>
                                        <option value="6" @if ($booking_room->guest_count == 6) {{ 'selected' }} @endif>6</option>
                                        <option value="7" @if ($booking_room->guest_count == 7) {{ 'selected' }} @endif>7</option>
                                        <option value="8" @if ($booking_room->guest_count == 8) {{ 'selected' }} @endif>8</option>
                                        <option value="9" @if ($booking_room->guest_count == 9) {{ 'selected' }} @endif>9</option>
                                        <option value="10" @if ($booking_room->guest_count == 10) {{ 'selected' }} @endif>10</option>
                                        <option value="11" @if ($booking_room->guest_count == 11) {{ 'selected' }} @endif>11</option>
                                    </select>
                                </div>

                                <div class="input-field col-md-6 col-xs-12 search-fields">
                                    <label class="">{{trans('setup_communication.smoking')}}</label>
                                    <select name="room-type" id="search-field2" disabled>
                                        <option value="1" @if ($booking_room->smoking == 1) {{ 'selected' }} @endif >Yes</option>
                                        <option value="0" @if ($booking_room->smoking == 0) {{ 'selected' }} @endif>No</option>
                                    </select>
                                </div>
                            </div><div class="spacer-20px"></div>

                            <div class="row">
                                <div class="input-field col-md-12 col-xs-12">
                                    <label class="">{{trans('setup_communication.first-last-name')}}</label>
                                    <input id="first-name" value="{{ $booking_room->user_first_name . ' ' . $booking_room->user_last_name }}" required="" type="text" readonly>
                                </div>
                            </div><div class="spacer-20px"></div>
                            <div class="row">
                                <div class="input-field col-md-12 col-xs-12">
                                    <label class="">{{trans('setup_communication.email')}}</label>
                                    <input id="first-name" value="{{ $booking_room->user_email }}" required="" type="text" readonly>
                                </div>
                            </div><div class="spacer-20px"></div>
                        </div>
                    </div>
                    @endforeach

                    <div class="field-row row">
                        <div class="input-field field-wrapper col-md-8 col-xs-8 col-md-offset-2">
                            <table class="field-table">
                                <tr>
                                    <td colspan="3"><label class="">{{trans('setup_communication.book-transporation')}}</label></td>
                                </tr>
                                <tr>
                                    <td width="10%"><input type="checkbox" @if($booking_request->booking_taxi == 1) {{ 'checked'}} @endif disabled></td>
                                    <td width="15%"><i class="fa fa-car fa-4x field-color" aria-hidden="true"></i></td>
                                    <td width="75%"><label>I'm interested in booking a taxi in advance</label></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="field-row row">
                        <div class="input-field field-wrapper col-md-8 col-xs-8 col-md-offset-2">
                            <table class="field-table">
                                <tr>
                                    <td colspan="3"><label class="">{{trans('setup_communication.book-tour')}}</label></td>
                                </tr>
                                <tr>
                                    <td width="10%"><input type="checkbox" @if($booking_request->booking_tour_guide == 1) {{ 'checked'}} @endif disabled></td>
                                    <td width="15%"><i class="fa fa-comments-o fa-4x field-color" aria-hidden="true"></i></td>
                                    <td width="75%"><label>I'm interested in booking tour guide.</label></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="field-row row">
                        <div class="input-field col-md-8 col-xs-8 col-md-offset-2">
                            <dl class="dl-vertical">
                                <dd><input type="checkbox" disabled @if($booking_request->non_smoking_room == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like a non-smoking room</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->twin_bed == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like twin beds</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->late_check_in == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like a late check-in</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->quiet_room == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like a quiet room</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->high_floor_room == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like a room on a high floor</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->airport_transfer == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like an airport transfer</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->large_bed == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like a large bed</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->private_parking == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like a private parking</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->early_check_in == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like an early check-in</dd>
                                <dd><input type="checkbox" disabled @if($booking_request->baby_cot == 1) {{ 'checked'}} @endif />&nbsp;&nbsp;&nbsp;I'd like to have a baby cot </dd>
                            </dl>
                        </div>
                    </div>

                    @foreach($booking_spec_reqs as $booking_spec_req)
                    <div class="field-row row">
                        <div class="input-field col-md-8 col-xs-8 col-md-offset-2">
                            @foreach($getUserobjs as $user)
                            <p class="@if($booking_spec_req->type == 1) {{ 'text-right'}} @endif">
                                @if($user->id == $booking_spec_req->created_by)
                                    {{ $user->user_name }}
                                @endif
                            </p>
                            @endforeach

                            <p class="@if($booking_spec_req->type == 1) {{ 'text-right'}} @endif">{{ $booking_spec_req->created_at }}</p>
                            <textarea class="textarea-field" rows="10" readonly>{{ $booking_spec_req->special_request }}</textarea>
                        </div>
                    </div><div class="spacer-20px"></div>
                    @endforeach

                    <div class="field-row row">
                        <div class="input-field col-md-8 col-xs-8 col-md-offset-2">
                            <label class="">Reply</label>
                            <textarea class="textarea-field" rows="10" name="reply" id="reply"></textarea>
                            <p class="text-danger">{{$errors->first('reply')}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input name="btnsubmit" value="REPLY" class="form-control btn-primary" type="submit">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('communication')" type="button">
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    @endif
</div>
@stop

@section('page_script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#communication').validate({
                rules: {
                    reply                    : 'required',
                },
                messages: {
                    reply                    : 'Reply Message is required',
                },
                submitHandler: function(form) {
                    // $('input[type="submit"]').attr('disabled','disabled');
                    swal({
                            title: "Are you sure?",
                            text: "You will not be able to recover!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55 ",
                            confirmButtonText: "Confirm",
                            cancelButtonText: "Cancel",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                              form.submit();
                            } else {
                                return;
                            }
                      });
                    // form.submit();
                }
            });
    });

    function confirm_reply() {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55 ",
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $("#communication").submit();
                    } else {
                        return;
                    }
              });
      }
</script>
@stop
