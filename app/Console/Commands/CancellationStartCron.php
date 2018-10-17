<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Setup\HotelConfig\HotelConfig;
use App\Setup\HotelConfig\HotelConfigRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Setup\Booking\Booking;
use Mail;
use App\Log\LogCustom;
use App\Setup\BookingCancellationDate\BookingCancellationDateRepository;
use App\Core\Utility;

class CancellationStartCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job For Sending Email before 2 days of cancellation start';

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

            // $bookingDate                = Booking::select('check_in_date','hotel_id','user_id')
            //                               ->whereIn('hotel_id',$hotel_id)
            //                               ->where('status',2)
            //                               ->whereNull('deleted_at')->get();

            $bookingDate                   = Booking::where('status',2)->whereIn('hotel_id',$hotel_id)->whereNull('deleted_at')->get();

            $email_arr                  = array();

            foreach ($bookingDate as $booking) {
                $booking_id                 = $booking->id;
                $user_id                    = $booking->user_id;
                $h_id                       = $booking->hotel_id;
                $check_in_date              = $booking->check_in_date;
                $check_in_date_formatted    = date('Y-m-d', strtotime($check_in_date));
                $first_cancellation_day     = $HotelConfigRepo->getFirstCancellationDayCountHotelConfig($h_id);

                $first_cancellation_day = $bookingCancellationDateRepo->getObjByBookingId($booking_id);

                // $first_cancellation_day_str = $first_cancellation_day->first_cancellation_day_count + 1;

                $first_cancellation_day_str = $first_cancellation_day->first_cancellation_day_count + 2;

                $first_cancellation_day_str = "-" . $first_cancellation_day_str . " days";
                $check_cron_run_day         = strtotime($first_cancellation_day_str, strtotime($check_in_date_formatted));
                $check_cron_run_day         = date('Y-m-d', $check_cron_run_day);
                if ($check_cron_run_day == $cronCheckDay) {
                    $email            = $booking->user->email;
                    $hotel_email      = $HotelConfigRepo->getEmailByHotelId($h_id);
                    $hotel_email_str  = $hotel_email->email;
                    // $system_email     = "gentlemanShwekayin@gmail.com";

                    $emails           = array($email,$hotel_email_str);
                    $system_email     = Utility::getSystemAdminMail();

                    // $emails           = array($email,$hotel_email_str,$system_email);

                    if(isset($system_email) && count($system_email) > 0){
                        foreach($system_email as $s_email){
                            array_push($emails,$s_email);
                        }
                    }

                    //if cancellation cron started successful, then create date and message for CancellationCron log
                    $date     = date('Y-m-d H:i:s');
                    $message  = '['. $date .'] '. 'info: ' . 'Cron Job For For Sending Email before 1 days of cancellation start run successfully'.PHP_EOL;

                    LogCustom::create($date,$message);

                    Mail::send('booking_cancellation_start', [], function($message) use ($emails)
                    {
                        $subject        = "Tomorrow is First Cancellation Start Date";
                        $message->to($emails)
                                ->subject($subject);
                    });
                    $message            = "Email have been sent to " . $email . " First Cancellation Start Success!";
                    $this->info($message);
                }

            }

        }
        catch(\Exception $e){
            $this->info('Error');
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Cron run cancellation and got error -------'.$e->getMessage(). ' ----- line ' .
                                                  $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);
        }
    }
}
