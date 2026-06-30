<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\AccountType;
use App\RegistrationSource;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['first_name', 'last_name', 'phone', 'email', 'password', 'account_type','created_by','registration_source'])]
#[Hidden(['password', 'remember_token', 'account_type'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'account_type' => AccountType::class,
            'registration_source' => RegistrationSource::class,
        ];
    }
    protected $appends = ['full_name'];
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAccountType(): AccountType
    {
        return $this->account_type ?? AccountType::Client;
    }
}
