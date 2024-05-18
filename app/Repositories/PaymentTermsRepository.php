<?php

namespace App\Repositories;

use App\Helper\Helper;
use App\Models\Item;
use App\Models\PaymentTerms;
use App\Models\PurchaseOrder;

class PaymentTermsRepository extends BaseRepository
{
    public function model()
    {
        return PaymentTerms::class;
    }

}
