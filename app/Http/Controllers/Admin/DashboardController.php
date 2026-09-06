<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Page;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\MediaFile;
use App\Services\GoogleAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $analyticsService;

    public function __construct(GoogleAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index()
    {
        // Single query per model untuk stats — pakai CASE WHEN supaya portable
        // (lebih aman dari `SUM(condition)` yang bergantung pada vendor SQL mode).
        $postStats = Post::selectRaw("
            COUNT(*) AS total,
            SUM(CASE WHEN status = 'published' AND published_at <= NOW() THEN 1 ELSE 0 END) AS published,
            SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) AS draft,
            SUM(CASE WHEN status = 'scheduled' AND published_at > NOW() THEN 1 ELSE 0 END) AS scheduled
        ")->first();

        $pageStats = Page::selectRaw("
            COUNT(*) AS total,
            SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) AS published
        ")->first();

        $userStats = User::selectRaw("
            COUNT(*) AS total,
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) AS active
        ")->first();

        $stats = [
            'posts' => [
                'total' => (int) $postStats->total,
                'published' => (int) $postStats->published,
                'draft' => (int) $postStats->draft,
                'scheduled' => (int) $postStats->scheduled,
            ],
            'pages' => [
                'total' => (int) $pageStats->total,
                'published' => (int) $pageStats->published,
            ],
            'users' => [
                'total' => (int) $userStats->total,
                'active' => (int) $userStats->active,
            ],
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'media' => [
                'total' => MediaFile::count(),
                'size' => MediaFile::sum('file_size'),
            ],
        ];

        // Recent posts
        $recentPosts = Post::with(['user', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        // Popular posts (by views)
        $popularPosts = Post::published()
            ->with(['user', 'category'])
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        // Monthly post statistics
        $monthlyStats = Post::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Google Analytics Data
        $analyticsData = null;
        $analyticsConfigured = $this->analyticsService->isConfigured();
        
        if ($analyticsConfigured) {
            try {
                $analyticsData = $this->analyticsService->getDashboardSummary();
            } catch (\Exception $e) {
                \Log::error('Failed to fetch Google Analytics data: ' . $e->getMessage());
            }
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'popularPosts',
            'monthlyStats',
            'analyticsData',
            'analyticsConfigured'
        ));
    }
}