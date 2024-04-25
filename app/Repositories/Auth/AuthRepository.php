<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends BaseRepository
{
    public function model(): string
    {
        return User::class;
    }

    public function attemptLogin($credentials)
    {
        return Auth::guard('admin')->attempt($credentials, isset($credentials['remember']) ? $credentials['remember'] : false);
    }

    public function getUserByEmail($email): Model|User
    {
        return $this->model->where('email', $email)->first();
    }
}
