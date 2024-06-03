<?php

namespace App\Repositories;

use App\Models\TermsOfDelivery;

class TermsOfDeliveryRepository extends BaseRepository
{
    public function model()
    {
        return TermsOfDelivery::class;
    }
}