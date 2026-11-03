<?php

namespace TronderData\Google;

use Illuminate\Console\Command;

final class RefreshGoogleInsights extends Command
{
    protected $signature = 'google:insights-refresh {--force : Ignore freshness interval}';

    protected $description = 'Refresh local aggregate GA4 insights (production only)';

    public function handle(Insights $insights): int
    {
        try {
            $this->info($insights->refresh((bool) $this->option('force')) ? 'Google insights refreshed.' : 'Skipped: disabled, non-production or still fresh.');

            return self::SUCCESS;
        } catch (\Throwable) {
            $this->error('Google insights refresh failed. Previous snapshot retained. Check configuration, credentials, API access and TLS.');

            return self::FAILURE;
        }
    }
}
