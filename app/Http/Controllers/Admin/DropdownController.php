<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Count;
use App\Models\Departments;
use App\Models\Dyeing;
use App\Models\Fiber;
use App\Models\Knitting;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\PreProductionPlan;
use App\Models\State;
use App\Models\YarnPurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropdownController extends Controller
{
    public function fetchState(Request $request)
    {
        $data['states'] = State::where('country_id', $request->country_id)->get(['name', 'id']);

        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where('state_id', $request->state_id)->get(['name', 'id']);

        return response()->json($data);
    }

    public function fetchDataByType(Request $request)
    {
        $data = [];

        switch ($request->type) {
            case 'department':
                $data = Departments::where('status', 1)->get();
                break;
            case 'knitting':
                $data = Knitting::where('status', 1)->get();
                break;
            case 'dyeing':
                $data = Dyeing::where('status', 1)->get();
                break;
            case 'fiber':
                $data = Fiber::where('status', 1)->get();
                break;
            case 'count':
                $data = Count::where('status', 1)->get();
                break;
            default:
                $data = Departments::where('status', 1)->get();
                break;
        }

        return JsonResponse::success($data, 'Reocords fetched successfully.');
    }

    public function getOrdersByJobID(Request $request)
    {
        $orders = Order::with(['fabric_construction', 'job', 'order_items.article'])->where('job_id', $request->job_id)->get();

        return JsonResponse::success($orders, 'Orders fetched successfully.');
    }

    public function getOrderDetailsByID(Request $request)
    {
        $order = Order::with(['fabric_construction', 'job', 'order_items.article', 'client'])->where('id', $request->order_id)->first();

        return JsonResponse::success($order, 'Order detauls fetched successfully.');
    }

    public function getOrderItemsByOrderID(Request $request)
    {
        $orderItems = OrderItems::whereIN('order_id', $request->order_id)->get();

        return JsonResponse::success($orderItems, 'Order items fetched successfully.');
    }

    public function getPurchaseOrdersByJobID(Request $request)
    {
        $purchaseOrders = YarnPurchaseOrder::where('job_id', $request->job_id)->get();

        return JsonResponse::success($purchaseOrders, 'Yarn purchase order fetched successfully.');
    }

    public function getPreProductionPlanByOrderID(Request $request)
    {
        $purchaseOrders = PreProductionPlan::with(['order'])->where('job_id', $request->job_id)->get();

        return JsonResponse::success($purchaseOrders, 'Pre production plan fetched successfully.');

    }

    public function getOrderItemsByArticleID(Request $request)
    {
        $orderItems = OrderItems::select('color', DB::raw('SUM(qty) as total_quantity'))
        ->where('order_id', $request->order_id)
        ->whereIn('article_style_no', $request->article_ids)
        ->groupBy('color')
        ->get();

        return JsonResponse::success($orderItems, 'Order items fetched successfully.');
    }
}
