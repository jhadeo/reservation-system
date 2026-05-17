<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name','description', 'hourly_rate'])]
class Event extends Model
{
    protected function casts() : array {
        return ['hourly_rate' => 'decimal:2'];
    }
}
