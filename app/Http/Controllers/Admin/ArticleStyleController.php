<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Repositories\ArticleStyleRepository;
use App\Repositories\DepartmentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ArticleStyleController extends Controller
{
    private ArticleStyleRepository $articleStyleRepository;
    private DepartmentRepository $departmentRepository;
    private Request $request;
    private Departments $department;

    public function __construct(Request $request, ArticleStyleRepository $articleStyleRepository, DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->articleStyleRepository = $articleStyleRepository;
        $this->request = $request;
        $this->department = $this->departmentRepository->getByColumn($this->request->slug, 'slug');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $article = $this->articleStyleRepository->all();

        $response = [
           'data' => $article,
           'permissions' => Auth::user()->role->permissions,
        ];

        if ($this->request->ajax()) {
            return JsonResponse::success($response, 'Article style fetched successfully.');
        }

        $department = $this->department;

        return view('admin.department.article.index', compact('department'));
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
    public function store()
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                  'name' => 'required',
                  'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }

            $this->articleStyleRepository->create($validated);
            DB::commit();

            return redirect()->route('admin.departments.article.index', ['slug' => $this->department->slug])->with('success', 'Article style created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $slug, string $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($this->request->all(), [
                'name' => 'required',
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput();
            }
            $validated = $validator->validated();

            if (!isset($validated['status'])) {
                $validated['status'] = 0;
            }
            $this->articleStyleRepository->updateById($id, $validated);
            DB::commit();

            return redirect()->route('admin.departments.article.index', ['slug' => $this->department->slug])->with('success', 'Article style updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug, string $id)
    {
        try {
            DB::beginTransaction();
            $this->articleStyleRepository->deleteById($id);
            DB::commit();

            if ($this->request->ajax()) {
                return JsonResponse::success(null, 'Article style deleted successfully.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            return JsonResponse::fail('Something went wrong.');
        }
    }
}
