// Global enhancer: turn single-select service radios into multi-select checkboxes
// and add a Proceed button that aggregates selected items and price.
(function(){
  function normalizeText(s){ return String(s||'').replace(/\s+/g,' ').trim(); }
  function parsePriceText(txt){
    if (!txt) return 0;
    var cleaned = String(txt).replace(/[₱PHPphp]/g,'').replace(/,/g,'');
    var m = cleaned.match(/(\d+(?:\.\d+)?)/);
    return m ? Number(m[1]) : 0;
  }
  function findPrice(card){
    if (!card) return 0;
    var el = card.querySelector('.service-price')
          || card.querySelector('.cleaning-price')
          || card.querySelector('.price')
          || card.querySelector('[class*="price"]');
    return parsePriceText(el ? el.textContent : '');
  }
  function cardTitle(card){
    if (!card) return '';
    var el = card.querySelector('.service-content h3')
      || card.querySelector('.service-title')
      || card.querySelector('h3')
      || card.querySelector('.house-title')
      || card.querySelector('.card-title');
    return normalizeText(el ? el.textContent : '');
  }
  function cardDetail(card){
    if (!card) return '';
    var el = card.querySelector('.service-content p:not(.price)')
      || card.querySelector('.service-description')
      || card.querySelector('.desc')
      || card.querySelector('p');
    var txt = normalizeText(el ? el.textContent : '');
    if (!txt) return '';
    if (txt.length > 140) txt = txt.slice(0, 140) + '…';
    return txt;
  }
  function itemText(card){
    var subcat = activeSubcategory();
    var title = cardTitle(card);
    var price = findPrice(card);
    var detail = cardDetail(card);
    var parts = [subcat && title ? (subcat + ' - ' + title) : (title || subcat || '')];
    var tail = [];
    if (price) tail.push('₱' + Number(price).toFixed(2));
    if (detail) tail.push(detail);
    if (tail.length) parts.push(tail.join(' • '));
    return parts.join(' — ');
  }
  function activeSubcategory(){
    var li = document.querySelector('.subcategory-nav li.active');
    var btn = document.querySelector('.subcategory-btn');
    return normalizeText((li && li.textContent) || (btn && btn.textContent) || 'Selected Services');
  }

  function convertRadiosToCheckboxes(){
    var inputs = Array.prototype.slice.call(document.querySelectorAll(
      '.service-card input[type="radio"], .cleaning-card input[type="radio"], .cleaning-package input[type="radio"], label.service-card input[type="radio"], .card input[type="radio"], .house-card input[type="radio"], .garden-card input[type="radio"], .service-radio, .cleaning-radio, .package-radio, input[type="radio"][name="tech"], input[type="radio"][name="garden"]'
    ));
    if (!inputs.length) return false;
    inputs.forEach(function(r){
      try {
        var wasChecked = !!r.checked;
        r.type = 'checkbox';
        if (wasChecked) r.checked = false;
      } catch(e) {}
    });
    return true;
  }

  function ensureActions(){
    if (document.querySelector('.ht-multi-actions')) return;
    var container = document.querySelector('.services-container') || document.querySelector('main') || document.body;
    if (!container) return;
    var wrap = document.createElement('div');
    wrap.className = 'ht-multi-actions';
    wrap.innerHTML = '<div class="ht-selected"><div class="ht-selected-label">Selected (0)</div><div class="ht-selected-list"></div></div><button class="ht-proceed">Proceed</button><div class="ht-total">Total: ₱0.00</div>';
    container.appendChild(wrap);

    var style = document.createElement('style');
    style.textContent = [
      '.ht-multi-actions{position:fixed;right:18px;bottom:18px;display:flex;gap:10px;align-items:center;z-index:1000}',
      '.ht-multi-actions .ht-proceed{background:#00c4cc;color:#fff;border:none;border-radius:8px;padding:10px 14px;font-weight:600;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.2)}',
      '.ht-multi-actions .ht-total{background:#fff;border:2px solid #00c4cc;color:#333;border-radius:8px;padding:8px 12px;font-weight:600;box-shadow:0 2px 8px rgba(0,0,0,0.1)}',
      '.ht-multi-actions .ht-selected{background:#fff;border:2px solid #00c4cc;color:#333;border-radius:8px;max-width:280px;max-height:200px;overflow:auto;padding:8px 12px;box-shadow:0 2px 8px rgba(0,0,0,0.1)}',
      '.ht-multi-actions .ht-selected-label{font-weight:700;margin-bottom:6px}',
      '.ht-multi-actions .ht-selected-list{display:flex;flex-direction:column;gap:4px}',
      '.ht-multi-actions .ht-selected-list .ht-item{font-size:13px;line-height:1.2;border-bottom:1px dashed #e5e5e5;padding-bottom:4px}',
      '.service-card input[type="checkbox"]{width:18px;height:18px;margin:10px;accent-color:#00c4cc;}'
    ].join('\n');
    document.head.appendChild(style);
  }

  function renderTotal(){
    var totalEl = document.querySelector('.ht-multi-actions .ht-total');
    if (!totalEl) return;
    var checks = Array.prototype.slice.call(document.querySelectorAll('.service-card input[type="checkbox"]:checked, .cleaning-card input[type="checkbox"]:checked, .cleaning-package input[type="checkbox"]:checked, label.service-card input[type="checkbox"]:checked, .card input[type="checkbox"]:checked, .house-card input[type="checkbox"]:checked, .garden-card input[type="checkbox"]:checked, input[type="checkbox"].service-radio:checked, input[type="checkbox"].cleaning-radio:checked, input[type="checkbox"].package-radio:checked'));
    var sum = checks.reduce(function(acc, c){ var card = c.closest('.service-card, .cleaning-card, .cleaning-package, .card, label.service-card, .house-card, .garden-card'); return acc + findPrice(card); }, 0);
    totalEl.textContent = 'Total: ₱' + Number(sum||0).toFixed(2);
    var labelEl = document.querySelector('.ht-multi-actions .ht-selected-label');
    var listEl = document.querySelector('.ht-multi-actions .ht-selected-list');
    if (labelEl && listEl) {
      var items = checks.map(function(c){ var card = c.closest('.service-card, .cleaning-card, .cleaning-package, .card, label.service-card, .house-card'); return itemText(card); });
      labelEl.textContent = 'Selected (' + String(items.length) + ')';
      listEl.innerHTML = items.map(function(t){ return '<div class="ht-item">' + String(t) + '</div>'; }).join('');
    }
  }

  function persistSelectionAndProceed(){
    var checks = Array.prototype.slice.call(document.querySelectorAll('.service-card input[type="checkbox"]:checked, .cleaning-card input[type="checkbox"]:checked, .cleaning-package input[type="checkbox"]:checked, label.service-card input[type="checkbox"]:checked, .card input[type="checkbox"]:checked, .house-card input[type="checkbox"]:checked, .garden-card input[type="checkbox"]:checked, input[type="checkbox"].service-radio:checked, input[type="checkbox"].cleaning-radio:checked, input[type="checkbox"].package-radio:checked'));
    if (!checks.length){ alert('Please select at least one service.'); return; }
    var items = checks.map(function(c){ var card = c.closest('.service-card, .cleaning-card, .cleaning-package, .card, label.service-card, .house-card, .garden-card'); return itemText(card); });
    var total = checks.reduce(function(acc, c){ var card = c.closest('.service-card, .cleaning-card, .cleaning-package, .card, label.service-card, .house-card, .garden-card'); return acc + findPrice(card); }, 0);
    try {
      localStorage.setItem('selected_service_name', 'Multiple Services');
      localStorage.setItem('selected_services_names', JSON.stringify(items));
      localStorage.setItem('selected_service_price', String(total));
    } catch(e) {}
    var nextUrl = '/booking_process/booking_location.php?service=' + encodeURIComponent('Multiple Services') + '&price=' + encodeURIComponent(String(total));
    window.location.href = nextUrl;
  }

  function init(){
    var hasCards = !!document.querySelector('.service-card input[type="radio"], .cleaning-card input[type="radio"], .cleaning-package input[type="radio"], label.service-card input[type="radio"], .card input[type="radio"], .house-card input[type="radio"], .service-radio, .cleaning-radio, .package-radio, input[type="radio"][name="tech"]');
    if (!hasCards) return;
    var converted = convertRadiosToCheckboxes();
    if (!converted) return;
    ensureActions();
    renderTotal();
    // Intercept legacy radio handlers
    document.addEventListener('click', function(ev){
      var t = ev.target;
      if (t && t.tagName === 'INPUT' && String(t.type).toLowerCase() === 'checkbox' && t.closest('.service-card, .cleaning-card, .cleaning-package, .card, label.service-card, .house-card')) {
        try { ev.stopImmediatePropagation(); } catch(e){}
      }
    }, true);
    document.addEventListener('change', function(ev){
      var t = ev.target;
      if (t && t.tagName === 'INPUT' && String(t.type).toLowerCase() === 'checkbox') {
        try { ev.stopImmediatePropagation(); } catch(e){}
        renderTotal();
      }
    }, true);
    var btn = document.querySelector('.ht-proceed');
    if (btn) btn.addEventListener('click', persistSelectionAndProceed);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
