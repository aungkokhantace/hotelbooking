<div class="col-md-3 enterdetail">
    <!-- Blog Search Well -->
    <div class="side_title">
        <h5>{{trans('frontend_details.your_booking_includes')}}</h5>
    </div>
    <div class="list_style">
        <ul>
            @foreach($hotelFacilities as $hotelFacility)
                <li>{{$hotelFacility->facility->name}}</li>
            @endforeach
        </ul>
    </div>
    <div class="table_lists">
        <table>
            <tbody>
            <tr>
                @if(isset($totalRooms) && $totalRooms > 1)
                    <td width="80%">{{$totalRooms}} @if($totalRooms>1){{trans('frontend_details.rooms')}} @else {{trans('frontend_details.room')}} @endif</td>
                @else
                    <td width="80%">{{$totalRooms}} {{trans('frontend_details.room')}}</td>
                @endif
                <td>{{session('total_amount_wo_discount').' '.$currency}}</td>
{{--
                <td>{{session('total_amount_wo_discount').' '.$currency}}</td>
                       <td>{{session('total_payable_amount_wo_extrabed')}} MMK</td>--}}   </tr>
            <tr></tr>

            <tr>
                <td width="80%">{{trans('frontend_details.discount')}}</td>
                <td>{{'-'.session('total_discount_amount').' '.$currency}}</td>
            </tr>

            <tr>
                <td width="80%">{{trans('frontend_details.amount_after_discount')}}</td>
                <td>{{session('total_amount_w_discount').' '.$currency}}</td>
            </tr>

            @if((Session::has('total_extrabed_fee')) && session('total_extrabed_fee') != 0)
            <tr>
                <td width="80%">{{trans('frontend_details.extra_bed_price')}}</td>
                <td>{{session('total_extrabed_fee').' '.$currency}}</td>
            </tr>
            <tr>
                <td width="80%">{{trans('frontend_details.amount_including_extra_bed')}}</td>
                <td>{{session('total_payable_amount_w_extrabed').' '.$currency}}</td>
            </tr>
            @endif
            <tr>
                <td width="80%">{{session('service_tax')}}% {{trans('frontend_details.service_tax')}} </td>
                <td>{{session('service_tax_amount').' '.$currency}}</td>
            </tr>

            <tr>
                <td width="80%">{{session('gov_tax')}}% {{trans('frontend_details.goverment_tax')}}</td>
                <td>{{session('gov_tax_amount').' '.$currency}}</td>
            </tr>

            {{--<tr>--}}
                {{--<td width="80%">10% Property service charge</td>--}}
                {{--<td>US$34.63</td>--}}
            {{--</tr>--}}
            {{--<tr style="color:#D63090">--}}
                {{--<td width="80%">Today you'll pay</td>--}}
                {{--<td>US$ 0</td>--}}
            {{--</tr>--}}
            {{--<tfoot>--}}
            <tr>
                <td width="80%">{{trans('frontend_details.you_pay')}}</td>
                <td>{{session('payable_amount').' '.$currency}}</td>
            </tr>
            </tfoot>
            </tbody>
        </table>
        <a href="/hotel_detail/{{$hotel->id}}">{{trans('frontend_details.change_your_selection')}}</a>
    </div>
    <div class="table_lists">
        <table>
            <tbody>
            <tr>
                <td width="80%"><strong style="font-size:16px;">{{trans('frontend_details.price')}}</strong></td>
                <td style="font-size:16px;padding-left:5px;">{{number_format(session('payable_amount'),2).' '.$currency}}</td>
            </tr>
            </tbody>
        </table>
        <p href="#">{{trans('frontend_details.no_surprice_price')}}.</p>
    </div>
    <a href="#" style="font-size: 12px;font-family: 'Playfair Display';
                color: #3299DB;">{{trans('frontend_details.read_me_important')}}</a>
</div>
