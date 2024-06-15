<?php

namespace App\Repositories;

use App\Models\Cartage;
use App\Models\CartageSlip;
use App\Models\State;

class CartageSlipRepository extends BaseRepository
{
    public function model()
    {
        return CartageSlip::class;
    }
}
