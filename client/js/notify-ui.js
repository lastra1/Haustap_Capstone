// Minimal notify-ui binding: updates notif count and toggles the injected dropdown
(function(){
  function updateCount(n){
    var el = document.getElementById('notifCount');
    if (!el) return;
    if (!n || n <= 0){ el.style.display = 'none'; }
    else { el.style.display = 'inline-block'; el.textContent = String(n); }
  }

  function toggleDropdown(){
    var dd = document.getElementById('notifDropdown');
    if (!dd) return;
    dd.classList.toggle('hidden');
  }

  function bind(){
    var bell = document.getElementById('notifBellBtn');
    if (bell) {
      bell.addEventListener('click', function(e){
        e.stopPropagation();
        toggleDropdown();
      });
    }

    // close on outside click
    document.addEventListener('click', function(e){
      var dd = document.getElementById('notifDropdown');
      if (!dd) return;
      if (!dd.contains(e.target) && e.target.id !== 'notifBellBtn') dd.classList.add('hidden');
    });

    // populate with a small placeholder list if empty
    var list = document.getElementById('notifList');
    if (list && list.children.length === 0){
      var li = document.createElement('li');
      li.style.padding = '12px';
      li.style.borderBottom = '1px solid #eee';
      li.textContent = 'No notifications at this time.';
      list.appendChild(li);
    }

    // Try to get unread count from Notify if available
    if (window.Notify && typeof window.Notify.getUnread === 'function'){
      try { window.Notify.getUnread().then(updateCount).catch(()=>updateCount(0)); } catch(e){ updateCount(0); }
    } else { updateCount(0); }
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bind); else bind();
})();
