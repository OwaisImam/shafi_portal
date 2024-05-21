<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Setting;

class OrderItemRepository extends BaseRepository
{
    public function model()
    {
        return OrderItems::class;
    }

}
