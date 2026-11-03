<?php

namespace TronderData\Google;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

final class Insights
{
    public function __construct(private AnalyticsClient $client) {}

    public function file(): string
    {
        return storage_path('app/private/google/insights.json');
    }

    public function snapshot(): array
    {
        try {
            return is_file($this->file()) ? json_decode(File::get($this->file()), true, 512, JSON_THROW_ON_ERROR) : [];
        } catch (\Throwable) {
            return [];
        }
    }

    public function refresh(bool $force = false): bool
    {
        if (! app()->isProduction() || ! config('google.enabled') || ! config('google.insights_enabled')) {
            return false;
        }

        return Cache::lock('td-google-insights', 600)->block(1, function () use ($force): bool {
            $snapshot = $this->snapshot();
            $days = max(1, (int) config('google.refresh_days', 30));
            if (! $force && isset($snapshot['refreshed_at']) && now()->lt(Carbon::parse($snapshot['refreshed_at'])->addDays($days))) {
                return false;
            }
            $pages = $this->client->pages();
            $data = ['refreshed_at' => now()->toIso8601String(), 'lookback_days' => max(1, min(365, (int) config('google.lookback_days', 30))), 'pages' => $pages];
            File::ensureDirectoryExists(dirname($this->file()), 0700);
            File::replace($this->file(), json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT), 0600);

            return true;
        });
    }

    /** Published host content only. URLs from Google are never rendered directly. */
    public function popular(Collection $posts, array $fallbackSlugs = [], int $limit = 3): Collection
    {
        $limit = max(1, min(12, $limit));
        $byPath = $posts->keyBy(fn (array $post): string => '/nyheter/'.$post['slug']);
        $selected = collect();
        $pages = config('google.enabled') && config('google.insights_enabled') ? ($this->snapshot()['pages'] ?? []) : [];
        foreach (collect($pages)->sortByDesc('views') as $page) {
            if (($page['views'] ?? 0) >= config('google.minimum_views', 5) && $byPath->has($page['path'] ?? '')) {
                $post = $byPath->get($page['path']);
                $selected->put($post['slug'], $post);
            }
        }
        foreach ($fallbackSlugs as $slug) {
            $post = $posts->firstWhere('slug', $slug);
            if ($post && ! $selected->has($slug)) {
                $selected->put($slug, $post);
            }
        }
        foreach ($posts as $post) {
            if (! $selected->has($post['slug'])) {
                $selected->put($post['slug'], $post);
            }
        }

        return $selected->take($limit)->values();
    }
}
