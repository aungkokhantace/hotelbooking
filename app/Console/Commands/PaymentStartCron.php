<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Setup\HotelConfig\HotelConfig;
use App\Setup\HotelConfig\HotelConfigRepository;
use App\Setup\Booking\BookingRepository;
use App\Core\ReturnMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Setup\Booking\Booking;
use Mail;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use App\Payment\PaymentUtility;

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
        $HotelConfigRepo    = new HotelConfigRepository();
        $hotelsConfigs      = $HotelConfigRepo->getObjs();
        $cronCheckDay       = Carbon::now()->format('Y-m-d');
        $hotel_id           = array();

        foreach($hotelsConfigs as $hotelsConfig) {
            $id                          = $hotelsConfig->id;
            $hotel_id[$id]               = $hotelsConfig->hotel_id;
        }
        $bookingDate                = Booking::select('id','check_in_date','hotel_id','user_id','total_payable_amt')
                                      ->where('status',2)
                                      ->whereIn('hotel_id',$hotel_id)
                                      ->whereNull('deleted_at')->get();                          
        $email_arr                  = array();
        foreach ($bookingDate as $booking) {
            $booking_id                 = $booking->id;
            $user_id                    = $booking->user_id;
            $h_id                       = $booking->hotel_id;
            $check_in_date              = $booking->check_in_date;
            $check_in_date_formatted    = date('Y-m-d', strtotime($check_in_date));
            $first_cancellation_day     = $HotelConfigRepo->getFirstCancellationDayCountHotelConfig($h_id);
            $first_cancellation_day_str = $first_cancellation_day->first_cancellation_day_count;
            $first_cancellation_day_str = "-" . $first_cancellation_day_str . " days";
            $check_cron_run_day         = strtotime($first_cancellation_day_str, strtotime($check_in_date_formatted));
            $check_cron_run_day         = date('Y-m-d', $check_cron_run_day);
            
            if ($check_cron_run_day == $cronCheckDay) {
                $email            = $booking->user->email;
                $hotel_email      = $HotelConfigRepo->getEmailByHotelId($h_id);
                $hotel_email_str  = $hotel_email->email;
                $system_email     = "gentlemanShwekayin@gmail.com";
                $emails           = array($email,$hotel_email_str,$system_email);
                
                //Get Customer ID
                $paramObj         = Booking::find($booking_id);
                $customerId       = $paramObj->booking_stripe->stripe_user_id;
                //Get Payable Amount
                $payable_amount_formatted   = (int)($booking->total_payable_amt);
                $payable_amount             = $payable_amount_formatted * 100;
                //Start Payment
                $flag                       = 2; //From Cron Job
                $paymentObjs                = new PaymentUtility();
                $result                     = $paymentObjs->capturePayment($customerId, $payable_amount);
                if ($result['aceplusStatusCode'] == 200) {
                    $status             = 5;
                    $paramObj->status   = $status;
                    $paramObj->save();
                    Mail::send('booking_payment_first_start', [], function($message) use ($emails)
                    {    
                        $subject        = "Your Payment is Cut Off now.";
                        $message->to($emails)
                                ->subject($subject);    
                    });
                    $message            = "Email have been sent to " . $email . " First Cancellation Start Success!";
                    $this->info($message);
                } else {
                    $message            = "Email have not sent to " . $email . " First Cancellation Start Success!";
                    $this->info($message);
                }
                
            }
            
        }
    }
}
