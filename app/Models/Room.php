<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'hourly_rate', 'max_pax', 'photo', 'description', 'room_type_id', 'is_available'])]
class Room extends Model
{
    protected function casts(): array
    {
        return [
            'hourly_rate' => 'decimal:2',
        ];
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
