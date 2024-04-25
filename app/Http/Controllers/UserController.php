<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponse;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserController extends Controller
{
    private Request $request;
    private UserRepository $userRepository;
    private User $user;

    public function __construct(Request $request, UserRepository $userRepository)
    {
        $this->middleware('jwt.verify:api');
        $this->middleware('permission:users-list', ['only' => ['index']]);
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);

        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->user = Auth::guard('api')->user();

    }

    public function index()
    {
        try {
            return $this->userRepository->filteredData($this->request->all(), 10);
        }catch (UnauthorizedException $exception) {
            return JsonResponse::fail($exception->getMessage(), 500);
        } catch(\Exception $e) {
            return JsonResponse::fail($e->getMessage(), 500);
        }
    }
}