<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gardening Services - Haustap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/Gardening-medium.css">
<link rel="stylesheet" href="/client/css/homepage.css"></head>
<body>
<?php include dirname(__DIR__) . "/client/includes/header.php"; ?>

    <main>
        <h1 class="section-title">Type of Gardening</h1>
        
        <div class="garden-type">
            <span class="garden-type-badge">Medium Garden</span>
        </div>

        <h2 class="subtitle">Gardening & Landscaping</h2>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-header">
                    <div>
                        <h3 class="service-title">Inspection</h3>
                        <p class="service-price">â‚±300</p>
                        <p class="service-note">Additional fee per gardener for inspection</p>
                    </div>
                    <div class="service-icon">
                        <input type="radio" name="service" value="inspection">
                    </div>
                </div>
                <div class="inclusions">
                    <p>Inspection for gardening and landscaping involves assessing the site's soil quality, drainage, and overall layout to ensure it meets healthy plant growth. It also helps identify any preparations or adjustments needed before starting the project for optimal results.</p>
                </div>
            </div>

            <div class="service-card">
                <div class="service-header">
                    <div>
        <h3 class="service-title">Basic &ndash; 1 gardener</h3>
                        <p class="service-price">â‚±600</p>
                    </div>
                    <div class="service-icon">
                        <input type="radio" name="service" value="basic">
                    </div>
                </div>
                <div class="inclusions">
                    <p class="inclusions-title">Inclusions:</p>
                    <ul>
                        <li>Lawn mowing / trimming</li>
                        <li>Removing wilted leaves</li>
                        <li>Watering & basic upkeep</li>
                    </ul>
                </div>
            </div>

            <div class="service-card">
                <div class="service-header">
                    <div>
        <h3 class="service-title">Standard &ndash; 2 gardeners</h3>
                        <p class="service-price">â‚±1,200</p>
                    </div>
                    <div class="service-icon">
                        <input type="radio" name="service" value="standard">
                    </div>
                </div>
                <div class="inclusions">
                    <p class="inclusions-title">Inclusions:</p>
                    <ul>
                        <li>All Basic tasks</li>
                        <li>Hedge & shrub trimming</li>
                        <li>Soil cultivation & fertilization</li>
                        <li>Flower bed maintenance</li>
                    </ul>
                </div>
            </div>

            <div class="service-card">
                <div class="service-header">
                    <div>
        <h3 class="service-title">Deep &ndash; 3 gardeners</h3>
                        <p class="service-price">â‚±2,100</p>
                    </div>
                    <div class="service-icon">
                        <input type="radio" name="service" value="deep">
                    </div>
                </div>
                <div class="inclusions">
                    <p class="inclusions-title">Inclusions:</p>
                    <ul>
                        <li>All Standard tasks</li>
                        <li>Lawn care (mow, edge, fertilize)</li>
                        <li>Tree/shrub pruning</li>
                        <li>Landscaping touch-up (arrangement, mulch, stones)</li>
                        <li>Waste disposal</li>
                    </ul>
                </div>
            </div>
        </div>

        <p class="materials-note">*Materials are provided by the client</p>
    </main>

     <!-- FOOTER -->
  <?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>
<script>
(function () {
  function getText(el, sel) {
    var node = el ? el.querySelector(sel) : null;
    return node ? (node.textContent || '').trim() : '';
  }
  function parsePriceText(txt){
    var cleaned = String(txt||'').replace(/,/g,'');
    var m = cleaned.match(/(\d+(?:\.\d+)?)/);
    return m ? Number(m[1]) : null;
  }
  document.addEventListener('change', function (e) {
    var target = e.target;
    if (target && target.matches('input[type=\"radio\"][name=\"service\"]')) {
      var card = target.closest('.service-card');
      var serviceTitle = getText(card, '.service-title') || (target.value || '').trim();
      var subtypeEl = document.querySelector('.garden-type-badge');
      var subcategory = subtypeEl ? (subtypeEl.textContent || '').trim() : 'Gardening & Landscaping';
      var label = subcategory + ' - ' + serviceTitle;
      try {
        localStorage.setItem('selected_service_name', label);
        var pEl = card ? card.querySelector('.service-price') : null;
        var price = pEl ? parsePriceText(pEl.textContent) : null;
        if (price != null && !isNaN(price)) {
          localStorage.setItem('selected_service_price', String(price));
        }
      } catch (err) {}
      var nextUrl = '/booking_process/booking_location.php?service=' + encodeURIComponent(label);
      var pEl2 = card ? card.querySelector('.service-price') : null;
      var price2 = pEl2 ? parsePriceText(pEl2.textContent) : null;
      if (price2 != null && !isNaN(price2)) { nextUrl += '&price=' + encodeURIComponent(String(price2)); }
      window.location.href = nextUrl;
    }
  });
})();
</script>
</body>
</html>



