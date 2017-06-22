<?php

namespace App\Console\Commands;

use App\Setup\Booking\BookingRepository;
use App\Setup\HotelConfig\HotelConfig;
use App\Setup\HotelConfig\HotelConfigRepository;
use Illuminate\Console\Command;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification to confirm Booking before Booking Cancellation Day';

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
            $bookingRepo        = new BookingRepository();
            $confirmBooking     = $bookingRepo->getConfirmBooking();
            $hotelIdArr         = array();
            if(isset($confirmBooking) && count($confirmBooking) > 0){

                foreach($confirmBooking as $booking){
                    array_push($hotelIdArr,$booking->hotel_id);
                }

                $hConfigRepo        = new HotelConfigRepository();
                $hConfig            = $hConfigRepo->getCancellationDayFromHotelConfig($hotelIdArr);

                $this->info(print($hConfig));


            }

        }catch (\Exception $e){

        }
    }
}
