export function mayTrack(options, choice) {
    const driver = options.driver || 'ga4';
    const valid = driver === 'ga4' ? /^G-[A-Z0-9]+$/.test(options.measurementId || '') : driver === 'gtm' && /^GTM-[A-Z0-9]+$/.test(options.containerId || '');
    return options.available === true && valid && choice?.analytics === true;
}

export function startTracking(options) {
    if (!mayTrack(options, { analytics: true })) return;
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('consent', 'default', { analytics_storage: 'denied', ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied' });
    window.gtag('consent', 'update', { analytics_storage: 'granted' });
    const script = document.createElement('script');
    script.async = true;
    if (options.driver === 'gtm') {
        window.dataLayer.push({ 'gtm.start': Date.now(), event: 'gtm.js' });
        script.src = 'https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(options.containerId);
    } else {
        window['ga-disable-' + options.measurementId] = false;
        window.gtag('js', new Date());
        window.gtag('config', options.measurementId, { send_page_view: false, allow_google_signals: false, allow_ad_personalization_signals: false });
        window.gtag('event', 'page_view', { page_location: location.origin + location.pathname, page_referrer: '', page_title: 'Offentlig side' });
        script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(options.measurementId);
    }
    document.head.appendChild(script);
    document.addEventListener('click', event => {
        const link = event.target.closest?.('a[href]');
        const href = link?.getAttribute('href') || '';
        const type = href.startsWith('tel:') ? 'phone' : href.startsWith('mailto:') ? 'email' : /^\/kontakt(?:[\/#?]|$)/.test(href) ? 'contact' : null;
        if (!type || !mayTrack(options, { analytics: true })) return;
        const data = { contact_type: type, page_location: location.origin + location.pathname, page_referrer: '', page_title: 'Offentlig side' };
        if (options.driver === 'gtm') window.dataLayer.push({ event: 'contact_click', ...data });
        else window.gtag('event', 'contact_click', data);
    });
}
