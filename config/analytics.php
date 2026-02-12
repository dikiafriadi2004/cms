<?php

return [

    /*
     * The property id of which you want to display data.
     * This will be set dynamically from database by GoogleAnalyticsService
     */
    'property_id' => env('ANALYTICS_PROPERTY_ID'),

    /*
     * Service account credentials for Google Analytics API.
     * This will be set dynamically from database by GoogleAnalyticsService
     * Credentials are stored in database: settings table, key 'ga_credentials_json'
     */
    'service_account_credentials_json' => env('ANALYTICS_CREDENTIALS_PATH'),

    /*
     * The amount of minutes the Google API responses will be cached.
     * If you set this to zero, the responses won't be cached at all.
     */
    'cache_lifetime_in_minutes' => 60 * 24,

    /*
     * Here you may configure the "store" that the underlying Google_Client will
     * use to store it's data.  You may also add extra parameters that will
     * be passed on setCacheConfig (see docs for google-api-php-client).
     *
     * Optional parameters: "lifetime", "prefix"
     */
    'cache' => [
        'store' => 'file',
    ],
];
