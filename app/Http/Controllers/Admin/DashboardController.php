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
        $stats = [
            'posts' => [
                'total' => Post::count(),
                'published' => Post::published()->count(),
                'draft' => Post::draft()->count(),
                'scheduled' => Post::scheduled()->count(),
            ],
            'pages' => [
                'total' => Page::count(),
                'published' => Page::published()->count(),
            ],
            'users' => [
                'total' => User::count(),
                'active' => User::active()->count(),
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