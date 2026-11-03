# td-google

Optional Laravel 13 / PHP 8.4 Composer package. MIT license. Installed by default in td-laravel-starter; disabled by default.

## Configuration

GOOGLE_ENABLED=false is the master switch. GOOGLE_TRACKING_DRIVER=ga4 selects direct GA4; gtm selects a GTM container instead. GA4_MEASUREMENT_ID and GTM_CONTAINER_ID are public IDs. Tracking is blocked outside production and before analytics consent.

GOOGLE_INSIGHTS_ENABLED=false independently controls report retrieval and popularity ranking. Set GA4_PROPERTY_ID and GOOGLE_APPLICATION_CREDENTIALS to an absolute service-account JSON path outside Git and public/. Grant that account Viewer access on the property and enable the Analytics Data API.

The host must run Laravel's scheduler every minute. The package checks freshness daily and refreshes after GOOGLE_INSIGHTS_REFRESH_DAYS (default 30), covering GOOGLE_INSIGHTS_LOOKBACK_DAYS completed days through yesterday in the property's timezone. google:insights-refresh --force bypasses freshness, never the environment or activation gates.

Only page paths, views, per-page total users, engagement seconds and contact_click event counts are stored in storage/app/private/google/insights.json. No query strings, identities or raw events are persisted. A failed refresh retains the last successful snapshot. Per-page users must not be summed into site-wide unique visitors.

## Host contract

The host owns its consent dialog. Import mayTrack/startTracking from resources/js/tracking.js and call startTracking once after a persisted explicit grant. Use Tracking::options() for server-side environment gating. On withdrawal, deny analytics, clear GA cookies and reload. GTM must contain analytics-only tags with appropriate consent checks, sanitized page fields, a contact_click custom-event trigger and no automatic duplicate pageviews. The package cannot enforce arbitrary container contents.

Disable GA4 Enhanced Measurement features that could collect forms, query strings or other personal data. Contact events send only phone/email/contact type and the current page path; no destination phone number, address or form text. These counts describe clicks on the current page, not a multi-page attribution funnel.

Render <x-google::popular-articles :posts="$publishedPosts" :fallback-slugs="$editorialSlugs"/>. Host posts must be published records with slug and the fields needed by x-ui::article-card. Paths are /nyheter/{slug}. No URL returned by Google is rendered directly. Ranking uses a minimum of GOOGLE_INSIGHTS_MINIMUM_VIEWS (default 5), then editorial slugs, then the host's published order. Navigation is never changed.

## Updates

The starter carries an exact source copy in modules/google with a hash manifest and Composer path repository (symlink=false). Update only that directory, its version and Composer lock entry, then test and build the target website. A plain composer update cannot download new source into a path repository. Existing customer sites are never automatically upgraded.

To remove completely, remove the Composer dependency/repository, module source and host JS import together, regenerate the lock and build. The generic consent dialog remains host-owned.

## Verification

Integration tests live in the starter: tests/Feature/GoogleModuleTest.php and tests/js. They use synthetic data and mocked HTTP. Live credentials, Google ingestion, GTM container behavior and production scheduler operation require separate verification.
