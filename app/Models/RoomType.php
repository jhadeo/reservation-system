<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

#[Fillable(['name', 'description'])]
class RoomType extends Model
{
    public function rooms() : HasOneOrMany {
        return $this->hasOneOrMany(Room::class);
    }
}
