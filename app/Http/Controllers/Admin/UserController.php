<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private UserRepository $userRepository;
    private CityRepository $cityRepository;
    private Request $request;

    public function __construct(UserRepository $userRepository, Request $request, CityRepository $cityRepository)
    {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->request = $request;


        $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userRepository->with(['profilePicture'])->all();

        $response = [
           'data' => $users,
           'permissions' => Auth::user()->role->permissions,
        ];


        if($this->request->ajax()) {
            return JsonResponse::success($response, 'Users fetched successfully.');
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = $this->cityRepository->where('flag', 1)->where('country_id', 167)->get();
        return view('admin.users.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "profile_picture" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                "dob" => "nullable|date",
                'date_of_exit' => 'nullable',
                'date_of_joining' => 'nullable',
                "password" => "required|min:8",
                "confirm_password" => "required|same:password",
                "consent" => "required|accepted",
                'status' => 'nullable|boolean',
                'doe' => 'nullable',
                'city_id' => 'nullable',
                'address' => 'nullable',
                'cnic' => 'nullable',
                'father_name' => 'nullable',
                'is_employee' => 'nullable',
                'phone_number' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $data = $validator->validated();
            $data['password'] = Hash::make($data['password']);

            unset($data['confirm_password']);

            DB::beginTransaction();

            if ($this->request->hasFile('profile_picture')) {
                $profileImage = Helper::uploadFile($this->request->profile_picture);
                $data['avatar'] = $profileImage->id;
            }

            $this->userRepository->createNewUserWithRole($data);

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userRepository->getById($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {

        try {
            $validator = Validator::make($this->request->all(), [
                "name" => "required",
                "email" => ["required",'email', Rule::unique('users')->ignore($id),],
                "profile_picture" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                "dob" => "nullable|date",
                'date_of_exit' => 'nullable',
                'date_of_joining' => 'nullable',
                "password" => "required|min:8",
                "confirm_password" => "required|same:password",
                "consent" => "required|accepted",
                'status' => 'nullable|boolean',
                'doe' => 'nullable',
                'city_id' => 'nullable',
                'address' => 'nullable',
                'cnic' => 'nullable',
                'father_name' => 'nullable',
                'is_employee' => 'nullable',
                'phone_number' => 'required'

            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $data = $validator->validated();

            unset($data['confirm_password']);
            DB::beginTransaction();

            if(isset($data['password'])) {
                $this->userRepository->updatePassword($data['email'], $data['password']);
            }

            unset($data['password']);
            unset($data['consent']);
            $data['status'] = $data['status'] ?? false;
            if ($this->request->hasFile('profile_picture')) {
                $profileImage = Helper::uploadFile($this->request->profile_picture);
                $data['avatar'] = $profileImage->id;
            }

            $data['id'] = $id;

            $this->userRepository->updateUser($data);

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->userRepository->deleteById($id);
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
