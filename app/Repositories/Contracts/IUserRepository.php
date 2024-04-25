<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

interface IUserRepository extends RepositoryContract
{
    public function getByEmail(string $email): ?User;

    public function create(array $data): Model|User;

    public function getByIds($ids);

    public function update($params);

    public function updatePassword(string $email, string $password): ?User;

    public function updateUser($data);

    public function updateOldPasswordToNewPassword(string $username, string $password): ?User;

    public function logoutOldUser(User $user): bool;
}
