<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Available = 'available';
    case Reserved = 'reserved';
    case Confirmed = 'confirmed';

    public function getColor(): string
    {
        return match ($this) {
            self::Available => 'info',
            self::Reserved => 'gray',
            self::Confirmed => 'success',
        };
    }
}
