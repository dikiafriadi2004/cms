<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AdAnalytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'event_type',
        'page_url',
        'page_type',
        'referrer',
        'user_agent',
        'ip_address',
        'device_type',
        'browser',
        'os',
        'country',
        'city',
        'event_date',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Scope for impressions only
     */
    public function scopeImpressions($query)
    {
        return $query->where('event_type', 'impression');
    }

    /**
     * Scope for clicks only
     */
    public function scopeClicks($query)
    {
        return $query->where('event_type', 'click');
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('event_date', [$startDate, $endDate]);
    }

    /**
     * Scope for today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('event_date', Carbon::today());
    }

    /**
     * Scope for this week
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('event_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    /**
     * Scope for this month
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('event_date', Carbon::now()->month)
                     ->whereYear('event_date', Carbon::now()->year);
    }

    /**
     * Scope for last N days
     */
    public function scopeLastDays($query, $days = 7)
    {
        return $query->where('event_date', '>=', Carbon::now()->subDays($days));
    }

    /**
     * Get analytics summary for an ad
     */
    public static function getAdSummary($adId, $startDate = null, $endDate = null)
    {
        $query = static::where('ad_id', $adId);

        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        }

        $impressions = $query->clone()->impressions()->count();
        $clicks = $query->clone()->clicks()->count();
        $ctr = $impressions > 0 ? round(($clicks / $impressions) * 100, 2) : 0;

        return [
            'impressions' => $impressions,
            'clicks' => $clicks,
            'ctr' => $ctr,
        ];
    }

    /**
     * Get daily stats for chart
     */
    public static function getDailyStats($adId, $days = 7)
    {
        $startDate = Carbon::now()->subDays($days)->startOfDay();
        
        $impressions = static::where('ad_id', $adId)
            ->impressions()
            ->where('event_date', '>=', $startDate)
            ->selectRaw('DATE(event_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $clicks = static::where('ad_id', $adId)
            ->clicks()
            ->where('event_date', '>=', $startDate)
            ->selectRaw('DATE(event_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Fill missing dates with 0
        $dates = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = [
                'date' => $date,
                'impressions' => $impressions[$date] ?? 0,
                'clicks' => $clicks[$date] ?? 0,
            ];
        }

        return $dates;
    }

    /**
     * Get device breakdown
     */
    public static function getDeviceBreakdown($adId, $startDate = null, $endDate = null)
    {
        $query = static::where('ad_id', $adId)->impressions();

        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        }

        return $query->selectRaw('device_type, COUNT(*) as count')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get();
    }

    /**
     * Get browser breakdown
     */
    public static function getBrowserBreakdown($adId, $startDate = null, $endDate = null)
    {
        $query = static::where('ad_id', $adId)->impressions();

        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        }

        return $query->selectRaw('browser, COUNT(*) as count')
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
    }

    /**
     * Get top performing ads
     */
    public static function getTopPerformingAds($limit = 10, $days = 7)
    {
        $startDate = Carbon::now()->subDays($days);

        return static::where('event_date', '>=', $startDate)
            ->selectRaw('ad_id, 
                COUNT(CASE WHEN event_type = "impression" THEN 1 END) as impressions,
                COUNT(CASE WHEN event_type = "click" THEN 1 END) as clicks,
                ROUND((COUNT(CASE WHEN event_type = "click" THEN 1 END) / COUNT(CASE WHEN event_type = "impression" THEN 1 END)) * 100, 2) as ctr')
            ->groupBy('ad_id')
            ->orderByDesc('clicks')
            ->limit($limit)
            ->with('ad')
            ->get();
    }
}
