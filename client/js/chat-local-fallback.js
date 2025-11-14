(function(){
  function initLocalChatFallback(){
    var messagesEl = document.querySelector('.chat-messages');
    var inputEl = document.querySelector('.chat-input input[type="text"]');
    var sendBtn = document.querySelector('.chat-input button');
    if (!inputEl || !sendBtn || !messagesEl) return;

    // local safe time formatter (don't rely on fmtTime from socket script which is scoped)
    function fmtTimeLocal(ts){
      try { var d = new Date(ts); return d.toLocaleTimeString(); } catch(e){ return ''; }
    }

    function appendLocalMessage(text){
      var div = document.createElement('div');
      div.className = 'message right';
      var bubble = document.createElement('div'); bubble.className = 'bubble';
      div.appendChild(bubble);
      var icon = document.createElement('i'); icon.className = 'fa-solid fa-user';
      div.appendChild(icon);
      messagesEl.appendChild(div);
      messagesEl.scrollTop = messagesEl.scrollHeight;
  var p = document.createElement('div'); p.className = 'msg-text'; p.textContent = text;
  var t = document.createElement('div'); t.className = 'msg-time'; t.textContent = fmtTimeLocal(new Date().toISOString());
    bubble.appendChild(p); bubble.appendChild(t);
    }

    function doSend(){
      var text = (inputEl.value||'').trim();
      if (!text) return;
      inputEl.value = '';
      // Immediate client-side append so user sees message regardless of backend
      appendLocalMessage(text);

      // Try HTTP API if available
      try {
        var bookingId = (new URLSearchParams(window.location.search)).get('booking_id') || localStorage.getItem('last_booking_id');
        if (window.HausTapChatAPI && bookingId) {
          window.HausTapChatAPI.sendMessage(bookingId, { text: text, sender: window.CHAT_ROLE || 'client' })
            .then(function(resp){ /* optionally sync id/timestamp */ })
            .catch(function(err){ console.warn('[chat] send failed', err); });
        }
      } catch(e){ console.warn(e); }
    }

    sendBtn.addEventListener('click', function(e){ e.preventDefault(); doSend(); });
    inputEl.addEventListener('keydown', function(e){ if (e.key === 'Enter'){ e.preventDefault(); doSend(); } });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initLocalChatFallback);
  else initLocalChatFallback();
})();