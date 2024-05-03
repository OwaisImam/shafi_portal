<?php

namespace App\Repositories;

use App\Dtos\UserDto;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function getByEmail(string $email): ?User
    {
        return $this->model
                   ->where('email', $email)
                   ->first();
    }

    public function createNewUserWithRole($data): Model|User
    {
        $role = Role::create(['name' => $data['name']]);
        $data['role_id'] = $role->id;
        $user = parent::create($data);
        $user->assignRole($role);

        return $user;
    }

    public function getByIds($ids)
    {

        return $this->model->whereIn($ids)->get();
    }

    public function update($params)
    {

        if (isset($params['id'])) {
            return $this->model->updateOrCreate([
                'id' => $params['id'],
            ], $params);
        }

        return null;
    }

    public function updatePassword(string $email, string $password): ?User
    {

        $user = $this->model->where('email', $email)->first();

        if (is_null($user)) {
            return null;
        }

        $user->password = Hash::make($password);
        $user->save();

        return $user;

    }

    public function updateUser($data)
    {
        /** @var User $user */
        $user = $this->model->find($data['id']);

        if (is_null($user)) {
            return null;
        }

        $user->update($data);

        $user->markEmailAsVerified();

        return $user;
    }

    public function updateOldPasswordToNewPassword(string $username, string $password): ?User
    {

        $user = $this->model->where('email', $username)->first();

        if (is_null($user)) {
            return null;
        }

        $user = $this->updatePassword($username, $password);

        $user->update([
            'old_password' => null,
            'old_token' => null,
        ]);

        return $user;

    }
}
