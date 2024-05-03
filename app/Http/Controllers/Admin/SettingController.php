<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    private SettingRepository $settingRepository;
    private Request $request;

    public function __construct(SettingRepository $settingRepository, Request $request)
    {
        $this->settingRepository = $settingRepository;
        $this->request = $request;
    }

    public function systemSettingView()
    {
        return view('admin.settings.system');
    }

    public function envKeyUpdate()
    {
        foreach ($this->request->types as $key => $type) {
            $this->settingRepository->overWriteEnvFile($type, $this->request[$type]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function updateSettings()
    {

        try {
            DB::beginTransaction();

            if($this->request->hasFile('logo_light')) {
                $logoLight = Helper::uploadFile($this->request->logo_light);
                $params['logo_light'] = $logoLight->id;
            }

            if($this->request->hasFile('logo_dark')) {
                $logoDark = Helper::uploadFile($this->request->logo_dark);
                $params['logo_dark'] = $logoDark->id;
            }

            $this->settingRepository->updateSetting($this->request->types, $params);
            DB::commit();
            return redirect()->back()->with('success', 'Settings updated successfully.');
        } catch(\Exception $e) {
            Log::error($e);
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

}
