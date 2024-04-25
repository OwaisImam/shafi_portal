<?php

namespace App\Repositories\ActivityLog;

use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Activitylog\Models\Activity;

class ActivityLogRepository extends BaseRepository
{
    public function model(): string
    {
        return Activity::class;
    }

    public function getFilteredRecords($data, $paginationLimit): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (isset($data['date'])) {
            $date = explode(' to ', $data['date']);

            if (count($date) == 1) {
                $query->whereDate('created_at', $date[0]);
            } else {
                $query->whereBetween('created_at', $date);
            }
        }

        return $query->paginate($paginationLimit);
    }
}
