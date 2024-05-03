<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $settings = Setting::all(); // Fetch settings data from the model
        $this->app->instance('settings', $settings);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
