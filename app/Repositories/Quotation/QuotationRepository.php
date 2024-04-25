<?php

namespace App\Repositories\Quotation;

use App\Models\Quotation;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class QuotationRepository extends BaseRepository
{
    public function model(): string
    {
        return Quotation::class;
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

        if (isset($data['design_name'])) {
            $query->where('design_name', 'like', '%' . $data['design_name'] . '%');
        }

        if (isset($data['quotation_no'])) {
            $query->where('quotation_no', 'like', '%' . $data['quotation_no'] . '%');
        }

        if (Auth::guard('admin')->user()->hasRole('customer')) {
            $query->where('user_id', Auth::guard('admin')->id());
        }

        if (isset($data['is_requested'])) {
            $query->where('is_requested', 1);
        } else {
            $query->where('is_requested', 0);
        }

        return $query->paginate($paginationLimit);
    }
}
