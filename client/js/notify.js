// Minimal notify.js stub to prevent 404s and provide a tiny API used by admin UI
window.Notify = (function(){
  const listeners = {};
  return {
    on: function(event, cb){ (listeners[event] = listeners[event] || []).push(cb); },
    off: function(event, cb){ if (!listeners[event]) return; listeners[event] = listeners[event].filter(f=>f!==cb); },
    emit: function(event, payload){ (listeners[event]||[]).forEach(cb=>{ try{ cb(payload); }catch(e){} }); },
    // For simple compatibility: return 0 unread
    getUnread: async function(){ return 0; }
  };
})();
