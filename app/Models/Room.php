<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['name', 'hourly_rate', 'max_pax', 'photo', 'description', 'type', 'is_available'])]
class Room extends Model
{
    protected function casts(): array
    {
        return [
            'hourly_rate' => 'decimal:2',
        ];
    }

    public function room_type() : HasOne{
        return $this->hasOne(RoomType::class);
    }

    public function room() : BelongsTo {
        return $this->belongsTo(RoomType::class);
    }
}
