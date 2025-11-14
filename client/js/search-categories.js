(function(){
  // Enhanced category search with partial matching
  function initCategorySearch(){
    try {
      console.debug('[search-categories] init start');
    } catch (e) {}
    var containerSelector = '.category-grid';
    var cardSelector = '.category-card';
    var titleSelector = '.category-card-title';
    var descSelector = '.category-card-desc';
    
    // Helper function to highlight matching text
    function highlightText(text, query) {
      if (!query) return text;
      var parts = text.split(new RegExp(`(${query})`, 'gi'));
      return parts.map(function(part) {
        return part.toLowerCase() === query.toLowerCase() 
          ? '<span class="ht-highlight">' + part + '</span>' 
          : part;
      }).join('');
    }

    var searchBox = document.querySelector('.search-box input');
    var searchBtn = document.querySelector('.search-btn');
    if (!searchBox || !searchBtn) {
      try { console.debug('[search-categories] search elements not found', {searchBox: !!searchBox, searchBtn: !!searchBtn}); } catch(e){}
      return;
    }

    function performSearch(){
      try { console.debug('[search-categories] performSearch', searchBox.value); } catch(e){}
      var q = (searchBox.value || '').trim().toLowerCase();
      var grid = document.querySelector(containerSelector);
      if (!grid) return;
      var cards = Array.prototype.slice.call(grid.querySelectorAll(cardSelector));
      var shown = 0;

      // Remove any existing highlights first
      cards.forEach(function(card) {
        var titleEl = card.querySelector(titleSelector);
        var descEl = card.querySelector(descSelector);
        if (titleEl) titleEl.innerHTML = titleEl.textContent;
        if (descEl) descEl.innerHTML = descEl.textContent;
      });

      if (!q){
        // show all when empty
        cards.forEach(function(c){ c.style.display = ''; });
        return;
      }

      cards.forEach(function(card){
        var titleEl = card.querySelector(titleSelector);
        var descEl = card.querySelector(descSelector);
        var title = titleEl ? (titleEl.textContent || '') : '';
        var desc  = descEl ? (descEl.textContent || '') : '';
        var titleLower = title.toLowerCase();
        var descLower = desc.toLowerCase();
        
        // Check if query matches start of any word in title or description
        var words = titleLower.split(/\s+/).concat(descLower.split(/\s+/));
        var matches = words.some(function(word) {
          return word.startsWith(q);
        }) || titleLower.includes(q) || descLower.includes(q);

        if (matches) {
          card.style.display = '';
          // Highlight matching text
          if (titleEl) titleEl.innerHTML = highlightText(title, q);
          if (descEl) descEl.innerHTML = highlightText(desc, q);
          shown++;
        } else {
          card.style.display = 'none';
        }
      });

      // optional: show a message when no results
      var noElId = 'ht-no-results-msg';
      var existing = document.getElementById(noElId);
      if (shown === 0) {
        if (!existing) {
          var msg = document.createElement('div');
          msg.id = noElId;
          msg.style.textAlign = 'center';
          msg.style.padding = '20px 0';
          msg.style.color = '#555';
          msg.textContent = 'No matching categories found.';
          grid.parentNode.insertBefore(msg, grid.nextSibling);
        }
      } else {
        if (existing) existing.parentNode.removeChild(existing);
      }
    }

    // Enter key
    searchBox.addEventListener('keydown', function(e){
      if (e.key === 'Enter'){
        e.preventDefault();
        performSearch();
      }
    });

    // Button click
    searchBtn.addEventListener('click', function(e){
      e.preventDefault();
      performSearch();
    });

    // live search (optional small debounce)
    var timer = null;
    searchBox.addEventListener('input', function(){
      if (timer) clearTimeout(timer);
      timer = setTimeout(function(){ performSearch(); }, 220);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCategorySearch);
  } else {
    initCategorySearch();
  }
})();