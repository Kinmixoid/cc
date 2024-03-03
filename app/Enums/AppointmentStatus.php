<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Available = 'available';
    case Reserved = 'reserved';
    case Confirmed = 'confirmed';
}
