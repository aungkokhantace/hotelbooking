<!DOCTYPE html>
<html>
    <head>
        <title>Booking Confirm</title>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: justify;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: justify;
                display: inline-block;
            }

            .title {
                font-size: 16px;
            }
            .redcolor {
                color:#DF170F;
            }
            .bold-text {
              font-weight: bold;
            }
            .underlined-text{
              text-decoration: underline;
            }
            .bordered{
              border-style: solid;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    <h2 class="underlined-text">Hotel Booking Confirmation Form</h2>

                    <p>Hello {{$user_name}}, <br>
                    Your booking is confirmed under our authentication code "<b>{{$booking_number}}</b>".<br>
                    "<b>{{$hotel_name}}</b>" Hotel look forward to the pleasure of having your guests.</p>

                    <p>Thank you for using our service.<br>
                    Payment accepts in cash on arrival.
                    </p>

                    <p>ID Number: {{$booking_number}}</p>
                    <p>Check in Date: {{$check_in_date}}</p>
                    <p>Check out Date: {{$check_out_date}}</p>
                    <p>Number of night: {{$number_of_night}}</p>
                    <p>Number of room: {{$room_count}}</p>
                    <p>Guest Name: {{$guest_name}}</p>

                    <hr>
                    @foreach($booking_rooms_info_for_email as $booking_room)
                      <p>Room Detailed Information <br>
                        {{$booking_room->room_description}}
                      </p>
                      <p>Number of guests: {{$booking_room->number_of_guest}}</p>
                      <p>Room Type: {{$booking_room->room_type}}</p>
                      <p>Meal Plan: {{$booking_room->meal_plan}}</p>
                      <hr>
                    @endforeach

                    <p>Total Price: <b>${{$total_price}}</b></p>
                    <br>
                    <div class="bordered">
                      Please note: Not include the extra bed price in this amount. If you would like to add extra bed, additional supplement price will add to this total.
                    </div>
                    <br>
                    @if(isset($special_request) && $special_request !== '' && $special_request !== null)
                    <div class="bordered">
                      Special Request: {{$special_request}}
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </body>
</html>
