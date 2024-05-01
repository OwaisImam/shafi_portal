<?php

namespace App\Repositories;

use App\Constants\Roles;
use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    public function model(): string
    {
        return Role::class;
    }

    public function getSuperAdminRole(): ?Role
    {
        return $this->model->where('name', 'Super Admin')->first();
    }

    public function findByName(string $name): ?Role
    {
        return $this->model->where('name', $name)->first();
    }
}
