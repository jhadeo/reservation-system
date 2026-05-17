<?php

namespace App\Models;

use App\PaymentMethod;
use App\PaymentStatus;
use App\ReservationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'room_id', 'event_id', 'pax', 'total_amount', 'payment_status', 'status', 'payment_method', 'check_in_datetime', 'check_out_datetime'])]
class Reservation extends Model
{
    protected function casts() : array {
        return[
            'payment_method' => PaymentMethod::class,
            'payment_status' => PaymentStatus::class,
            'status' => ReservationStatus::class,
            'total_amount' => 'decimal:2',
            'check_in_datetime' => 'datetime',
            'check_out_datetime' => 'datetime',
        ];
    }

    public function room() : BelongsTo {
        return $this->belongsTo(Room::class);
    }

    public function event() : BelongsTo {
        return $this->belongsTo(Event::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
