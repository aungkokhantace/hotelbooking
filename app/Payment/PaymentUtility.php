<?php 
namespace App\Payment;

/**
 * Created by PhpStorm.
 * User: william
 * Date: 7/13/2017
 * Time: 1:13 PM
 */

use App\Payment\PaymentConstance;
use Stripe\Stripe;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Setup\Facilities\Facilities;
use App\Core\Utility;
use App\Core\ReturnMessage;

class PaymentUtility
{
    public function createPaymentObj()
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

//        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
//        $currentUser = "MrTesting";

        try {

            $secret_key = PaymentConstance::STRIPE_SECRET_KEY;
            $publishable_key = PaymentConstance::STIRPE_PUBLISHABLE_KEY;

            $stripe = array(
                "secret_key" => $secret_key,
                "publishable_key" => $publishable_key
            );

            \Stripe\Stripe::setApiKey($secret_key);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['stripe'] = $stripe;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a Payment and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function createCustomer($ParamData){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

//        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
//        $currentUser  = "MrTesting";
        try {

            // Token is created using Stripe.js or Checkout!
            // Get the payment token submitted by the form:
            $token = $ParamData['stripeToken'];
            $email = $ParamData['stripeEmail'];

            $tempStripeObj  = $this->createPaymentObj();

            if($tempStripeObj['aceplusStatusCode'] != ReturnMessage::OK){
                throw new Exception('Error with payment token !!!!');
            }

            // Create a Customer:
            $customer = \Stripe\Customer::create(array(
                "email" => $email,
                "source" => $token,
            ));

            $stripeObj = array();
            $stripeObj['stripe_user_id'] = $customer['id'];
            $stripeObj['stripe_payment_id'] = "";
            $stripeObj['stripe_payment_amt'] = "";

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['stripe'] = $stripeObj;
            return $returnedObj;
        }
        catch(\Exception $e){
        //create error log
        $date    = date("Y-m-d H:i:s");
        $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a Payment and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
        LogCustom::create($date,$message);

        $returnedObj['aceplusStatusMessage'] = $e->getMessage();
        return $returnedObj;        }

    }

    //$flag = 1; From Web
    //$flag = 2; From Cron
    public function capturePayment($customerId, $amount){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
//        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $currentUser = Utility::getCurrentCustomerID();
//        $currentUser = "MrTesting";
        try {
            $paymentCurrency = PaymentConstance::STIRPE_CURRENCY;
            $tempStripeObj  = $this->createPaymentObj();
            if($tempStripeObj['aceplusStatusCode'] != ReturnMessage::OK){
                throw new Exception('Error with payment token !!!!');
            }

            $charge = \Stripe\Charge::create(array(
                "amount" => $amount,
                "currency" => $paymentCurrency,
                "customer" => $customerId
            ));
            $stripeObj = array();
            $stripeObj['stripe_user_id'] = $customerId;
            $stripeObj['stripe_payment_id'] = $charge->id;
            $stripeObj['stripe_payment_amt'] = $amount;

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['stripe'] = $stripeObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a Payment and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }

    public function refundPayment($customerId, $amount,$chargeId){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

//        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
//        $currentUser = "MrTesting";

        try {
            $paymentCurrency = PaymentConstance::STIRPE_CURRENCY;
            $tempStripeObj  = $this->createPaymentObj();
            if($tempStripeObj['aceplusStatusCode'] != ReturnMessage::OK){
                throw new Exception('Error with payment token !!!!');
            }

            $refund =  \Stripe\Refund::create(array(
                "charge" => $chargeId,
                "amount" => $amount,
            ));

            $stripeObj = array();
            $stripeObj['stripe_user_id'] = $customerId;
            $stripeObj['stripe_payment_id'] = $chargeId;
            $stripeObj['stripe_payment_amt'] = $amount;

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['stripe'] = $stripeObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a Payment and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }

    }


}