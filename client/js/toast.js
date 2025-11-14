// Minimal toast shim used by some pages. This keeps behavior predictable during dev.
window.Toast = (function(){
  return {
    show: function(message, opts){
      // Simple non-blocking visual: use console + small transient DOM node
      try {
        console.log('[Toast]', message, opts);
        var container = document.getElementById('ht-toast-container');
        if (!container){ container = document.createElement('div'); container.id = 'ht-toast-container'; container.style.position='fixed'; container.style.right='12px'; container.style.bottom='12px'; container.style.zIndex='9999'; document.body.appendChild(container); }
        var item = document.createElement('div'); item.textContent = message; item.style.background='#222'; item.style.color='#fff'; item.style.padding='8px 12px'; item.style.marginTop='8px'; item.style.borderRadius='6px'; item.style.boxShadow='0 6px 18px rgba(0,0,0,0.2)'; container.appendChild(item);
        setTimeout(function(){ try{ item.remove(); }catch(e){} }, (opts && opts.duration) || 3000);
      } catch(e){ console.log('[Toast] fallback', message); }
    }
  };
})();
