<?php

namespace App\Repositories;

use App\Models\PaymentTerms;

class PaymentTermsRepository extends BaseRepository
{
    public function model()
    {
        return PaymentTerms::class;
    }
}
