<?php

namespace App\Repositories\ClientTarget;

use App\Models\ClientTarget;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class ClientTargetRepository extends BaseRepository
{
    public function model(): string
    {
        return ClientTarget::class;
    }

    public function getByCurrentMonth(string $userId): ?ClientTarget
    {
        return $this->model->where('user_id', $userId)->whereMonth('created_at', Carbon::now()->month)->first();
    }
}
