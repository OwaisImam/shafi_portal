<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponse;
use App\Models\Clients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class APIController extends Controller
{

    public function storeClients(Request $request)
    {
        try {
          $validator = Validator::make($request->all(), [
            'name' => 'required',
            'website' => 'required',
            'email' => 'nullable',
            'second_email' => 'nullable',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->errors()->first());
        }

        $clients = Clients::create([
            'name' => $request->name,
            'website' => $request->website,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        return $this->sendResponse($clients, "success");

        } catch (\Throwable $th) {
            dd($th->getMessage());
            return $this->sendResponse(400, "Something went wrong, please contact support.");
        }
    }

    public function listClients(Request $request)
    {
        try {
            $clients = new Clients();

            if($request->status != 'all') {
                $clients = $clients->where('status', $request->status);
            }

            $clients = $clients->orderBy("id", "desc")->paginate(10);

            return JsonResponse::success($clients, "success");

        } catch (\Throwable $th) {
            return JsonResponse::fail("Something went wrong, please contact support.", 400);
        }
    }
}