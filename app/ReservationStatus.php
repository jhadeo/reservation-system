<?php

namespace App;

enum ReservationStatus: string
{
    case Pending = 'pending';
    case Reserved = 'reserved';
    case Active = 'active';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
