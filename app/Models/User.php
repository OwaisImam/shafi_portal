<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasPermissions;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'avatar',
        'status',
        'role_id',
        'phone_number',
        'city_id',
        'date_of_exit',
        'date_of_joining',
        'father_name',
        'cnic',
        'address',
        'is_employee'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDOB(): string
    {
        return $this->dob;
    }

    public function getAddress(): string
    {
        return $this->address;
    }


    public function getDateOfExit(): string
    {
        return $this->date_of_exit;
    }


    public function getDateOfJoining(): string
    {
        return $this->date_of_joining;
    }

    public function getCNIC(): string
    {
        return $this->cnic;
    }

    public function getIsEmployee(): bool
    {
        return $this->is_employee;
    }

    public function getFatherName(): string
    {
        return $this->father_name;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at->format('d-m-Y');
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at->format('d-m-Y');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function profilePicture(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'avatar');
    }


}
