// Central API configuration for website pages (no UI impact)
// Use the same backend as the Expo app
// Adjust only if your LAN IP changes
const API_BASE_URL = 'http://192.168.18.95:8001/auth';

// Expose for inline scripts
window.API_BASE_URL = API_BASE_URL;