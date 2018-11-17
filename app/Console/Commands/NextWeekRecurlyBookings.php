<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class NextWeekRecurlyBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:fill-next-week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy recurly bookings to the next week';

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
     * @return void
     * @throws \Throwable
     */
    public function handle()
    {
        $bookingsToCopy = Booking::query()
            ->where('status', '!=', Booking::STATUS_CANCELED)
            ->where('is_recurring', 1)
            ->whereBetween('booking_starting_at', [
                now()->startOfWeek(),
                now()->endOfWeek()->setTime(23, 59, 59)
            ])
            ->get();

        foreach ($bookingsToCopy as $booking) {
            /** @var Booking $booking */

            $booking = $booking->replicate(['created_at', 'updated_at']);
            $booking->booking_starting_at = $booking->booking_starting_at->addDays(7);
            $booking->booking_ending_at = $booking->booking_ending_at->addDays(7);
            $booking->saveOrFail();
        }

        $this->alert('Successfully copied ' . $bookingsToCopy->count());
    }
}
