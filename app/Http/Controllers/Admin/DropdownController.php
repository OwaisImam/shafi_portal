<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Departments;
use App\Models\Dyeing;
use App\Models\Knitting;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\State;
use Illuminate\Http\Request;

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

       switch($request->type) {
        case 'department':
            $data = Departments::where('status', 1)->get();
        break;
        case 'knitting':
            $data = Knitting::where('status', 1)->get();
        break;
        case 'dyeing':
            $data = Dyeing::where('status', 1)->get();
        break;
        default:
            $data = Departments::where('status', 1)->get();
        break;
       }

        return JsonResponse::success($data, 'Reocords fetched successfully.');
    }

    public function getOrdersByJobID(Request $request)
    {
        $orders = Order::where('job_id', $request->job_id)->get();

        return JsonResponse::success($orders, 'Orders fetched successfully.');
    }

    public function getOrderItemsByOrderID(Request $request)
    {
        $orderItems = OrderItems::whereIN('order_id', $request->order_id)->get();

        return JsonResponse::success($orderItems, 'Order items fetched successfully.');
    }
}
