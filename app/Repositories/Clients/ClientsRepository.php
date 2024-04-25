<?php

namespace App\Repositories\Clients;

use App\Dtos\UserDto;
use App\Models\Client;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ClientsRepository extends BaseRepository
{
    public function model(): string
    {
        return Client::class;
    }

    public function getFilteredRecords($data, $paginationLimit): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (isset($data['date'])) {
            $date = explode(' to ', $data['date']);

            if (count($date) == 1) {
                $query->whereDate('created_at', $date[0]);
            } else {
                $query->whereBetween('created_at', $date);
            }
        } else {
            $query->whereDate('created_at', Carbon::today()->timezone('UTC'));
        }

        if (Auth::user()->hasRole('sales_representative')) {
            $query->where('created_by', Auth::user()->id);
        }

        $query->orderBy('id', 'desc');

        return $query->paginate($paginationLimit);
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

    public function createNewClient(UserDto $userDto): Model|User
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
}
