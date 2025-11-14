// Extension to HausTapBookingAPI: add clearCancelled bulk action
(function(){
  function attach(){
    var API_BASE = (window.API_BASE || '').replace(/\/+$/, '') || '';
    async function request(path, opts) {
      const url = `${API_BASE}${path}`;
      const headers = Object.assign({
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }, opts && opts.headers);
      const res = await fetch(url, Object.assign({ method: 'POST', headers }, opts));
      const ct = res.headers.get('content-type') || '';
      let data = null;
      if (ct.includes('application/json')) {
        data = await res.json();
      } else {
        const text = await res.text();
        try { data = JSON.parse(text); } catch { data = { message: text }; }
      }
      if (!res.ok) {
        const message = (data && (data.message || data.error)) || `HTTP ${res.status}`;
        const err = new Error(message);
        err.response = res;
        err.data = data;
        throw err;
      }
      return data;
    }
    async function clearCancelled(){
      return request('/clear-cancelled', { method: 'POST', body: JSON.stringify({}) });
    }
    if (window.HausTapBookingAPI) {
      window.HausTapBookingAPI.clearCancelled = clearCancelled;
    }
  }

  if (window.HausTapBookingAPI) {
    attach();
  } else {
    var tries = 0;
    var t = setInterval(function(){
      tries++;
      if (window.HausTapBookingAPI) {
        clearInterval(t);
        attach();
      }
      if (tries > 50) { clearInterval(t); }
    }, 100);
  }
})();
