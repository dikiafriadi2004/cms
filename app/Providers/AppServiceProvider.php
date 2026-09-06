<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
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
        // Force HTTPS for URL generation in production or when explicitly enabled
        // or when behind proxy/load balancer that terminates SSL (X-Forwarded-Proto: https)
        $forceHttps = env('FORCE_HTTPS', false)
            || config('app.env') === 'production'
            || request()->header('X-Forwarded-Proto') === 'https';

        if ($forceHttps) {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
        
        // Register policies
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Page::class, PagePolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Ad::class, AdPolicy::class);

        // Super-admin bypasses all gates/policies
        Gate::before(function ($user, $ability) {
            if (method_exists($user, 'hasRole') && $user->hasRole('super-admin')) {
                return true;
            }
            return null; // fall through to policy
        });

        // Log failed queue jobs with full context so admin can investigate.
        // Optional: send notification email if BACKUP_NOTIFICATION_EMAIL is set.
        Queue::failing(function (JobFailed $event) {
            Log::error('Queue job failed', [
                'connection' => $event->connectionName,
                'job' => $event->job->resolveName(),
                'exception' => $event->exception->getMessage(),
                'queue' => method_exists($event->job, 'getQueue') ? $event->job->getQueue() : null,
            ]);

            $notifyEmail = env('BACKUP_NOTIFICATION_EMAIL');
            if ($notifyEmail && app()->environment('production')) {
                try {
                    \Illuminate\Support\Facades\Mail::raw(
                        "Queue job failed:\n\n"
                        . "Job: " . $event->job->resolveName() . "\n"
                        . "Connection: " . $event->connectionName . "\n"
                        . "Error: " . $event->exception->getMessage() . "\n\n"
                        . "Trace:\n" . $event->exception->getTraceAsString(),
                        function ($message) use ($notifyEmail) {
                            $message->to($notifyEmail)
                                ->subject('[' . config('app.name') . '] Queue Job Failed');
                        }
                    );
                } catch (\Throwable $e) {
                    Log::error('Failed to send queue failure notification: ' . $e->getMessage());
                }
            }
        });
        
        // Configure mail from database settings — only if the settings table
        // already exists. This prevents fatal errors during fresh install
        // before migrations run.
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                MailConfigService::configure();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // DB not yet available (e.g. install/migrate phase). Log only.
            \Illuminate\Support\Facades\Log::debug(
                'MailConfigService skipped during boot: ' . $e->getMessage()
            );
        }

        // Use Tailwind for pagination
        Paginator::useTailwind();

        // Share global settings with all views (hanya layout views, bukan semua view)
        View::composer(
            ['layouts.*', 'frontend.*', 'admin.*'],
            function ($view) {
                try {
                    $settings = \App\Helpers\SettingsCache::all()->toArray();

                    $headerMenu = \Illuminate\Support\Facades\Cache::remember('menu.header', 3600, function () {
                        return Menu::where('location', 'header')
                            ->where('is_active', true)
                            ->with(['items' => function ($query) {
                                $query->where('is_active', true)
                                    ->whereNull('parent_id')
                                    ->orderBy('sort_order')
                                    ->with([
                                        'children' => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
                                        'page:id,slug,title',
                                        'post:id,slug,title',
                                        'category:id,slug,name',
                                    ]);
                            }])
                            ->first();
                    });

                    $footerMenu = \Illuminate\Support\Facades\Cache::remember('menu.footer', 3600, function () {
                        return Menu::where('location', 'footer')
                            ->where('is_active', true)
                            ->with(['items' => function ($query) {
                                $query->where('is_active', true)
                                    ->whereNull('parent_id')
                                    ->orderBy('sort_order')
                                    ->with([
                                        'page:id,slug,title',
                                        'post:id,slug,title',
                                        'category:id,slug,name',
                                    ]);
                            }])
                            ->first();
                    });

                    $view->with(compact('settings', 'headerMenu', 'footerMenu'));
                } catch (\Illuminate\Database\QueryException $e) {
                    // DB error (e.g. table missing during fresh install).
                    // Log so dev knows but don't crash the view rendering.
                    \Illuminate\Support\Facades\Log::warning(
                        'View composer DB error: ' . $e->getMessage()
                    );
                    $view->with([
                        'settings' => [],
                        'headerMenu' => null,
                        'footerMenu' => null,
                    ]);
                } catch (\Throwable $e) {
                    // Unexpected error — log with full context for debugging.
                    \Illuminate\Support\Facades\Log::error(
                        'View composer unexpected error: ' . $e->getMessage(),
                        ['exception' => $e]
                    );
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