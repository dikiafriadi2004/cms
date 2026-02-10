<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Menu;
use Illuminate\Pagination\Paginator;
use App\Services\MailConfigService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure mail from database settings
        try {
            MailConfigService::configure();
        } catch (\Exception $e) {
            // Ignore if database is not yet migrated
        }

        // Use Tailwind for pagination
        Paginator::useTailwind();

        // Share global settings with all views
        View::composer('*', function ($view) {
            try {
                $settings = Setting::pluck('value', 'key')->toArray();

                // Get menus
                $headerMenu = Menu::where('location', 'header')->with(['items' => function($query) {
                    $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->with('children');
                }])->first();
                
                $footerMenu = Menu::where('location', 'footer')->with(['items' => function($query) {
                    $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order');
                }])->first();

                $view->with(compact('settings', 'headerMenu', 'footerMenu'));
            } catch (\Exception $e) {
                // Handle case when database is not yet migrated
                $view->with([
                    'settings' => [],
                    'headerMenu' => null,
                    'footerMenu' => null,
                ]);
            }
        });
    }
}