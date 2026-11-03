<?php

return [
    'enabled' => (bool) env('GOOGLE_ENABLED', false),
    'driver' => env('GOOGLE_TRACKING_DRIVER', 'ga4'),
    'measurement_id' => env('GA4_MEASUREMENT_ID', ''),
    'container_id' => env('GTM_CONTAINER_ID', ''),
    'insights_enabled' => (bool) env('GOOGLE_INSIGHTS_ENABLED', false),
    'property_id' => env('GA4_PROPERTY_ID', ''),
    'credentials' => env('GOOGLE_APPLICATION_CREDENTIALS', ''),
    'refresh_days' => (int) env('GOOGLE_INSIGHTS_REFRESH_DAYS', 30),
    'lookback_days' => (int) env('GOOGLE_INSIGHTS_LOOKBACK_DAYS', 30),
    'minimum_views' => (int) env('GOOGLE_INSIGHTS_MINIMUM_VIEWS', 5),
];
