<?php

namespace App\Console\Commands;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Console\Command;

class ClearExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-expired-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Appointment::where(AppointmentStatus::Reserved)
            ->where('updated_at', '<', now()->subMinutes(config('appointments.reservation_duration')))
            ->update(['status' => AppointmentStatus::Available, 'customer_id' => null]);
    }
}
