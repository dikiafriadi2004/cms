<?php

namespace App\Services;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;
use Exception;
use App\Models\Setting;

class GoogleAnalyticsService
{
    /**
     * Get credentials from database
     */
    protected function getCredentials()
    {
        $credentials = Setting::where('key', 'ga_credentials_json')->value('value');
        
        if (!$credentials) {
            return null;
        }
        
        return json_decode($credentials, true);
    }
    
    /**
     * Get property ID from database
     */
    protected function getPropertyId()
    {
        return Setting::where('key', 'ga_property_id')->value('value');
    }
    
    /**
     * Configure analytics dynamically
     */
    protected function configureAnalytics()
    {
        $propertyId = $this->getPropertyId();
        $credentials = $this->getCredentials();
        
        if (!$propertyId || !$credentials) {
            return false;
        }
        
        // Set config dynamically
        config(['analytics.property_id' => $propertyId]);
        config(['analytics.service_account_credentials_json' => $credentials]);
        
        return true;
    }

    /**
     * Check if Google Analytics is configured
     */
    public function isConfigured(): bool
    {
        try {
            $propertyId = $this->getPropertyId();
            $credentials = $this->getCredentials();
            
            return !empty($propertyId) && !empty($credentials);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get total visitors for a period
     */
    public function getTotalVisitors(Period $period)
    {
        try {
            if (!$this->isConfigured()) {
                return 0;
            }
            
            // Configure analytics
            $this->configureAnalytics();

            $result = Analytics::get(
                $period,
                ['totalUsers'],
                []
            );

            return $result->sum('totalUsers');
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get page views for a period
     */
    public function getPageViews(Period $period)
    {
        try {
            if (!$this->isConfigured()) {
                return 0;
            }
            
            // Configure analytics
            $this->configureAnalytics();

            $result = Analytics::get(
                $period,
                ['screenPageViews'],
                []
            );

            return $result->sum('screenPageViews');
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get most visited pages
     */
    public function getMostVisitedPages(Period $period, int $limit = 10)
    {
        try {
            if (!$this->isConfigured()) {
                return collect();
            }
            
            // Configure analytics
            $this->configureAnalytics();

            return Analytics::get(
                $period,
                ['screenPageViews'],
                ['pageTitle', 'fullPageUrl'],
                $limit
            );
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get traffic sources
     */
    public function getTrafficSources(Period $period, int $limit = 10)
    {
        try {
            if (!$this->isConfigured()) {
                return collect();
            }
            
            // Configure analytics
            $this->configureAnalytics();

            return Analytics::get(
                $period,
                ['sessions'],
                ['sessionSource', 'sessionMedium'],
                $limit
            );
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get user types (new vs returning)
     */
    public function getUserTypes(Period $period)
    {
        try {
            if (!$this->isConfigured()) {
                return collect();
            }
            
            // Configure analytics
            $this->configureAnalytics();

            return Analytics::get(
                $period,
                ['totalUsers'],
                ['newVsReturning']
            );
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get daily visitors for the last 30 days
     */
    public function getDailyVisitors()
    {
        try {
            if (!$this->isConfigured()) {
                return collect();
            }
            
            // Configure analytics
            $this->configureAnalytics();

            $period = Period::days(30);

            return Analytics::get(
                $period,
                ['totalUsers', 'screenPageViews'],
                ['date']
            );
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get device categories
     */
    public function getDeviceCategories(Period $period)
    {
        try {
            if (!$this->isConfigured()) {
                return collect();
            }
            
            // Configure analytics
            $this->configureAnalytics();

            return Analytics::get(
                $period,
                ['sessions'],
                ['deviceCategory']
            );
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get bounce rate
     */
    public function getBounceRate(Period $period)
    {
        try {
            if (!$this->isConfigured()) {
                return 0;
            }
            
            // Configure analytics
            $this->configureAnalytics();

            $result = Analytics::get(
                $period,
                ['bounceRate'],
                []
            );

            return $result->first()['bounceRate'] ?? 0;
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get average session duration
     */
    public function getAverageSessionDuration(Period $period)
    {
        try {
            if (!$this->isConfigured()) {
                return 0;
            }
            
            // Configure analytics
            $this->configureAnalytics();

            $result = Analytics::get(
                $period,
                ['averageSessionDuration'],
                []
            );

            return $result->first()['averageSessionDuration'] ?? 0;
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get dashboard summary
     */
    public function getDashboardSummary()
    {
        $today = Period::days(1);
        $last7Days = Period::days(7);
        $last30Days = Period::days(30);

        return [
            'today' => [
                'visitors' => $this->getTotalVisitors($today),
                'pageViews' => $this->getPageViews($today),
            ],
            'last7Days' => [
                'visitors' => $this->getTotalVisitors($last7Days),
                'pageViews' => $this->getPageViews($last7Days),
            ],
            'last30Days' => [
                'visitors' => $this->getTotalVisitors($last30Days),
                'pageViews' => $this->getPageViews($last30Days),
                'bounceRate' => $this->getBounceRate($last30Days),
                'avgSessionDuration' => $this->getAverageSessionDuration($last30Days),
            ],
            'topPages' => $this->getMostVisitedPages($last7Days, 5),
            'trafficSources' => $this->getTrafficSources($last7Days, 5),
            'userTypes' => $this->getUserTypes($last7Days),
            'devices' => $this->getDeviceCategories($last7Days),
            'dailyVisitors' => $this->getDailyVisitors(),
        ];
    }
}
