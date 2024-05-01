<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    private PermissionRepository $permissionRepository;
    private UserRepository $userRepository;
    private Request $request;

    public function __construct(PermissionRepository $permissionRepository, Request $request, UserRepository $userRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userRepository->getById($id);

        $permissions = $this->permissionRepository->get();

        return view('admin.permissions.index', compact('permissions', 'user'));
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
    public function update(string $id)
    {
        try {
            $user = User::find($id);
            $data = $this->request->except(['_token', '_method']);
            $user->role->syncPermissions($data['permission']);

            return redirect()->back()->with('success', 'Permissions updated successfully.');

        } catch(\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
