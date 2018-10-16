<?php

namespace App\Http\Controllers\Payment;

use App\Setup\Booking\BookingRepository;
use App\Setup\HotelConfig\HotelConfigRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Mail;
use App\Payment\PaymentUtility;
use App\Core\Utility;
use App\Core\ReturnMessage;

class PaymentTestController extends Controller
{
    public function payment_for_later(){
        $stripe = array(
//            "secret_key"      => "sk_test_Y1kf5chBWcPvsC2RBjVc1Ts9",
//            "publishable_key" => "pk_test_fJWTQndbD4G5frZV8vxtFQiv"

            "secret_key"      => "sk_test_pIwc9et6wlWYcAb2xfsz9UmY",
            "publishable_key" => "pk_test_1bnp84rAk5y91LIN9BJ7OdYX"
        );

        return view('payment.payment_for_later')->with('stripe',$stripe);
    }

    public function paymentForLater_Payment(){

        //Set your secret key: remember to change this to your live secret key in production
        //See your keys here: https://dashboard.stripe.com/account/apikeys
        Stripe::setApiKey("sk_test_Y1kf5chBWcPvsC2RBjVc1Ts9");

        // Token is created using Stripe.js or Checkout!
        // Get the payment token submitted by the form:
        $token = $_POST['stripeToken'];
        $email = $_POST['stripeEmail'];

        // Create a Customer:
        $customer = Customer::create(array(
            "email" => $email,
            "source" => $token,
        ));

        $customer_id = $customer['id'];

        // Charge the Customer instead of the card:
        $charge = Charge::create(array(
            "amount" => 1000,
            "currency" => "usd",
            "customer" => $customer_id
        ));

        //Insert Stripe Customer
        DB::table('stripe_user')->insert(['stripe_user_id'=>$customer_id,'email'=>$email,'status'=>1]);

        dd('success');

    }

    public function cron_test(){
        try{

            $bookingRepo        = new BookingRepository();
            $confirmBooking     = $bookingRepo->getConfirmBooking();
            $todayDate          = date('Y-m-d');
            if(isset($confirmBooking) && count($confirmBooking) > 0){

                foreach($confirmBooking as $cBooking){
                    dd($cBooking);
                    $totalDays      = $cBooking->cancellation_days+2;
                    $sendMailDate   = date('Y-m-d',strtotime($todayDate.'+'.$totalDays.' days'));
//                    dd($sendMailDate,$cBooking->check_in_date);
                    if($sendMailDate == $cBooking->check_in_date){
                        dd('send mail');
                        Mail::send('frontend.mail.noti_mail', function($message) {
                            $message->to(Input::get('email'),Input::get('name'))
                                ->subject('Verify your email address');
                        });
                    }
                    dd('not send mail');
                }

            }

        }catch (\Exception $e){

        }
    }

    public function paymentForLater_Payment2(){

        $stripePaymentObj           = new PaymentUtility();
        $stripePaymentResult        = $stripePaymentObj->createCustomer($_POST);

        dd($stripePaymentResult);

    }


    public function testCapture(){

        // Test Customer Id and amount that you will need to change wti
        $customerId = "cus_B1N9CdEVcDqfte";
        $amount     = 1000;

        $stripePaymentObj           = new PaymentUtility();
        $stripePaymentResult        = $stripePaymentObj->capturePayment($customerId, $amount);

        dd($stripePaymentResult);

    }


    public function testRefund(){

        // Test Customer Id and amount that you will need to change wti
        $customerId         = "cus_B1N9CdEVcDqfte";
        $chargeId           = "ch_1AfMBsBCQLjaAvwiPh10QjZv";
        $amount             = 1500;

        $stripePaymentObj           = new PaymentUtility();
        $stripePaymentResult        = $stripePaymentObj->refundPayment($customerId, $amount,$chargeId);

        dd($stripePaymentResult);

    }

    public function emailTest(){
      return view('email_templates.booking_cancel');
        $emails              = ['aungkokhantace@gmail.com'];
        $template           = "booking_cancellation_start";
        // $template           = "email_templates.booking_confirm";
        $subject            = "Email Function Test";
        $logMessage         = "Test Log";

        $parameters = array();

        $gst = Utility::getGST();
        $hotel_id = 1;
        $service_tax = Utility::getServiceTax($hotel_id);

        $user    = session('customer');

        $user_name = $user['display_name'];

        $booking_number = "OTA009";
        $hotel_name = "Melia";
        $room_description = "The twin / single room with air-conditioning and WiFi available in the hotel rooms and free of charge.";
        $guest_name = $user_name;
        $check_in_date = "3-Aug-18";
        $check_out_date = "4-Aug-18";
        $number_of_guest = 2;
        $room_type = "Superior Room";
        $number_of_night = 1;
        $booking_number = "OTA0009";
        $meal_plan = "Breakfast is included in the room rate";
        $total_price  = 100.00;
        $special_request  = "Non-smoking Room";
        $room_count  = 1;

        $parameters = [
          'user_name'=>$user_name,
          'booking_number'=>$booking_number,
          'hotel_name'=>$hotel_name,
          'room_description'=>$room_description,
          'guest_name'=>$guest_name,
          'check_in_date'=>$check_in_date,
          'check_out_date'=>$check_out_date,
          'number_of_guest'=>$number_of_guest,
          'room_type'=>$room_type,
          'number_of_night'=>$number_of_night,
          'booking_number'=>$booking_number,
          'meal_plan'=>$meal_plan,
          'total_price'=>$total_price,
          'special_request'=>$special_request,
          'room_count'=>$room_count
        ];

        // $mailResult         = Utility::sendMailWithParameters($template,$parameters,$emails,$subject,$logMessage);
        $mailResult         = Utility::sendMail($template,$emails,$subject,$logMessage);

        if ($mailResult['aceplusStatusCode'] == ReturnMessage::OK){
            alert()->success('Sending email was successful!')->persistent('OK');
        }
        else{
            alert()->success('Sending email failed !')->persistent('OK');
        }
        return redirect()->action('Frontend\HomeController@index');
    }
}
