<?php

namespace App\Repositories\SubscriberRepository;

use App\Models\Subscriber;
use App\Repositories\BaseRepository;

class SubscriberRepository extends BaseRepository
{
    public function model(): string
    {
        return Subscriber::class;
    }
}
