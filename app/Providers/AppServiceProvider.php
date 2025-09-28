<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

use App\Model\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $setting_basic = Setting::where('slug', 'basic')->first(); $setting_date = Setting::where('slug', 'date')->first();
        if(!$setting_basic) $setting_basic = collect(); if(!$setting_date) $setting_date = collect();
        View::share('settings', ['basic' => $setting_basic->toArray(), 'date' => $setting_date->toArray()]);
    }
}







