<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Ad;
use App\Policies\PostPolicy;
use App\Policies\PagePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\AdPolicy;
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
        // Force HTTPS for URL generation when behind proxy (ngrok, cloudflare, etc)
        if (config('app.env') !== 'local' || request()->header('X-Forwarded-Proto') === 'https') {
            \URL::forceScheme('https');
        }
        
        // Register policies
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Page::class, PagePolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Ad::class, AdPolicy::class);
        
        // Configure mail from database settings
        try {
            MailConfigService::configure();
        } catch (\Exception $e) {
            // Ignore if database is not yet migrated
        }

        // Use Tailwind for pagination
        Paginator::useTailwind();

        // Share global settings with all views (hanya layout views, bukan semua view)
        View::composer(
            ['layouts.*', 'frontend.layouts.*', 'frontend.partials.*', 'admin.*'],
            function ($view) {
                try {
                    $settings = \App\Helpers\SettingsCache::all()->toArray();

                    $headerMenu = \Illuminate\Support\Facades\Cache::remember('menu.header', 3600, function () {
                        return Menu::where('location', 'header')->with(['items' => function($query) {
                            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->with('children');
                        }])->first();
                    });
                    
                    $footerMenu = \Illuminate\Support\Facades\Cache::remember('menu.footer', 3600, function () {
                        return Menu::where('location', 'footer')->with(['items' => function($query) {
                            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order');
                        }])->first();
                    });

                    $view->with(compact('settings', 'headerMenu', 'footerMenu'));
                } catch (\Exception $e) {
                    $view->with([
                        'settings' => [],
                        'headerMenu' => null,
                        'footerMenu' => null,
                    ]);
                }
            }
        );
    }
}