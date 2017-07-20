<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        {{--<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">--}}

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
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 18px;
            }
            .redcolor {
                color:#DF170F;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    <h1>Booking Cancellations</h1>
                    <p>Dear __________________, </p>
                    <p>I have previously made a booking with your <span class="redcolor">[hotel/restaurant]</span> and would like to cancel it due to [state the reason]. My booking number is _____. Enclosed with this [letter/email] are copied of the booking details and the receipt for your reference.</p>
                    <p>I am not familiar with the cancellation process, so please advise me if I need to fill some form or if there is some other formality.</p>
                    <p>As per your policy, there are no cancellation charges if I cancel <span class="redcolor">[one week]</span> prior to the booking date, so I kindly ask you to refund my deposit in full.</p>
                    <p>Please revert back to me and confirm that my booking has been cancelled. I surely welcome a future opportunity to visit your <span class="redcolor">[hotel/restaurant]</span> and I regret that this has happened as much as you do. </p>
                    <p>Sincerely, </p>
                </div>
            </div>
        </div>
    </body>
</html>
