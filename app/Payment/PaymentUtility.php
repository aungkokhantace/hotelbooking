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
            $token          = $ParamData['stripeToken'];
            $email          = $ParamData['stripeEmail'];

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
            $stripeObj['stripe_user_id']        = $customer['id'];
            $stripeObj['stripe_payment_id']     = "";
            $stripeObj['stripe_payment_amt']    = "";

            $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;
            $returnedObj['stripe']              = $stripeObj;
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

        //multiply amount with 100 for stripe
        $actual_amount = $amount*100;

        try {
            $paymentCurrency = PaymentConstance::STIRPE_CURRENCY;
            $tempStripeObj  = $this->createPaymentObj();
            if($tempStripeObj['aceplusStatusCode'] != ReturnMessage::OK){
                throw new Exception('Error with payment token !!!!');
            }

            $charge = \Stripe\Charge::create(array(
                "amount" => $actual_amount,
                "currency" => $paymentCurrency,
                "customer" => $customerId
            ));
           
            $stripeObj = array();
            $stripeObj['stripe_user_id']                = $customerId;
            $stripeObj['stripe_payment_id']             = $charge->id;
//            $stripeObj['stripe_payment_amt'] = $amount;
            $stripeObj['stripe_payment_amt']            = $charge->amount/100;
            $stripeObj['stripe_balance_transaction']    = $charge->balance_transaction;
            $stripeObj['card_brand']                    = $charge->source->brand;
            $stripeObj['card_type']                     = $charge->source->funding;
            
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

        //multiply amount with 100 for stripe
        $actual_amount = $amount*100;

        try {
            $paymentCurrency = PaymentConstance::STIRPE_CURRENCY;
            $tempStripeObj  = $this->createPaymentObj();
            if($tempStripeObj['aceplusStatusCode'] != ReturnMessage::OK){
                throw new Exception('Error with payment token !!!!');
            }

            $refund =  \Stripe\Refund::create(array(
                "charge" => $chargeId,
                "amount" => $actual_amount,
            ));

            $stripeObj                                  = array();
            $stripeObj['stripe_user_id']                = $customerId;
            $stripeObj['stripe_payment_id']             = $chargeId;
            $stripeObj['stripe_payment_amt']            = $refund->amount/100;
            $stripeObj['stripe_balance_transaction']    = $refund->balance_transaction;
            $stripeObj['stripe_refund_status']          = $refund->status;

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

    public function refundPaymentByHotelAdmin($customerId, $amount,$chargeId){

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
//        $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
//        $currentUser = "MrTesting";

        //multiply amount with 100 for stripe
        $actual_amount = $amount*100;

        try {
            $paymentCurrency = PaymentConstance::STIRPE_CURRENCY;
            $tempStripeObj  = $this->createPaymentObj();
            if($tempStripeObj['aceplusStatusCode'] != ReturnMessage::OK){
                throw new Exception('Error with payment token !!!!');
            }

            $refund =  \Stripe\Refund::create(array(
                "charge" => $chargeId,
                "amount" => $actual_amount,
            ));

            /*
            $stripeObj = array();
            $stripeObj['stripe_user_id'] = $customerId;
            $stripeObj['stripe_payment_id'] = $chargeId;
            $stripeObj['stripe_payment_amt'] = $amount;*/

            $stripeObj                                  = array();
            $stripeObj['stripe_user_id']                = $customerId;
            $stripeObj['stripe_payment_id']             = $chargeId;
            $stripeObj['stripe_payment_amt']            = $refund->amount/100;
            $stripeObj['stripe_balance_transaction']    = $refund->balance_transaction;
            $stripeObj['stripe_refund_status']          = $refund->status;

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

    public function retrieveBalance($transactionId){
        $returnedObj                                    = array();
        $returnedObj['aceplusStatusCode']               = ReturnMessage::INTERNAL_SERVER_ERROR;
//        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $currentUser                                    = Utility::getCurrentCustomerID();

        try {
            $paymentCurrency                            = PaymentConstance::STIRPE_CURRENCY;
            $tempStripeObj                              = $this->createPaymentObj();
            if($tempStripeObj['aceplusStatusCode'] != ReturnMessage::OK){
                throw new Exception('Error with payment token !!!!');
            }

            // Retrieve stripe balance info.
            $balance                                    = \Stripe\BalanceTransaction::retrieve($transactionId);
            $stripeObj                                  = array();
            $stripeObj['stripe_balance_transaction']    = $balance->id;
            $stripeObj['stripe_payment_id']             = $balance->source;
            $stripeObj['stripe_payment_amt']            = $balance->amount/100;
            $stripeObj['stripe_payment_fee']            = $balance->fee/100;
            $stripeObj['stripe_payment_net']            = $balance->net/100;


            $returnedObj['aceplusStatusCode']           = ReturnMessage::OK;
            $returnedObj['stripe']                      = $stripeObj;
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