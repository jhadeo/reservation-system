<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'description'])]
class RoomType extends Model
{
    use SoftDeletes;
    
    public function rooms() : HasMany {
        return $this->hasMany(Room::class);
    }
}
