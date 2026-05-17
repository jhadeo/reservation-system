<?php

namespace App;

enum PaymentStatus : string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
