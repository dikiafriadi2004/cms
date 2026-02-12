<?php

if (!function_exists('storage_url')) {
    /**
     * Generate storage URL, handling paths that already include /storage/
     * 
     * @param string|null $path
     * @return string
     */
    function storage_url($path)
    {
        if (empty($path)) {
            return '';
        }
        
        // Remove leading /storage/ if it exists
        $path = preg_replace('#^/?storage/#', '', $path);
        
        // Use asset helper with storage prefix
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
