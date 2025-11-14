// Minimal API base configuration for web pages
(function () {
  if (!window.API_BASE) {
    // Allow overriding via globals for easy env switching
    var rawOverride = window.API_BASE_OVERRIDE;
    var override = typeof rawOverride === 'string' ? rawOverride.trim() : '';
    if (override) {
      window.API_BASE = override;
      return;
    }

    // Target can be 'backend' or 'mock' (default: mock)
    var target = ((window.API_TARGET || '') + '').toLowerCase();
    if (target === 'backend') {
      var backend = (window.BACKEND_BASE || 'http://127.0.0.1:8001').replace(/\/+$/, '');
      window.API_BASE = backend;
      return;
    }

    // Default to mock API served by current origin
    var origin = (window.location && window.location.origin) || '';
    var base = origin ? origin + '/mock-api' : '/mock-api';
    window.API_BASE = base;
  }
})();
