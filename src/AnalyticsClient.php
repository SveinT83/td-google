<?php

namespace TronderData\Google;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AnalyticsClient
{
    /** @return list<array{path: string, views: int, users: int, engagement_seconds: float, contact_clicks: int}> */
    public function pages(): array
    {
        $property = (string) config('google.property_id');
        if (! preg_match('/^[0-9]+$/D', $property)) {
            throw new RuntimeException('GA4 property ID is missing or invalid.');
        }
        $token = $this->accessToken();
        $days = max(1, min(365, (int) config('google.lookback_days', 30)));
        $base = [
            'dateRanges' => [['startDate' => $days.'daysAgo', 'endDate' => 'yesterday']],
            'dimensions' => [['name' => 'pagePath']],
            'dimensionFilter' => ['filter' => ['fieldName' => 'hostName', 'stringFilter' => ['matchType' => 'EXACT', 'value' => parse_url(config('app.url'), PHP_URL_HOST)]]],
        ];
        $url = 'https://analyticsdata.googleapis.com/v1beta/properties/'.$property.':runReport';
        $pages = [];
        $offset = 0;
        do {
            $response = Http::withToken($token)->timeout(30)->post($url, array_merge($base, [
                'metrics' => array_map(fn (string $name): array => ['name' => $name], ['screenPageViews', 'totalUsers', 'userEngagementDuration']),
                'limit' => 10000, 'offset' => $offset,
            ]));
            if (! $response->successful()) {
                throw new RuntimeException('GA4 report failed (HTTP '.$response->status().').');
            }
            $data = $response->json();
            if (! is_array($data) || ! isset($data['rowCount'])) {
                throw new RuntimeException('Invalid GA4 report response.');
            }
            foreach ($data['rows'] ?? [] as $row) {
                $path = $row['dimensionValues'][0]['value'] ?? '';
                if (! str_starts_with($path, '/') || str_contains($path, '?')) {
                    continue;
                }
                $pages[$path] = ['path' => $path, 'views' => (int) $row['metricValues'][0]['value'], 'users' => (int) $row['metricValues'][1]['value'], 'engagement_seconds' => (float) $row['metricValues'][2]['value'], 'contact_clicks' => 0];
            }
            $offset += 10000;
        } while ($offset < (int) $data['rowCount']);
        $offset = 0;
        do {
            $contactBase = $base;
            $contactBase['dimensionFilter'] = ['andGroup' => ['expressions' => [
                $base['dimensionFilter'],
                ['filter' => ['fieldName' => 'eventName', 'stringFilter' => ['matchType' => 'EXACT', 'value' => 'contact_click']]],
            ]]];
            $response = Http::withToken($token)->timeout(30)->post($url, array_merge($contactBase, [
                'metrics' => [['name' => 'eventCount']], 'limit' => 10000, 'offset' => $offset,
            ]));
            if (! $response->successful()) {
                throw new RuntimeException('GA4 contact report failed (HTTP '.$response->status().').');
            }
            $data = $response->json();
            if (! is_array($data) || ! isset($data['rowCount'])) {
                throw new RuntimeException('Invalid GA4 contact report.');
            }
            foreach ($data['rows'] ?? [] as $row) {
                $path = $row['dimensionValues'][0]['value'] ?? '';
                if (isset($pages[$path])) {
                    $pages[$path]['contact_clicks'] = (int) $row['metricValues'][0]['value'];
                }
            }
            $offset += 10000;
        } while ($offset < (int) $data['rowCount']);

        return array_values($pages);
    }

    protected function accessToken(): string
    {
        $file = realpath((string) config('google.credentials'));
        if (! $file || ! is_file($file) || str_starts_with($file, public_path().DIRECTORY_SEPARATOR)) {
            throw new RuntimeException('Google credentials must be a readable file outside public.');
        }
        $credentials = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        if (($credentials['type'] ?? '') !== 'service_account' || ($credentials['token_uri'] ?? '') !== 'https://oauth2.googleapis.com/token') {
            throw new RuntimeException('Expected Google service account credentials.');
        }
        $auth = new ServiceAccountCredentials('https://www.googleapis.com/auth/analytics.readonly', $credentials);
        $token = $auth->fetchAuthToken();
        if (empty($token['access_token'])) {
            throw new RuntimeException('Google authentication failed.');
        }

        return $token['access_token'];
    }
}
