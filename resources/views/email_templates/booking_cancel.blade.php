<!DOCTYPE html>
<html>
    <head>
        <title>Booking Cancel</title>

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
            .body-text {
                font-size: 14px;
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
            .full-width {
              width:100%;
            }
            .border-bottom {
              border-bottom: 1px solid;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    <h2 class="underlined-text">Hotel Cancellation Form</h2>
                </div>

                <table class="full-width bordered">
                  <tr>
                    <td>Booking Number</td>
                    <td>OTA0009</td>
                  </tr>
                  <tr>
                    <td>Name</td>
                    <td>Smith</td>
                  </tr>
                  <tr class="border-bottom">
                    <td>Email</td>
                    <td>smith.sm@gmail.com</td>
                  </tr>
                  <tr>
                    <td>Your Reservation</td>
                    <td>1 Night, 1 Room</td>
                  </tr>
                  <tr>
                    <td>Check-in</td>
                    <td>Oct 19, 2018</td>
                  </tr>
                  <tr>
                    <td>Check-out</td>
                    <td>Oct 22, 2018</td>
                  </tr>
                </table>
            </div>
        </div>
    </body>
</html>
