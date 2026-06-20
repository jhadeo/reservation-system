<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['room_id', 'name', 'hourly_rate', 'max_pax', 'photo', 'description', 'room_type_id', 'is_available', 'featured'])]
class Room extends Model
{
    
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'hourly_rate' => 'decimal:2',
            'featured' => 'boolean',
            'is_available' => 'boolean',
            'max_pax' => 'integer',
            'photo' => 'string',
        ];
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
