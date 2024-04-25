<?php

namespace App\Repositories\Invoice;

use App\Models\Invoice;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class InvoiceRepository extends BaseRepository
{
    public function model(): string
    {
        return Invoice::class;
    }

    public function getUserInvoices($data, $paginationLimit)
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

        if (isset($data['status']) && $data['status'] != 'all') {
            $query->where('status', $data['status']);
        }

        if (isset($data['invoice_no'])) {
            $query->where('invoice_no', 'like', '%' . $data['invoice_no'] . '%');
        }

        if (Auth::guard('admin')->user()->hasRole('customer')) {
            $query->where('user_id', Auth::guard('admin')->id());
        }

        return $query->paginate($paginationLimit);

    }
}
