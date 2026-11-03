<?php

namespace TronderData\Google;

final class Tracking
{
    /** @return array{available: bool, driver: string, measurementId: string, containerId: string} */
    public function options(): array
    {
        $driver = config('google.driver', 'ga4');
        $measurement = (string) config('google.measurement_id', '');
        $container = (string) config('google.container_id', '');
        $valid = match ($driver) {
            'ga4' => preg_match('/^G-[A-Z0-9]+$/D', $measurement) === 1,
            'gtm' => preg_match('/^GTM-[A-Z0-9]+$/D', $container) === 1,
            default => false,
        };
        $available = app()->isProduction() && config('google.enabled', false) && $valid;

        return [
            'available' => $available,
            'driver' => $driver,
            'measurementId' => $available ? $measurement : '',
            'containerId' => $available ? $container : '',
        ];
    }
}
