<?php

namespace App\Repositories;

use App\Models\Process;

class ProcessRepository extends BaseRepository
{
    public function model()
    {
        return Process::class;
    }

    public function getProcessesByPreProductionPlan(string $id)
    {
        return $this->model->where('status', 1)->where('parent_id', null)->orWhere('pre_production_plan_id', $id)->get();

    }
}