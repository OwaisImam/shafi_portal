<?php

namespace App\Repositories\QuotationRequest;

use App\Models\QuotationRequest;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class QuotationRequestRepository extends BaseRepository
{
    public function model(): string
    {
        return QuotationRequest::class;
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

        if (isset($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }

        if (isset($data['email'])) {
            $query->where('email', 'like', '%' . $data['email'] . '%');
        }

        if (!Auth::guard('admin')->user()->hasRole('super_admin')) {
            $query->where('created_by', Auth::guard('admin')->id());
        }

        return $query->paginate($paginationLimit);
    }
}
