<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Country;
use App\Models\Order;
use App\Models\Setting;

class OrderRepository extends BaseRepository
{
    public function model()
    {
        return Order::class;
    }

}