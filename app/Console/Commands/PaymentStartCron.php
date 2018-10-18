<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Log\LogCustom;
use App\Setup\HotelConfig\HotelConfig;
use App\Setup\HotelConfig\HotelConfigRepository;
use App\Core\ReturnMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Setup\Booking\Booking;
use App\Setup\Booking\BookingRepository;
use App\Setup\BookingRoom\BookingRoom;
use App\Setup\BookingRoom\BookingRoomRepository;
use App\Setup\BookingPayment\BookingPayment;
use App\Setup\BookingPayment\BookingPaymentRepository;
use App\Setup\BookingPaymentStripe\BookingPaymentStripe;
use App\Setup\BookingPaymentStripe\BookingPaymentStripeRepository;
use App\Setup\BookingCancellationDate\BookingCancellationDateRepository;
use Mail;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use App\Payment\PaymentConstance;
// use App\Payment\PaymentUtility;
use App\Payment\CronPaymentUtility;
use App\Core\Utility;
use App\Setup\Hotel\Hotel;

class PaymentStartCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:payment';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job For Sending Email and Payment';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $HotelConfigRepo    = new HotelConfigRepository();
            $bookingCancellationDateRepo = new BookingCancellationDateRepository();

            $hotelsConfigs      = $HotelConfigRepo->getObjs();
            $cronCheckDay       = Carbon::now()->format('Y-m-d');
            $hotel_id           = array();
            foreach($hotelsConfigs as $hotelsConfig) {
                $id                          = $hotelsConfig->id;
                $hotel_id[$id]               = $hotelsConfig->hotel_id;
            }
            /*
            $bookingDate                     = Booking::select('id','check_in_date','hotel_id','user_id','total_payable_amt')
                                                        ->where('status',2)
                                                        ->whereIn('hotel_id',$hotel_id)
                                                        ->whereNull('deleted_at')->get();*/
            $bookingDate                        = Booking::where('status',2)->whereIn('hotel_id',$hotel_id)->whereNull('deleted_at')->get();

            $bookingRooms                       = BookingRoom::where('status',2)->get();

            $bookingPayments                    = BookingPayment::where('status',2)->get();

            $paymentStripes                     = BookingPaymentStripe::where('status',1)->get();

            $email_arr                          = array();
            foreach ($bookingDate as $booking) {
              DB::beginTransaction();
                $booking_id                 = $booking->id;
                $user_id                    = $booking->user_id;
                $h_id                       = $booking->hotel_id;
                $check_in_date              = $booking->check_in_date;

                $check_in_date_formatted    = date('Y-m-d', strtotime($check_in_date));

                //get first cancellation day count from hotel config
                $first_cancellation_day     = $HotelConfigRepo->getFirstCancellationDayCountHotelConfig($h_id);

                //get first cancellation day count from booking (that was defined when booking was made)
                // $first_cancellation_day     = $HotelConfigRepo->getFirstCancellationDayCountHotelConfig($h_id);
                $first_cancellation_day = $bookingCancellationDateRepo->getObjByBookingId($booking_id);

                $first_cancellation_day_str = $first_cancellation_day->first_cancellation_day_count;

                $first_cancellation_day_str = "-" . $first_cancellation_day_str . " days";
                $check_cron_run_day         = strtotime($first_cancellation_day_str, strtotime($check_in_date_formatted));
                $check_cron_run_day         = date('Y-m-d', $check_cron_run_day);

                // $cronCheckDay is today
                if ($check_cron_run_day == $cronCheckDay) {
                    /*
                    //Get Customer ID
                    $paramObj                   = Booking::find($booking_id);
                    $customerId                 = $paramObj->booking_stripe->stripe_user_id;

                    //Get Payable Amount
                    $payable_amount_formatted   = (int)($booking->total_payable_amt);
                    $payable_amount             = $payable_amount_formatted * 100;
                    //Start Payment
                    $flag                       = 2; //From Cron Job
                    $paymentObjs                = new CronPaymentUtility();
                    $result                     = $paymentObjs->capturePayment($customerId, $payable_amount);

                    DB::beginTransaction();
                    foreach($bookingRooms as $bookingRoom){
                        $bookingRoom_b_id = $bookingRoom->booking_id;
                        if($bookingRoom_b_id == $booking->id){
                            $bookingRoomObj = BookingRoom::find($bookingRoom_b_id);

                            $bookingRoomStatus = 5;
                            $bookingRoomObj->status = $bookingRoomStatus;
                            $bookingRoomObj->save();
                        }
                    }
                    // DB::commit();

                    foreach($bookingPayments as $bookingPayment){
                        $bookingPayment_b_id = $bookingPayment->booking_id;
                        if($bookingPayment_b_id == $booking->id){
                            $bookingPaymentObj = BookingPayment::find($bookingPayment_b_id);

                            $bookingPaymentStatus = 5;
                            $bookingPaymentObj->status = $bookingPaymentStatus;
                            $bookingPaymentObj->save();
                        }
                    }

                    foreach($paymentStripes as $paymentStripe){
                        $paymentStripe_b_id = $paymentStripe->booking_id;
                        if($paymentStripe_b_id == $booking->id){
                            $stripe_payment_id = $result['stripe']['stripe_payment_id'];
                            $transactionId = $result['stripe']['stripe_balance_transaction'];
                            $stripeResult = $paymentObjs->retrieveBalance($transactionId);
                            $paymentStripeObj = BookingPaymentStripe::find($paymentStripe_b_id);
                            $paymentStripeObj->stripe_payment_id = $stripeResult['stripe']['stripe_payment_id'];
                            $paymentStripeObj->stripe_balance_transaction = $stripeResult['stripe']['stripe_balance_transaction'];
                            $paymentStripeObj->stripe_payment_net = $stripeResult['stripe']['stripe_payment_net'];
                            $paymentStripeObj->stripe_payment_fee = $stripeResult['stripe']['stripe_payment_fee'];
                            $paymentStripeObj->stripe_payment_amt = $stripeResult['stripe']['stripe_payment_amt'];
                            $paymentStripeObj->save();
                        }
                    }

                    if ($result['aceplusStatusCode'] == 200) {
                        $status             = 5;
                        $paramObj->status   = $status;
                        $paramObj->save();
                        DB::commit();

                        Mail::send('booking_payment_first_start', [], function($message) use ($emails)
                        {
                            $subject        = "Your Payment is Cut Off now.";
                            $message->to($emails)
                                    ->subject($subject);
                        });
                        $message            = "Email have been sent to " . $email . " First Cancellation Start Success!";
                        $this->info($message);
                    } else {
                        DB::rollback();
                        $message            = "Email have not sent to " . $email . " First Cancellation Start Success!";
                        $this->info($message);
                    }*/

                    /***** START *****/
                    /*
                    $email                                  = $booking->user->email;
                    $hotel_email                            = $HotelConfigRepo->getEmailByHotelId($h_id);
                    $hotel_email_str                        = $hotel_email->email;
                    $system_email                           = "testingmps2017@gmail.com";
                    $emails                                 = array($email,$hotel_email_str,$system_email);
                    */

                    // Get booking id
                    $booking_id                             = $booking->id;
                    // Get stripe user id
                    $customerId                             = $booking->booking_stripe->stripe_user_id;
                    $payable_amount                         = $booking->total_payable_amt;
                    $paymentObjs                            = new CronPaymentUtility();
                    $paymentStripeRepo                      = new BookingPaymentStripeRepository();
                    $bookPaymentRepo                        = new BookingPaymentRepository();
                    $bookRoomRepo                           = new BookingRoomRepository();
                    $bookingRepo                            = new BookingRepository();
                    // Capture Payment
                    $result                                 = $paymentObjs->capturePayment($customerId, $payable_amount);

                    // start email array
                    $user_email                             = $booking->user->email;
                    $hotel                                  = Hotel::find($h_id);
                    $hotel_email                            = $hotel->email;
                    $emails                                 = array($user_email,$hotel_email);
                    $system_email                           = Utility::getSystemAdminMail();

                    if(isset($system_email) && count($system_email) > 0){
                        foreach($system_email as $s_email){
                            array_push($emails,$s_email);
                        }
                    }
                    // end email array

                    if($result["aceplusStatusCode"] !== ReturnMessage::OK){
                      if(isset($result['stripeDeclineCode']) && $result['stripeDeclineCode'] == 'insufficient_funds') {
                        //payment failed because the card has insufficient funds
                        //cancel the booking so that the booked rooms are available again

                        /* Start booking cancel operation */

                            /* START changing status for booking */
                            $booking->status                        = 3; //cancel
                            $booking->booking_cancel_reason         = "Insufficient Funds in Card";
                            $result                                 = $bookingRepo->update($booking,$cron_flag = 1);

                            if($result['aceplusStatusCode'] !== ReturnMessage::OK){
                                DB::rollback();
                                exit($result["aceplusStatusMessage"]);
                            }
                            /* END changing status for booking */
                            /* START changing status for booking room */
                            $bookRooms                              = $bookRoomRepo->getBookingRoomByBookingId($id);
                            foreach($bookRooms as $bRoom){
                                $bRoom->status                      = 3;
                                $bRoomResult                        = $bookRoomRepo->update($bRoom,$cron_flag = 1);

                                if($bRoomResult['aceplusStatusCode'] != ReturnMessage::OK){
                                    DB::rollback();

                                }
                            }
                            /* END changing status for booking room */

                            // log for cancelling booking because of insufficient funds in card
                            $date     = date('Y-m-d H:i:s');
                            $message  = '['. $date .'] '. 'info: booking number = '.$booking->booking_no.' is cancelled due to insufficient funds when payment is captured by Stripe.'. PHP_EOL;
                            LogCustom::createCronLog($date,$message);

                            /* START send mail */
                            // $user_email                             = $booking->user->email;
                            // $hotel                                  = Hotel::find($h_id);
                            // $hotel_email                            = $hotel->email;
                            // $emails                                 = array($user_email,$hotel_email);
                            // $system_email                           = Utility::getSystemAdminMail();
                            //
                            // if(isset($system_email) && count($system_email) > 0){
                            //     foreach($system_email as $s_email){
                            //         array_push($emails,$s_email);
                            //     }
                            // }

                            //Send Mail to Customer,SystemAdmin,HotelAdmin
                            $mailTemplate                           = 'frontend.mail.cancel_mail';
                            $subject                                = 'Booking Cancellation';
                            $logMessage                             = 'update the booking id - '.$id;
                            $returnState                            = Utility::sendMail($mailTemplate,$emails,$subject,$logMessage);

                            if($returnState['aceplusStatusCode'] == ReturnMessage::OK){
                                $response['aceplusStatusCode']      = '200';
                                $response['param']                  = $booking->id;
                            }
                            else{
                                $response['aceplusStatusCode']      = '503';
                                $response['param']                  = $booking->id;
                            }
                            /* END send mail */

                        /* End booking cancel operation */
                      }

                      //stop and exit
                      exit($result["aceplusStatusMessage"]);
                    }

                    $stripe_card_brand                      = $result['stripe']['card_brand'];
                    $stripe_card_type                       = $result['stripe']['card_type'];
                    $stripe_balance_transaction             = $result['stripe']['stripe_balance_transaction'];
                    $stripe_payment_amount                  = $result['stripe']['stripe_payment_amt'];
                    $stripe_payment_id                      = $result['stripe']['stripe_payment_id'];

                    // Retrieve Balance
                    $balanceResult                          = $paymentObjs->retrieveBalance($stripe_balance_transaction);
                    $stripe_payment_amt_balance             = $balanceResult['stripe']['stripe_payment_amt'];
                    $stripe_payment_net_balance             = $balanceResult['stripe']['stripe_payment_net'];
                    $stripe_payment_fee_balance             = $balanceResult['stripe']['stripe_payment_fee'];


                    // Update booking_payment_stripe
                    $stripeObj                              = BookingPaymentStripe::where('booking_id',$booking_id)->first();
                    $stripeObj->stripe_payment_id           = $stripe_payment_id;
                    $stripeObj->stripe_balance_transaction  = $stripe_balance_transaction;
                    $stripeObj->stripe_payment_net          = $stripe_payment_net_balance;
                    $stripeObj->stripe_payment_fee          = $stripe_payment_fee_balance;
                    $stripeObj->stripe_payment_amt          = $stripe_payment_amt_balance;
                    $stripeObj->status                      = 2;
                    $stripeResult                           = $paymentStripeRepo->update($stripeObj,$cron_flag = 1);

                    // Update booking_payment
                    $paymentObj                             = BookingPayment::where('booking_id',$booking_id)->first();
                    $paymentObj->payment_amount_w_tax       = $stripe_payment_net_balance;
                    $paymentObj->payment_gateway_tax_amt    = $stripe_payment_fee_balance;
                    $paymentObj->status                     = 5;
                    $paymentResult                          = $bookPaymentRepo->update($paymentObj,$cron_flag = 1);

                    // Update booking room
                    foreach($bookingRooms as $bRoom){
                        if($bRoom->booking_id == $booking->id){
                            $bRoom->status                  = 5;
                            $bRoomResult                    = $bookRoomRepo->update($bRoom,$cron_flag = 1);
                        }
                    }

                    // Update booking
                    $stripe_fee_default_cent                = PaymentConstance::STRIPE_FEE_FIXED;
                    $booking->stripe_fee_default_cent       = $stripe_fee_default_cent;
                    $booking->total_stripe_fee_percent      = $stripe_payment_fee_balance-$stripe_fee_default_cent;
                    $booking->total_stripe_fee_amt          = $stripe_payment_fee_balance;
                    $booking->total_stripe_net_amt          = $stripe_payment_net_balance;
                    $booking->total_vendor_net_amt          = $stripe_payment_net_balance;
                    $booking->card_brand                    = $stripe_card_brand;
                    $booking->card_type                     = $stripe_card_type;
                    $booking->status                        = 5;
                    $bookingResult                          = $bookingRepo->update($booking,$cron_flag = 1);

                     //if payment cron started successful, then create date and message for PaymentStartCron log
                    $date     = date('Y-m-d H:i:s');
                    $message  = '['. $date .'] '. 'info: ' . 'Cron Job For Sending Email and Payment run successfully'.PHP_EOL;
                    LogCustom::createCronLog($date,$message);

                    DB::commit();
                    // Send Email
                    Mail::send('booking_payment_first_start', [], function($message) use ($emails)
                    {
                        $subject                            = "Your Payment is Cut Off now.";
                        $message->to($emails)
                                ->subject($subject);
                    });
                    $message                                = "For booking id : ".$booking_id.", first cancellation payment by Cron Job is successful!";
                    $this->info($message);
                    /***** END *****/

                }

            }
        }
        catch(\Exception $e){
            $this->info('Error');
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Cron run payment schedule and got error -------'.$e->getMessage(). ' ----- line ' .
                                                  $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::createCronLog($date,$message);
            $this->info($message);
        }
    }
}
