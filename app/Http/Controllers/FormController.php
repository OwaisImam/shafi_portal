<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class FormController extends Controller
{
    public function saveFormState(Request $request)
    {
        $formData = $request->all();
        $userId = auth()->id().$request->form_id; // Or any unique identifier for the form

        // Save to Redis with a key
        Redis::set('form_state:' . $userId, json_encode($formData));

        return response()->json(['status' => 'Form state saved successfully!']);
    }

    // Retrieve form state
    public function getFormState(Request $request)
    {
        $userId = auth()->id().$request->form_id; // Or any unique identifier for the form

        // Get from Redis
        $formState = Redis::get('form_state:' . $userId);

        if ($formState) {
            return response()->json(['form_state' => json_decode($formState, true)]);
        } else {
            return response()->json(['form_state' => null]);
        }
    }
}