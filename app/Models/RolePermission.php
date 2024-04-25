<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;

class RolePermission extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'role_permissions';

    protected $fillable = [
        'role_id',
        'route',
        'allowed',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function isAllowed(): bool
    {
        return $this->allowed;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            Role::class,
            'role_id',
            'id'
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll()->useLogName('system')
        ->logOnlyDirty()->dontSubmitEmptyLogs();
    }
}
