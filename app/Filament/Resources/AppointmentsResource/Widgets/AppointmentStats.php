<?php

namespace App\Filament\Resources\AppointmentsResource\Widgets;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppointmentStats extends BaseWidget
{
    protected function getStats(): array
    {
        $available = Appointment::where('status', AppointmentStatus::Available)->count();
        $confirmed = Appointment::where('status', AppointmentStatus::Confirmed)->count();

        return [
            Stat::make('Available', $available),
            Stat::make('Confirmed', $confirmed.' ('.round(($confirmed / ($available + $confirmed) * 100)).'%)'),
        ];
    }
}
