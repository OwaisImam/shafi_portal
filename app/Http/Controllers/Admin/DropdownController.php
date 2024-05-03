<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
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
}
