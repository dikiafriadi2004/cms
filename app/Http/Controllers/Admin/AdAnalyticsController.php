<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdAnalytic;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdAnalyticsController extends Controller
{
    /**
     * Display ads analytics dashboard
     */
    public function index(Request $request)
    {
        $dateRange = $request->get('range', '7'); // 7, 30, 90 days
        $startDate = Carbon::now()->subDays($dateRange)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Get all ads with analytics
        $ads = Ad::withCount([
            'analytics as impressions_count' => function ($query) use ($startDate, $endDate) {
                $query->impressions()->whereBetween('event_date', [$startDate, $endDate]);
            },
            'analytics as clicks_count' => function ($query) use ($startDate, $endDate) {
                $query->clicks()->whereBetween('event_date', [$startDate, $endDate]);
            }
        ])->get()->map(function ($ad) {
            $ad->ctr = $ad->impressions_count > 0 
                ? round(($ad->clicks_count / $ad->impressions_count) * 100, 2) 
                : 0;
            return $ad;
        });

        // Overall stats
        $totalImpressions = AdAnalytic::impressions()
            ->whereBetween('event_date', [$startDate, $endDate])
            ->count();
        
        $totalClicks = AdAnalytic::clicks()
            ->whereBetween('event_date', [$startDate, $endDate])
            ->count();
        
        $overallCtr = $totalImpressions > 0 
            ? round(($totalClicks / $totalImpressions) * 100, 2) 
            : 0;

        // Top performing ads
        $topAds = $ads->sortByDesc('clicks_count')->take(5);

        // Daily stats for chart (last 7 days)
        $dailyStats = $this->getDailyStatsForAllAds(7);

        return view('admin.ads.analytics.index', compact(
            'ads',
            'totalImpressions',
            'totalClicks',
            'overallCtr',
            'topAds',
            'dailyStats',
            'dateRange'
        ));
    }

    /**
     * Show analytics for specific ad
     */
    public function show(Ad $ad, Request $request)
    {
        $dateRange = $request->get('range', '7');
        $startDate = Carbon::now()->subDays($dateRange)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Get summary
        $summary = AdAnalytic::getAdSummary($ad->id, $startDate, $endDate);

        // Get daily stats
        $dailyStats = AdAnalytic::getDailyStats($ad->id, $dateRange);

        // Get device breakdown
        $deviceBreakdown = AdAnalytic::getDeviceBreakdown($ad->id, $startDate, $endDate);

        // Get browser breakdown
        $browserBreakdown = AdAnalytic::getBrowserBreakdown($ad->id, $startDate, $endDate);

        // Get recent events
        $recentEvents = AdAnalytic::where('ad_id', $ad->id)
            ->whereBetween('event_date', [$startDate, $endDate])
            ->orderByDesc('event_date')
            ->limit(50)
            ->get();

        // Get hourly distribution
        $hourlyStats = AdAnalytic::where('ad_id', $ad->id)
            ->whereBetween('event_date', [$startDate, $endDate])
            ->selectRaw('HOUR(event_date) as hour, 
                COUNT(CASE WHEN event_type = "impression" THEN 1 END) as impressions,
                COUNT(CASE WHEN event_type = "click" THEN 1 END) as clicks')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return view('admin.ads.analytics.show', compact(
            'ad',
            'summary',
            'dailyStats',
            'deviceBreakdown',
            'browserBreakdown',
            'recentEvents',
            'hourlyStats',
            'dateRange'
        ));
    }

    /**
     * Track ad impression (API endpoint)
     */
    public function trackImpression(Request $request)
    {
        $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'page_url' => 'nullable|string',
            'page_type' => 'nullable|string',
        ]);

        $this->createAnalyticEvent($request, 'impression');

        return response()->json(['success' => true]);
    }

    /**
     * Track ad click (API endpoint)
     */
    public function trackClick(Request $request)
    {
        $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'page_url' => 'nullable|string',
            'page_type' => 'nullable|string',
        ]);

        $this->createAnalyticEvent($request, 'click');

        return response()->json(['success' => true]);
    }

    /**
     * Create analytic event
     */
    private function createAnalyticEvent(Request $request, string $eventType)
    {
        $userAgent = $request->userAgent();
        
        AdAnalytic::create([
            'ad_id' => $request->ad_id,
            'event_type' => $eventType,
            'page_url' => $request->page_url,
            'page_type' => $request->page_type,
            'referrer' => $request->header('referer'),
            'user_agent' => $userAgent,
            'ip_address' => $request->ip(),
            'device_type' => $this->detectDevice($userAgent),
            'browser' => $this->detectBrowser($userAgent),
            'os' => $this->detectOS($userAgent),
            'event_date' => now(),
        ]);
    }

    /**
     * Detect device type from user agent
     */
    private function detectDevice($userAgent)
    {
        if (preg_match('/mobile/i', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
            return 'tablet';
        }
        return 'desktop';
    }

    /**
     * Detect browser from user agent
     */
    private function detectBrowser($userAgent)
    {
        if (preg_match('/Edge/i', $userAgent)) return 'Edge';
        if (preg_match('/Chrome/i', $userAgent)) return 'Chrome';
        if (preg_match('/Safari/i', $userAgent)) return 'Safari';
        if (preg_match('/Firefox/i', $userAgent)) return 'Firefox';
        if (preg_match('/MSIE|Trident/i', $userAgent)) return 'IE';
        if (preg_match('/Opera|OPR/i', $userAgent)) return 'Opera';
        return 'Other';
    }

    /**
     * Detect OS from user agent
     */
    private function detectOS($userAgent)
    {
        if (preg_match('/Windows/i', $userAgent)) return 'Windows';
        if (preg_match('/Mac OS X/i', $userAgent)) return 'macOS';
        if (preg_match('/Linux/i', $userAgent)) return 'Linux';
        if (preg_match('/Android/i', $userAgent)) return 'Android';
        if (preg_match('/iOS|iPhone|iPad/i', $userAgent)) return 'iOS';
        return 'Other';
    }

    /**
     * Get daily stats for all ads
     */
    private function getDailyStatsForAllAds($days = 7)
    {
        $startDate = Carbon::now()->subDays($days)->startOfDay();
        
        $impressions = AdAnalytic::impressions()
            ->where('event_date', '>=', $startDate)
            ->selectRaw('DATE(event_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $clicks = AdAnalytic::clicks()
            ->where('event_date', '>=', $startDate)
            ->selectRaw('DATE(event_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $dates = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = [
                'date' => Carbon::parse($date)->format('M d'),
                'impressions' => $impressions[$date] ?? 0,
                'clicks' => $clicks[$date] ?? 0,
            ];
        }

        return $dates;
    }

    /**
     * Export analytics report
     */
    public function export(Request $request)
    {
        $dateRange = $request->get('range', '30');
        $startDate = Carbon::now()->subDays($dateRange)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $ads = Ad::withCount([
            'analytics as impressions_count' => function ($query) use ($startDate, $endDate) {
                $query->impressions()->whereBetween('event_date', [$startDate, $endDate]);
            },
            'analytics as clicks_count' => function ($query) use ($startDate, $endDate) {
                $query->clicks()->whereBetween('event_date', [$startDate, $endDate]);
            }
        ])->get()->map(function ($ad) {
            $ad->ctr = $ad->impressions_count > 0 
                ? round(($ad->clicks_count / $ad->impressions_count) * 100, 2) 
                : 0;
            return $ad;
        });

        $filename = 'ads-analytics-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($ads) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Ad Name', 'Position', 'Type', 'Status', 'Impressions', 'Clicks', 'CTR (%)']);

            foreach ($ads as $ad) {
                fputcsv($file, [
                    $ad->name,
                    $ad->position,
                    $ad->type,
                    $ad->status,
                    $ad->impressions_count,
                    $ad->clicks_count,
                    $ad->ctr,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
