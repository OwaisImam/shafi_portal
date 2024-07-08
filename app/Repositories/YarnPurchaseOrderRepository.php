<?php

namespace App\Repositories;

use App\Models\Mill;
use App\Models\YarnPurchaseOrder;

class YarnPurchaseOrderRepository extends BaseRepository
{
    public function model()
    {
        return YarnPurchaseOrder::class;
    }

    public function getYarnPOWhereHasReceiving()
    {
        return $this->model->whereHas('receiving')->with('receiving.yarn_po.order')->get();
    }
}