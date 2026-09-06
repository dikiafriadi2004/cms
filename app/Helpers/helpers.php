<?php

if (!function_exists('storage_url')) {
    /**
     * Generate storage URL, handling paths that already include /storage/
     * 
     * @param string|null $path
     * @param bool $absolute Force absolute URL (useful for emails)
     * @return string
     */
    function storage_url($path, $absolute = true)
    {
        if (empty($path)) {
            return '';
        }
        
        // Remove leading /storage/ if it exists
        $path = preg_replace('#^/?storage/#', '', $path);
        
        // Use url() for absolute URLs (better for emails) or asset() for relative
        if ($absolute) {
            return url('storage/' . $path);
        }
        
        return asset('storage/' . $path);
    }
}

if (!function_exists('favicon_url')) {
    /**
     * Get favicon URL with fallback and cache busting
     * 
     * @return string
     */
    function favicon_url()
    {
        try {
            $favicon = \App\Models\Setting::where('key', 'favicon')->value('value');
            
            if ($favicon) {
                $url = storage_url($favicon);
                // Add cache busting parameter based on file modification time
                $filePath = public_path('storage/' . preg_replace('#^/?storage/#', '', $favicon));
                if (file_exists($filePath)) {
                    $timestamp = filemtime($filePath);
                    return $url . '?v=' . $timestamp;
                }
                return $url;
            }
        } catch (\Exception $e) {
            // Database not ready or error
        }
        
        // Fallback to default favicon
        return asset('favicon.ico');
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date to Indonesian format
     * 
     * @param string|Carbon $date
     * @param string $format
     * @return string
     */
    function format_date($date, $format = 'd F Y')
    {
        if (empty($date)) {
            return '';
        }
        
        $carbon = $date instanceof \Carbon\Carbon ? $date : \Carbon\Carbon::parse($date);
        
        // Indonesian month names
        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
        
        // Indonesian day names
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        
        $formatted = $carbon->format($format);
        
        // Replace English month and day names with Indonesian
        $formatted = str_replace(array_keys($months), array_values($months), $formatted);
        $formatted = str_replace(array_keys($days), array_values($days), $formatted);
        
        return $formatted;
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format datetime to Indonesian format
     * 
     * @param string|Carbon $datetime
     * @return string
     */
    function format_datetime($datetime)
    {
        return format_date($datetime, 'd F Y, H:i') . ' WIB';
    }
}

if (!function_exists('time_ago')) {
    /**
     * Get human readable time difference in Indonesian
     * 
     * @param string|Carbon $datetime
     * @return string
     */
    function time_ago($datetime)
    {
        if (empty($datetime)) {
            return '';
        }
        
        $carbon = $datetime instanceof \Carbon\Carbon ? $datetime : \Carbon\Carbon::parse($datetime);
        
        $diff = $carbon->diffForHumans();
        
        // Translate to Indonesian
        $translations = [
            'second' => 'detik',
            'seconds' => 'detik',
            'minute' => 'menit',
            'minutes' => 'menit',
            'hour' => 'jam',
            'hours' => 'jam',
            'day' => 'hari',
            'days' => 'hari',
            'week' => 'minggu',
            'weeks' => 'minggu',
            'month' => 'bulan',
            'months' => 'bulan',
            'year' => 'tahun',
            'years' => 'tahun',
            'ago' => 'yang lalu',
            'from now' => 'dari sekarang',
        ];
        
        return str_replace(array_keys($translations), array_values($translations), $diff);
    }
}

if (!function_exists('asset_version')) {
    /**
     * Generate a versioned asset URL with cache busting.
     *
     * Uses APP_VERSION env if set (recommended for production deploys via CI),
     * otherwise falls back to filemtime. Cached per-process to avoid repeated
     * disk I/O for the same asset within a single request.
     *
     * Usage:
     *   <link rel="stylesheet" href="{{ asset_version('css/app.css') }}">
     */
    function asset_version(string $relativePath): string
    {
        static $cache = [];

        if (isset($cache[$relativePath])) {
            return $cache[$relativePath];
        }

        $appVersion = env('APP_VERSION');
        if ($appVersion) {
            return $cache[$relativePath] = asset($relativePath) . '?v=' . urlencode($appVersion);
        }

        $absolute = public_path($relativePath);
        if (!file_exists($absolute)) {
            return $cache[$relativePath] = asset($relativePath);
        }

        $stamp = filemtime($absolute) ?: time();
        return $cache[$relativePath] = asset($relativePath) . '?v=' . $stamp;
    }
}

if (!function_exists('safe_like_input')) {
    /**
     * Sanitize search input for use in SQL LIKE queries.
     *
     * - Trims and caps length to prevent DoS via massive patterns.
     * - Escapes SQL LIKE wildcards (%, _) and the escape char (\) so
     *   user input "100%" matches the literal string, not a wildcard.
     *
     * Pair with default LIKE behavior (use the escape character explicitly
     * if your DB requires it; MySQL accepts default \ as escape).
     */
    function safe_like_input(?string $input, int $maxLength = 200): string
    {
        if ($input === null) {
            return '';
        }
        $trimmed = mb_substr(trim($input), 0, $maxLength);
        return addcslashes($trimmed, '%_\\');
    }
}
