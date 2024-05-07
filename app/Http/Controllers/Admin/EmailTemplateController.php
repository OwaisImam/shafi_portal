<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\EmailTemplateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailTemplateController extends Controller
{
    private EmailTemplateRepository $emailTemplateRepository;
    private Request $request;

    public function __construct(
        Request $request,
        EmailTemplateRepository $emailTemplateRepository
    ) {
        $this->request = $request;
        $this->emailTemplateRepository = $emailTemplateRepository;

        $this->middleware('permission:email_templates-list|email_templates-create|email_templates-edit|email_templates-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:email_templates-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:email_templates-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:email_templates-delete', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $emailTemplates = $this->emailTemplateRepository->all();

        $response = [
           'data' => $emailTemplates,
           'permissions' => Auth::user()->role->permissions,
        ];

        if($this->request->ajax()) {
            return JsonResponse::success($response, 'Templates fetched successfully.');
        }

        return view('admin.email_template.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.email_template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->request->validate([
            'name' => 'required',
            'subject' => 'required',
            'key' => 'required',
            'content' => 'required',
        ]);

        $this->emailTemplateRepository->create($validated);

        return redirect()->route('admin.email_templates.index')->with('success', 'Email template created successfully.');
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
        $emailTemplate = $this->emailTemplateRepository->getById($id);

        return view('admin.email_template.edit', compact('emailTemplate'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {

        $validated = $this->request->validate([
                'name' => 'required',
                'subject' => 'required',
                'content' => 'required',
            ]);

        $this->emailTemplateRepository->updateById($id, $validated);

        return redirect()->route('admin.email_templates.index')->with('success', 'Email template updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->emailTemplateRepository->deleteById($id);

        return redirect()->route('admin.email_templates.index')->with('success', 'Email template deleted successfully.');
    }
}
