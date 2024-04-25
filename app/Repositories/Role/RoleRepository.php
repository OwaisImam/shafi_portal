<?php

namespace App\Repositories\Role;

use App\Constants\Roles;
use App\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    public function model(): string
    {
        return Role::class;
    }

    public function getCustomerRole(): ?Role
    {
        return $this->model->where('name', Roles::CUSTOMER)->first();
    }

    public function getAdminRole(): ?Role
    {
        return $this->model->where('name', Roles::ADMIN)->first();
    }

    public function getSuperAdminRole(): ?Role
    {
        return $this->model->where('name', Roles::SUPER_ADMIN)->first();
    }

    public function findByName(string $name): ?Role
    {
        return $this->model->where('name', $name)->first();
    }
}
