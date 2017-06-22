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

class PaymentTestController extends Controller
{
    public function payment_for_later(){
        $stripe = array(
            "secret_key"      => "sk_test_Y1kf5chBWcPvsC2RBjVc1Ts9",
            "publishable_key" => "pk_test_fJWTQndbD4G5frZV8vxtFQiv"
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
}
