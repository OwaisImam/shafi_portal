<?php

namespace App\Models;

use App\Notifications\CustomPasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name', 'code', 'city_id', 'logo_id', 'email', 'address', 'password', 'postal_code', 'phone_number', 'website', 'status', 'type', 'label',
    ];

    protected $hidden = [
      'password',
      'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getName(): string
    {
        return $this->name;
    }

    public function logo()
    {
        return $this->belongsTo(Upload::class, 'logo_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordReset($token));
    }
}
