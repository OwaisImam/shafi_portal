<?php

namespace App\Repositories\DashboardRepository;

use App\Models\Admin\Lead;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Models\WebsiteSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function getTotalRevenueEarned(): string
    {
        return Invoice::where('status', 'paid')->sum('net_total');
    }

    public function getTotalRevenueStockPercentage()
    {
        $targetRevenue = WebsiteSetting::where('type', 'target_revenue')->first()?->value;

        if ($this->getTotalRevenueEarned() < $targetRevenue) {
            $percentage = "<small class='text-danger fw-medium'><i class='bx bx-down-arrow-alt'></i>" . (($this->getTotalRevenueEarned() / $targetRevenue) * 100) - 100 . '%</small>';
        } elseif ($this->getTotalRevenueEarned() == 0) {
            $percentage = "<small class='text-success fw-medium'><i class='bx bx-up-arrow-alt'></i>0%</small>";
        } else {
            $percentage = "<small class='text-success fw-medium'><i class='bx bx-up-arrow-alt'></i>" . number_format((($targetRevenue / $this->getTotalRevenueEarned()) * 100) + 100, 2) . '%</small>';
        }

        return $percentage;
    }

    public function getTotalOrders($userID = null)
    {
        $query = Order::select();

        if ($userID) {
            $query->where('user_id', $userID);
        }

        return $query->count();
    }

    public function getTotalOrdersMonthWise()
    {
        $ordersPerMonth = Order::select(DB::raw('DATE_FORMAT(created_at, "%b") as month'), DB::raw('COUNT(*) as total'))
               ->groupBy('month')
               ->orderBy('month', 'desc')
               ->get();

        $month = [];
        $total = [];
        foreach ($ordersPerMonth as $key => $order) {
            $month[] = $order->month;
            $total[] = $order->total;

        }
        $data = [
            'month'=>$month,
            'total'=>$total,
        ];

        return $data;

    }

    public function getTotalOrdersWeekWise()
    {

        $ordersPerWeek = Order::select('status', DB::raw('DATE_FORMAT(created_at, "%a") as week_day'), DB::raw('COUNT(*) as total'))
            ->groupBy(['week_day', 'status'])
            ->orderBy('week_day', 'asc')
            ->get();

        $weekdays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $data = [];

        $statuses = $ordersPerWeek->pluck('status')->unique();
        foreach ($statuses as $status) {
            $statusData = [
                'name' => $status,
                'data' => [],
            ];

            foreach ($weekdays as $weekday) {
                $order = $ordersPerWeek->where('week_day', $weekday)->where('status', $status)->first();
                $statusData['data'][] = $order ? $order->total : 0;
            }

            $data[] = $statusData;
        }

        return $data;

    }

    public function getTotalLeads()
    {
        $leads = Lead::select(DB::raw('DATE_FORMAT(created_at, "%b") as month'), DB::raw('COUNT(*) as count'))
        ->groupBy('month')
        ->orderBy('count', 'desc')
        ->get();

        $month = [];
        $count = [];
        foreach ($leads as $key => $lead) {
            $month[] = $lead->month;
            $count[] = $lead->count;
        }

        $targetLeads = WebsiteSetting::where('type', 'target_leads')->first()?->value;

        $total = [
            'average' => ($targetLeads > 0) ? number_format($leads->sum('count') / $targetLeads * 100, 2) : 0,
            'month_count' => $leads->count('month'),
            'total_leads' => array_sum($count),
        ];

        if (isset($targetLeads) && $total['total_leads'] < $targetLeads) {
            $percentage = "<small class='text-danger fw-medium'><i class='bx bx-down-arrow-alt'></i>" . (($total['total_leads'] / $targetLeads) * 100) - 100 . '%</small>';
        } elseif (isset($targetLeads) && $targetLeads > 0) {
            $percentage = "<small class='text-success fw-medium'><i class='bx bx-up-arrow-alt'></i>" . number_format((($targetLeads / $total['total_leads']) * 100) + 100, 2) . '%</small>';
        } else {
            $percentage = "<small class='text-success fw-medium'><i class='bx bx-up-arrow-alt'></i>0%</small>";
        }

        $data = [
            'month'=>$month,
            'count'=>$count,
            'total'=>$total,
            'percentage' => $percentage,
            'target' => WebsiteSetting::where('type', 'target_leads')->first()?->value,
        ];

        return $data;
    }

    public function getCustomersWithHigherAmount()
    {
        $users = User::whereHas('orders', function ($query) {
            $query->where('status', 'ready')
            ->whereHas('invoice', function ($subQuery) {
                $subQuery->whereHas('invoice', function ($subSubQuery) {
                    $subSubQuery->where('net_total', function ($subSubSubQuery) {
                        $subSubSubQuery->selectRaw('MAX(net_total)')
                                    ->from('invoices')
                                    ->where('status', 'paid');
                    });
                });
            });
        })->with(['orders.invoice.invoice' => function ($query) {
            $query->select(['id', 'status', 'net_total', 'payment_method']);
        }])->limit(5)->get(['id', 'name', 'email']);

        return $users;
    }

    public function getTotalCalledCount($userId)
    {
        return Client::where('created_by', $userId)->where('is_called', 1)->count();
    }

    public function getTotalEmailedCount($userId)
    {
        return Client::where('created_by', $userId)->where('is_emailed', 1)->count();
    }

    public function getTotalFollowupCount($userId)
    {
        return Client::where('created_by', $userId)->where('follow_up_call', 1)->count();
    }

    public function getTotalClientsMonthWise()
    {
        $clientsPerMonth = Client::select('status', DB::raw('DATE_FORMAT(created_at, "%Y") as year'), DB::raw('DATE_FORMAT(created_at, "%b") as month'), DB::raw('COUNT(*) as total'))
        ->groupBy('year', 'month', 'status')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        $result = [];

        foreach ($clientsPerMonth as $client) {
            $status = ucwords(str_replace('_', ' ', $client->status));
            $month = $client->month;

            if (!isset($result[$status])) {
                $result[$status] = ['name' => $status, 'data' => array_fill(0, 12, 0)];
            }

            $monthIndex = $this->getMonthIndex($month);
            $result[$status]['data'][$monthIndex] += $client->total;
        }

        return array_values($result);
    }

    private function getMonthIndex($month)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        return array_search($month, $months);
    }

    public function getSalesRep()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'sales representative');
        })->get();
    }

    public function getTotalOrdersByStatus($userID, $status)
    {
        $query = Order::select();

        if ($userID) {
            $query->where('user_id', $userID);
        }

        return $query->where('status', $status)->count();
    }

    public function getTotalInvoiceByStatus($userID, $status)
    {
        $query = Invoice::select();

        if ($userID) {
            $query->where('user_id', $userID);
        }

        return $query->where('status', $status)->count();
    }

    public function getTotalInvoiceAmountByStatus($userID, $status)
    {
        $query = Invoice::select();

        if ($userID) {
            $query->where('user_id', $userID);
        }

        return $query->where('status', $status)->sum('net_total');
    }

    public function getTotalEarningsByPaymentMethod()
    {

        $orders = DB::table('invoices')
        ->select(DB::raw('MONTH(updated_at) as month, SUM(net_total) as total_price, payment_method'))
        ->where('status', 'paid')
        ->whereYear('updated_at', Carbon::today()->year)
        ->groupBy('payment_method', 'month')
        ->get();

        $paymentMethods = ['paypal', 'stripe', 'bank-transfer']; // Define your payment methods

        $responseData = [];

        foreach ($paymentMethods as $paymentMethod) {
            $data = [];

            foreach ($orders as $order) {
                if ($order->payment_method === $paymentMethod) {
                    $data[$order->month - 1] = (float) $order->total_price;
                }
            }

            // Fill in missing months with 0
            for ($i = 0; $i < 12; $i++) {
                if (!isset($data[$i])) {
                    $data[$i] = 0;
                }
            }

            ksort($data); // Sort the data by month

            $responseData[] = ['data' => array_values($data), 'name' => ucwords(str_replace('-', ' ', $paymentMethod))];
        }

        return $responseData;
    }

    public function getTotalEarningsSumByPaymentMethod()
    {
        $invoices = Invoice::selectRaw('sum(net_total) as total_net_total, payment_method')
             ->where('status', 'paid')
             ->whereYear('updated_at', Carbon::today()->year)
             ->groupBy('payment_method')
             ->get()->toArray();

        if (count($invoices) > 0) {
            foreach ($invoices as $invoice) {
                $data[$invoice['payment_method']] = number_format($invoice['total_net_total'] / 1000, 2) . 'k';
            }
        } else {
            $data = [];
        }

        return $data;
    }

    public function getAllSalesRepStats()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'sales representative');
        })->whereHas('clients')->get();
    }

    public function getAllClientsByStatus()
    {
        $currentMonth = now()->month;
        // Get the counts of interested and not interested clients grouped by month
        $clientsByMonth = Client::selectRaw('MONTH(created_at) as month, status, COUNT(*) as total')
            ->whereRaw('MONTH(created_at) BETWEEN ? AND ?', [($currentMonth - 3) % 12 + 1, ($currentMonth + 3) % 12 + 1])
            ->groupBy('month', 'status')
            ->orderBy('month')
            ->get();

        // Initialize arrays to hold data for interested and not interested clients
        $interestedData = [];
        $notInterestedData = [];

        // Loop through the query results to populate the data arrays
        foreach ($clientsByMonth as $client) {
            if ($client->status === 'interested') {
                $interestedData[$client->month] = $client->total > 40 ? 40 : 0;
            } elseif ($client->status === 'not_interested') {
                $notInterestedData[$client->month] = $client->total > 40 ? 40 : 0;
            }
        }

        // Initialize the final response array
        $response = [
            [
                'name' => 'Interested',
                'data' => array_values($interestedData),
            ],
            [
                'name' => 'Not Interested',
                'data' => array_values($notInterestedData),
            ],
        ];

        // Fill in missing months with zero counts
        for ($i = 1; $i <= 7; $i++) {
            if (!isset($interestedData[$i])) {
                $interestedData[$i] = 0;
            }

            if (!isset($notInterestedData[$i])) {
                $notInterestedData[$i] = 0;
            }
        }

        // Sort the arrays by keys (months)
        ksort($interestedData);
        ksort($notInterestedData);

        // Update the response array with the sorted data
        $response[0]['data'] = array_values($interestedData);
        $response[1]['data'] = array_values($notInterestedData);

        // Return the final response
        return $response;
    }

    public function getAllClientsByStatusCounts()
    {
        $interested = Client::where('status', 'interested')->count();
        $notIterested = Client::where('status', 'not_interested')->count();

        return ['interested' => $interested, 'not_interested' => $notIterested];
    }
}
