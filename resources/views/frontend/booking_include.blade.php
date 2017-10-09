<div class="col-md-3 enterdetail">
    <!-- Blog Search Well -->
    <div class="side_title">
        <h5>Your Booking Includes</h5>
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
                    <td width="80%">{{$totalRooms}} rooms</td>
                @else
                    <td width="80%">{{$totalRooms}} room</td>
                @endif
                <td>{{session('total_amount_wo_discount').' '.$currency}}</td>
{{--
                <td>{{session('total_amount_wo_discount').' '.$currency}}</td>
                       <td>{{session('total_payable_amount_wo_extrabed')}} MMK</td>--}}   </tr>
            <tr></tr>

            <tr>
                <td width="80%">Discount</td>
                <td>{{'-'.session('total_discount_amount').' '.$currency}}</td>
            </tr>

            <tr>
                <td width="80%">Amount after Discount</td>
                <td>{{session('total_amount_w_discount').' '.$currency}}</td>
            </tr>

            @if((Session::has('total_extrabed_fee')) && session('total_extrabed_fee') != 0)
            <tr>
                <td width="80%">Extrabed Price</td>
                <td>{{session('total_extrabed_fee').' '.$currency}}</td>
            </tr>
            <tr>
                <td width="80%">Amount including Extrabed Price</td>
                <td>{{session('total_payable_amount_w_extrabed').' '.$currency}}</td>
            </tr>
            @endif
            <tr>
                <td width="80%">{{session('service_tax')}}% SERVICE TAX</td>
                <td>{{session('service_tax_amount').' '.$currency}}</td>
            </tr>

            <tr>
                <td width="80%">{{session('gov_tax')}}% GOVERNMENT TAX</td>
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
                <td width="80%">You'll pay</td>
                <td>{{session('payable_amount').' '.$currency}}</td>
            </tr>
            </tfoot>
            </tbody>
        </table>
        <a href="/hotel_detail/{{$hotel->id}}">Change your selection</a>
    </div>
    <div class="table_lists">
        <table>
            <tbody>
            <tr>
                <td width="80%"><strong style="font-size:16px;">Price</strong></td>
                <td style="font-size:16px;padding-left:5px;">{{number_format(session('payable_amount'),2).' '.$currency}}</td>
            </tr>
            </tbody>
        </table>
        <p href="#">No Surprises! Final price.</p>
    </div>
    <a href="#" style="font-size: 12px;font-family: 'Playfair Display';
                color: #3299DB;">Read me - I'm important!</a>
</div>