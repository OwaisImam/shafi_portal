<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Item;
use App\Models\PurchaseOrder;

class PurchaseOrderRepository extends BaseRepository
{
    public function model()
    {
        return PurchaseOrder::class;
    }

}