(function(){
  function initFilterByCategory(){
    var select = document.querySelector('.category-select');
    var grid = document.querySelector('.services-grid');
    if (!select || !grid) return;
    var cards = Array.prototype.slice.call(grid.querySelectorAll('.service-card'));

    function applyFilter(){
      var val = select.value || '';
      if (!val){
        cards.forEach(function(c){ c.style.display = ''; });
        return;
      }
      cards.forEach(function(c){
        var cat = c.getAttribute('data-category') || '';
        if (cat === val) {
          c.style.display = '';
        } else {
          c.style.display = 'none';
        }
      });
    }

    select.addEventListener('change', applyFilter);

    // Initialize if there's a pre-selected value
    applyFilter();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFilterByCategory);
  } else {
    initFilterByCategory();
  }
})();