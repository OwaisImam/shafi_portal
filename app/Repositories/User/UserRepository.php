<?php

namespace App\Repositories\User;

use App\Constants\DefaultValues;
use App\Dtos\UserDto;
use App\Helper\JsonResponse;
use App\Models\Role;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserRepository extends BaseRepository
{
    public function model(): string
    {
        return User::class;
    }

    public function filteredData($data, $paginationLimit)
    {
        try{
            $query = User::with('roles');

            if (isset($data['date'])) {
                $date = explode(' to ', $data['date']);

                if (count($date) == 1) {
                    $query->whereDate('created_at', $date[0]);
                } else {
                    $query->whereBetween('created_at', $date);
                }
            }

            if (isset($data['keyword'])) {
                $query->where('name', 'like', '%' . $data['keyword'] . '%');
            }

            if (isset($data['keyword'])) {
                $query->orWhere('email', 'like', '%' . $data['keyword'] . '%');
            }
            $query->orderBy('created_at', 'DESC');

            return JsonResponse::success($query->paginate($paginationLimit), "success");

        } catch(\Exception $e) {
            return JsonResponse::fail($e->getMessage(), 500);
        }

    }

    public function getByEmail(string $email): ?User
    {
        return $this->model
            ->where('email', $email)
            ->first();
    }

    public function updateById($id, array $data, array $options = []): User|Model
    {
        return parent::updateById($id, $data, $options);
    }


    public function createNewUser(UserDto $userDto): Model|User
    {
        return parent::create([
            'name' => $userDto->getName(),
            'email' => $userDto->getEmail(),
            'company_name' => $userDto->getCompanyName(),
            'password' => $userDto->getPassword(),
            'phone_number' => $userDto->getPhoneNumber(),
            'address' => $userDto->getAddress(),
            'email_for_invoice' => $userDto->getEmailForInvoice(),
        ]);
    }

    public function createNewUserWithRole(
        UserDto $userDto,
        int $role
    ): User|Model {
        $user = parent::create([
            'name' => $userDto->getName(),
            'email' => $userDto->getEmail(),
            'company_name' => $userDto->getCompanyName(),
            'password' => $userDto->getPassword(),
            'phone_number' => $userDto->getPhoneNumber(),
            'address' => $userDto->getAddress(),
            'city_id' => $userDto->getCityId(),
            'email_for_invoice' => $userDto->getEmailForInvoice(),
            'status' => DefaultValues::NOTVERIFIED,
        ]);
        $user->assignRole($role);

        return $user;
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

    public function getByIds($ids)
    {
        return $this->model->whereIn($ids)->get();
    }


    public function updatePassword(
        string $email,
        string $password
    ): ?User {
        $user = $this->model->where('email', $email)->first();

        if (is_null($user)) {
            return null;
        }

        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }

    public function updateUser($data): ?User
    {
        /** @var User $user */
        $user = $this->model->find($data['id']);

        if (is_null($user)) {
            return null;
        }

        $user->setStatus($data['status']);
        $user->save();

        $user->markEmailAsVerified();

        return $user;
    }

    public function getAllUsersByRole(Role $role): Collection
    {
        return $this->model->whereHas('roles', function ($query) use ($role) {
            $query->where('id', $role->getId());
        })->get();
    }
}
