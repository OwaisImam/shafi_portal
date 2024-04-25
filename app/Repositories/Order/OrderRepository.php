<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepository
{
    public function model(): string
    {
        return Order::class;
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

        if (isset($data['order_no'])) {
            $query->where('order_no', 'like', '%' . $data['order_no'] . '%');
        }

        if (isset($data['order_status']) && $data['order_status'] != 'all') {
            $query->where('status', 'like', '%' . $data['order_status'] . '%');
        }

        if (Auth::guard('admin')->user()->hasRole('customer')) {
            $query->where('user_id', Auth::guard('admin')->id());
        }

        $query->orderBy('created_at', 'DESC');

        return $query->paginate($paginationLimit);
    }
}
