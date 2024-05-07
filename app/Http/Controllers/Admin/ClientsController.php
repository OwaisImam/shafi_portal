<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Mail\ClientLoginCredentials;
use App\Repositories\CityRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientsController extends Controller
{
    private ClientRepository $clientRepository;
    private CountryRepository $countryRepository;
    private Request $request;

    public function __construct(ClientRepository $clientRepository, Request $request, CountryRepository $countryRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->countryRepository = $countryRepository;
        $this->request = $request;


        $this->middleware('permission:clients-list|clients-create|clients-edit|clients-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:clients-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:clients-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:clients-delete', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return view('contacts-list');

        $clients = $this->clientRepository->with(['logo', 'city.state.country'])->all();


        $response = [
           'data' => $clients,
           'permissions' => Auth::user()->role->permissions,
        ];


        if($this->request->ajax()) {
            return JsonResponse::success($response, 'Clients fetched successfully.');
        }

        $countries = $this->countryRepository->where('flag', 1)->get();

        return view('admin.clients.index', compact('countries'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.clients.create', compact('countries'));
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
                "logo" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                'status' => 'nullable|boolean',
                'city_id' => 'nullable',
                'address' => 'nullable',
                'postal_code' => 'required',
                'phone_number' => 'required',
                'website' => 'nullable',
                'type' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $data = $validator->validated();

            DB::beginTransaction();

            if ($this->request->hasFile('logo')) {
                $logo = Helper::uploadFile($this->request->logo);
                $data['logo_id'] = $logo->id;
                unset($data['logo']);
            }

            $client =  $this->clientRepository->create($data);

            DB::commit();
            return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        try {
            $validator = Validator::make($this->request->all(), [
                "name" => "required",
                "email" => ["required",'email', Rule::unique('clients')->ignore($id),],
                "logo" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                'status' => 'nullable|boolean',
                'city_id' => 'nullable',
                'address' => 'nullable',
                'postal_code' => 'required',
                'phone_number' => 'required',
                'website' => 'nullable',
                'type' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $data = $validator->validated();

            DB::beginTransaction();

            if ($this->request->hasFile('logo')) {
                $logo = Helper::uploadFile($this->request->logo);
                $data['logo_id'] = $logo->id;
                unset($data['logo']);
            }

            $this->clientRepository->updateById($id, $data);

            DB::commit();
            return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
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
            $this->clientRepository->deleteById($id);
            DB::commit();

            $clients = $this->clientRepository->with(['logo', 'city.state.country'])->all();

            $response = [
               'data' => $clients,
               'permissions' => Auth::user()->role->permissions,
            ];


            if($this->request->ajax()) {
                return JsonResponse::success($response, 'Clients deleted successfully.');
            }

        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return JsonResponse::fail('Something went wrong.');
        }
    }

    public function generateCredentials(string $id)
    {
        try {
            DB::beginTransaction();
            $client = $this->clientRepository->getById($id);
            $string = Helper::generateRandomString();
            $client->update([
                'password' => Hash::make($string)
            ]);

            $mail = new ClientLoginCredentials($client, $string);
            Mail::to($client->email)->send($mail);

            DB::commit();
            return redirect()->route('admin.clients.index')->with('success', 'Client credentials generated successfully.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
