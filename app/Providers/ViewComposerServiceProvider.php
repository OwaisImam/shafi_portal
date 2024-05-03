<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {


        view()->composer('*', function ($view) {
            try {
                DB::connection()->getPdo(); // Check if the database connection is available
                $settings = \App\Models\Setting::all(); // Retrieve settings data from the model
                $view->with('settings', $settings);
            } catch (\Exception $e) {
                // Log or handle the exception
                // You can also add more detailed error handling here
                dd($e->getMessage()); // Output the error message for debugging
            }
        });


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
