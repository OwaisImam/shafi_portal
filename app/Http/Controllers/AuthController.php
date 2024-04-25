<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected Request $request;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgetPass', 'resetPass']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
         $validator = Validator::make($this->request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|max:250',
        ]);

        if ($validator->fails()) {
            return JsonResponse::fail($validator->errors()->first(), 400);
        }

        $credentials = $this->request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return JsonResponse::fail("Unauthorized", 401);
        }

        $user = User::where('email', $this->request->email)->first();
        return JsonResponse::respondWithToken('success', 200,$token, $user);

    }

     public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return JsonResponse::fail($validator->errors()->first(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', 'Super Admin')->first();

        $user->assignRole($role);

        $credentials = $this->request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return JsonResponse::fail("Unauthorized", 401);
        }

        if ($user) {
            return JsonResponse::respondWithToken('success', 200, $token, $user);
        }
    }

    public function forgetPass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return JsonResponse::fail($validator->errors()->first(), 400);
        }

        $token_str = Str::random(64);

        try {
            //code...
            $url = env('APP_URL');
            $token = $url."/reset-password/".$token_str;
            Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token_str,
                'created_at' => Carbon::now()
            ]);

            return JsonResponse::success("success");
        } catch (\Throwable $th) {
            return JsonResponse::fail("Something went wrong, please contact support.", 400);
        }
    }

    // reset password
    public function resetPass(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'token' => ['required', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return JsonResponse::fail($validator->errors()->first(), 400);
        }

        try {
            DB::beginTransaction();
            $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

            if(!$updatePassword){
                return JsonResponse::fail('Invalid token.', 400);
            }

            // update users password
            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            // delete old data from database
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
            DB::commit();

            return JsonResponse::success("success");
        } catch (\Throwable $th) {
            DB::rollBack();

            return JsonResponse::fail("Something went wrong, please contact support.", 400);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return JsonResponse::success(auth()->user(), 'Profile fetched successfully');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return JsonResponse::success(null, 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return JsonResponse::respondWithToken('Token refresh successfully', 200, auth()->refresh());
    }

}