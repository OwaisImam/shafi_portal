<?php

namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->middleware('guest')->except('logout');

    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::CLIENT_HOME;

    public function root()
    {
        return view('client.index');
    }

    public function showLoginForm()
    {
        return view('auth.client.login');
    }

    public function login()
    {
        $credentials = $this->request->only('email', 'password');

        if (Auth::guard('client')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('client/dashboard');
        } else {
            // Authentication failed...
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function logout()
    {

        Auth::guard('client')->logout();

        $this->request->session()->invalidate();

        $this->request->session()->regenerateToken();

        return redirect()->route('client.login');

    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = Client::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar = '/images/' . $avatarName;
        }

        $user->update();

        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');

            return response()->json([
                'isSuccess' => true,
                'Message' => 'User Details Updated successfully!',
            ], 200); // Status code here
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');

            return response()->json([
                'isSuccess' => true,
                'Message' => 'Something went wrong!',
            ], 200); // Status code here
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::guard('client')->user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => 'Your Current password does not matches with the password you provided. Please try again.',
            ], 200); // Status code
        } else {
            $user = Client::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();

            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');

                return response()->json([
                    'isSuccess' => true,
                    'Message' => 'Password updated successfully!',
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');

                return response()->json([
                    'isSuccess' => true,
                    'Message' => 'Something went wrong!',
                ], 200); // Status code here
            }
        }
    }
}
