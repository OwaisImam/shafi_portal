<?php

namespace App\Repositories;

use App\Models\Cartage;
use App\Models\CartageSlip;
use App\Models\CartageSlipItem;
use App\Models\State;

class CartageSlipItemRepository extends BaseRepository
{
    public function model()
    {
        return CartageSlipItem::class;
    }
}