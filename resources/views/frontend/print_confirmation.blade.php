<html>
<head>
    <title>Test Print</title>
</head>
<body>
    <table style="padding-bottom: 2px;">
        <tr>
            <td width="40%">
                <img style="width:120px;height:50px;" src="/assets/shared/images/mplogo.png" alt="logo">
            </td>
            <td width="10%"></td>
            <td width="50%" align="right">
                <h3>{{trans('frontend_details.booking_confirmation')}}</h3>{{trans('frontend_details.booking_number')}} : {{$booking->booking_no}}
            </td>
        </tr>

    </table>
    <br>
    <table style="width:100%;border-collapse: collapse;border: 2px solid black;padding:7px 0 4px 4px;">
        <tr>
            <td width="16%">
                @if($hotel->logo != "default_image.jpg" && $hotel->logo != "")
                    <img style="width:80px;height:70px;" src="/images/upload/{!! $hotel->logo !!}" alt="hotel_logo">
                @endif
            </td>
            <td colspan="3" width="84%">
                <span style="font-size:13px;font-weight:bold;">{{$hotel->name}}</span>
                <p style="font-size: 10pt;">
                    <b>{{trans('frontend_details.address')}} : </b> {{$hotel->address}}
                    <br>
                    <b>{{trans('frontend_details.phone')}} : </b> {{$hotel->phone}}<br>
                    <b>{{trans('frontend_details.fax')}}: </b> {{$hotel->fax}}
                </p>
            </td>
        </tr>
        <tr>
            <td width="20%" style="border-right: 1px dashed black;" align="center">
                <span style="font-size:8pt;">{{trans('frontend_details.check_in')}}</span><br/>
                <span style="font-size:11pt;font-weight: bold;">
                    {{Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y')}}
                </span><br/>
                <span style="font-size:8pt;">{{trans('frontend_details.from')}}</span><br/>
                <span style="font-size:11pt;font-weight: bold;">
                    {{$booking->check_in_time}}
                </span>
            </td>
            <td width="20%" style="border-right: 1px solid grey;" align="center">
                <span style="font-size:8pt;">{{trans('frontend_details.check_out')}}</span><br/>
                <span style="font-size:11pt;font-weight: bold;">
                    {{Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y')}}
                </span><br/>
                <span style="font-size:8pt;">{{trans('frontend_details.until')}}</span><br/>
                <span style="font-size:11pt;font-weight: bold;">
                    {{$booking->check_out_time}}
                </span>
            </td>
            <td width="20%" style="border-right: 1px solid grey;" align="center">
                <span style="font-size:14pt;font-weight: bold;">
                    {{$booking->room_count}}
                </span><br>
                <span style="font-size:8pt;">{{trans('frontend_details.rooms')}}</span><br>
                <span style="font-size:14pt;font-weight: bold;">
                    {{$booking->total_day}}
                </span><br>
                <span style="font-size:8pt;">{{trans('frontend_details.night')}}</span>
            </td>
            <td width="40%" align="right">
                {{--<span style="font-size:8pt;">{{trans('frontend_details.price')}}</span><br>--}}
                <span style="font-size:11pt;text-align: center;">
                    {{number_format($booking->price_wo_tax,2)}}
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3" width="60%" align="center" style="border-right: 1px solid grey;border-top: 2px solid grey;">
                <span style="font-size:8pt;">{{trans('frontend_details.goverment_tax')}} ({{$booking->total_government_tax_percentage}}%)</span>
            </td>
            <td width="40%" align="right">
                <span style="font-size:11pt;">
                    {{number_format($booking->total_government_tax_amt,2)}}
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3" width="60%" align="center" style="border-right: 1px solid grey;">
                <span style="font-size:8pt;">{{trans('frontend_details.service_tax')}} ({{$booking->total_service_tax_percentage}}%)</span>
            </td>
            <td width="40%" align="right">
                <span style="font-size:11pt;">
                    {{number_format($booking->total_service_tax_amt,2)}}
                </span>
            </td>
        </tr>

        {{--<tr>--}}
            {{--<td colspan="3" width="60%" align="center" style="border-right: 1px solid grey;">--}}
                {{--<span style="font-size:8pt;">Total Extra Bed Price</span>--}}
            {{--</td>--}}
            {{--<td width="40%" align="right">--}}
                {{--<span style="font-size:11pt;">--}}
                    {{--{{number_format($booking->total_extra_bed_price,2)}}--}}
                {{--</span>--}}
            {{--</td>--}}
        {{--</tr> --}}
        <tr>
            <td colspan="3" width="60%" align="center" style="border-right: 1px solid grey;border-top: 2px solid grey;border-bottom: 2px solid grey;">
                <span style="font-size:14pt;font-weight: bold;">{{trans('frontend_details.total_price')}}</span>
            </td>
            <td width="40%" align="right" style="border-top: 2px solid grey;border-bottom: 2px solid grey;">
                <span style="font-size:14pt;font-weight: bold;">
                    <i>USD</i> {{number_format($booking->total_payable_amt,2)}}
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="4" width="100%" align="center">
                <span style="font-size:10pt;">
                    {{trans('frontend_details.if_you_dont_show')}}
                </span>
            </td>
        </tr>
        @foreach($booking->rooms as $room)
        <tr>
            <td width="25%" style="border-top: 2px solid black;">
                <img style="width:150px;height:90px;" src="{!! $room->category_image !!}" alt="hotel_logo">
            </td>
            <td width="75%" style="border-top: 2px solid black;">
                <span style="font-size:13pt;font-weight:bold;">{{$room->room_category}}</span><br>
                <span style="font-size:10pt;"> {{trans('frontend_details.guests')}} : {{$room->guest_count}}</span><br>
                <span style="font-size:11pt;font-weight:bold;">{{trans('frontend_details.amenities')}}</span><br>
                @foreach($room->amenities as $amenity)
                    <span style="font-size:10pt;">{{"* ".$amenity->name}}</span>
                @endforeach
                <br>
                <span style="font-size:11pt;font-weight:bold;">{{trans('frontend_details.room_facilties')}}</span><br>
                @foreach($room->facilities as $facility)
                    <span style="font-size:10pt;">{{"* ".$facility->name}}</span>
                @endforeach
                <br>
                <span style="font-size:11pt;font-weight:bold;">{{trans('frontend_details.room_facilties')}}</span><br>
                @foreach($hotel->h_facilities as $h_facility)
                    <span style="font-size:10pt;">{{"* ".$h_facility->facility->name}}</span>
                @endforeach
                <br>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" width="100%" style="border-top: 2px solid black;">
                <b>Cancellation Cost:</b><br>
                <!-- until {{$booking->free_cancel_date}}[Yangon]: <b>Free cancellation </b><br>
                from {{$booking->first_cancel_date}}[Yangon] : USD {{number_format($booking->total_payable_amt/2,2)}} (50%)<br>
                from {{$booking->second_cancel_date}}[Yangon] : USD {{number_format($booking->total_payable_amt,2)}} (100%) -->
                {{trans('frontend_details.until')}} {{$booking->free_cancel_date}}: <b>{{trans('frontend_details.free_cancellation')}} </b><br>
                {{trans('frontend_details.from')}} {{$booking->first_cancel_date}} : USD {{number_format($booking->total_payable_amt/2,2)}} (50%)<br>
                {{trans('frontend_details.from')}} {{$booking->second_cancel_date}} : USD {{number_format($booking->total_payable_amt,2)}} (100%)
            </td>
        </tr>
    </table>
    <br style="line-height: 50px;">
    <table>
        <tr>
            <td width="50%">
                <span style="font-size:13px;font-weight:bold;">{{trans('frontend_details.hotel_policies')}}</span>
                <div style="width: 45%">
                    {!! !is_null($h_config) && !is_null($h_config->hotel_policies)?$h_config->hotel_policies:'' !!}
                </div>
            </td>
            <td width="50%">
                <b>{{trans('frontend_details.special_request')}}</b><br>
                @foreach($b_request_arr as $request)
                    {!! '-'.$request !!}<br>
                @endforeach
            </td>
        </tr>
    </table>
</body>
</html>
