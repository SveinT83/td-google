import { test } from 'node:test';
import assert from 'node:assert/strict';
import { mayTrack, startTracking } from '../resources/js/tracking.js';
test('tracking is blocked without valid driver, ID, availability and consent', () => {
    const ga4 = {available:true, measurementId:'G-TEST123'};
    assert.equal(mayTrack(ga4,null),false);
    assert.equal(mayTrack(ga4,{analytics:true}),true);
    assert.equal(mayTrack({...ga4,available:false},{analytics:true}),false);
    assert.equal(mayTrack({...ga4,driver:'bad'},{analytics:true}),false);
    assert.equal(mayTrack({available:true,driver:'gtm',containerId:'GTM-TEST123'},{analytics:true}),true);
});
test('disabled tracking does not touch the browser', () => { startTracking({available:false}); });
