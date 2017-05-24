<div class="col-md-3">
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
                <td>{{$total_amount}} MMK</td>
            </tr>
            <tr>
                <td width="80%">5% TAX</td>
                <td>US$1.63</td>
            </tr>
            <tr>
                <td width="80%">10% Property service charge</td>
                <td>US$34.63</td>
            </tr>
            <tr style="color:#D63090">
                <td width="80%">Today you'll pay</td>
                <td>US$ 0</td>
            </tr>
            <tfoot>
            <tr>
                <td width="80%">You'll pay at the property</td>
                <td>US$ 40</td>
            </tr>
            </tfoot>
            </tbody>
        </table>
        <a href="#">Change your selection</a>
    </div>
    <div class="table_lists">
        <table>
            <tbody>
            <tr>
                <td width="80%"><strong style="font-size:16px;">Price</strong><br>(for 4 guests)</td>
                <td style="font-size:16px;padding-left:5px;">US$40</td>
            </tr>
            </tbody>
        </table>
        <p href="#">No Surprises! Final price.</p>
    </div>
    <a href="#" style="font-size: 12px;font-family: 'Playfair Display';
                color: #3299DB;">Read me - I'm important!</a>
</div>