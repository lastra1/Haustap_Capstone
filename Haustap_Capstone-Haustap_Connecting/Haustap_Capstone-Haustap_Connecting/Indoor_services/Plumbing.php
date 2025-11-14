<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Indoor Services | Plumbing | Homi</title>
  <link rel="stylesheet" href="css/indoor-services.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/client/css/homepage.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
<?php include dirname(__DIR__) . "/client/includes/header.php"; ?>
  <main>
    <h1 class="main-title">Indoor Services</h1>
    <button class="subcategory-btn">SUBCATEGORY</button>
    <div class="tabs">
      <span class="tab">Handyman</span>
      <span class="tab active">Plumbing</span>
      <span class="tab">Electrical</span>
      <span class="tab">Appliance Repair</span>
      <span class="tab">Pest Control</span>
    </div>
    <div class="services-container">
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="inspection-fee">
        <label for="inspection-fee" class="radio-label"></label>
        <div class="service-title">Inspection</div>
        <div class="service-price">₱300</div>
        <div class="service-details">
          Individually by a plumber.<br>
          On-site assessment of needs.<br>
          Recommendations for repair/solutions.<br>
          <strong>No actual repair or installation included</strong>
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="faucet-leak">
        <label for="faucet-leak" class="radio-label"></label>
        <div class="service-title">Faucet leak repair</div>
        <div class="service-price">₱350 per unit</div>
        <div class="service-details">
          Inspection of faucet leaks (washer, cartridge, or small issue).<br>
          Leak troubleshooting, washer replacement.<br>
          Replacement faucet not included.
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="pipe-leak">
        <label for="pipe-leak" class="radio-label"></label>
        <div class="service-title">Pipe leak repair</div>
        <div class="service-price">₱600 per unit</div>
        <div class="service-details">
          Location & assessment of pipe leak.<br>
          Basic pipe patch/short-term joint repair.<br>
          Pipe replacement/parts not included.
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="clogged-sink">
        <label for="clogged-sink" class="radio-label"></label>
        <div class="service-title">Clogged sink / Drain cleaning</div>
        <div class="service-price">₱500 per unit</div>
        <div class="service-details">
          Check and remove debris/blockage.<br>
          Use of manual tools/temporary fix if needed.<br>
          Water flow test after cleaning.
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="toilet-bowl">
        <label for="toilet-bowl" class="radio-label"></label>
        <div class="service-title">Toilet bowl clog removal</div>
        <div class="service-price">₱650 per unit</div>
        <div class="service-details">
          Verification of blockage.<br>
          Manual unclogging by use of auger/pump.<br>
          Flushing test to ensure flow.
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="toilet-flush">
        <label for="toilet-flush" class="radio-label"></label>
        <div class="service-title">Toilet flush repair/ replacement</div>
        <div class="service-price">₱700 per unit</div>
        <div class="service-details">
          Inspection, mechanism failure, handle, tank parts.<br>
          Repair and/or replacement of faulty parts.<br>
          Replacement parts not included.
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="shower-head">
        <label for="shower-head" class="radio-label"></label>
        <div class="service-title">Shower head installation / replacement</div>
        <div class="service-price">₱400 per unit</div>
        <div class="service-details">
          Installation of new shower head (if any).<br>
          Removal of old shower head.<br>
          Water pressure test to ensure function.
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="siphon-trap">
        <label for="siphon-trap" class="radio-label"></label>
        <div class="service-title">Siphon / Trap replacement</div>
        <div class="service-price">₱500 per panel/part</div>
        <div class="service-details">
          Installation of all siphon or trap (sink or toilet).<br>
          Leak test after replacement.
        </div>
      </div>
    </div>
  </main>
  <!-- FOOTER -->
  <?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>
  <script>
    // When a service option is selected, store a clear label and proceed
    document.addEventListener('DOMContentLoaded', function(){
      var radios = Array.prototype.slice.call(document.querySelectorAll('input.service-radio'));
      var activeTab = document.querySelector('.tabs .tab.active');

      function normalizeLabel(txt){
        return String(txt||'').replace(/\s+/g,' ').trim();
      }
      function parsePriceText(txt){
        var cleaned = String(txt||'').replace(/,/g,'');
        var m = cleaned.match(/(\d+(?:\.\d+)?)/);
        return m ? Number(m[1]) : null;
      }

      radios.forEach(function(r){
        r.addEventListener('change', function(){
          var card = r.closest('.service-card');
          var titleEl = card ? card.querySelector('.service-title') : null;
          var subcat = activeTab ? normalizeLabel(activeTab.textContent) : 'Plumbing';
          var serviceTitle = titleEl ? normalizeLabel(titleEl.textContent) : '';
          var label = subcat + ' - ' + serviceTitle;
          try {
            localStorage.setItem('selected_service_name', label);
            var pEl = card ? card.querySelector('.service-price') : null;
            var price = pEl ? parsePriceText(pEl.textContent) : null;
            if (price != null && !isNaN(price)) {
              localStorage.setItem('selected_service_price', String(price));
            }
          } catch(e){}
          var url = '/booking_process/booking_location.php?service=' + encodeURIComponent(label);
          var pEl2 = card ? card.querySelector('.service-price') : null;
          var price2 = pEl2 ? parsePriceText(pEl2.textContent) : null;
          if (price2 != null && !isNaN(price2)) { url += '&price=' + encodeURIComponent(String(price2)); }
          window.location.href = url;
        });
      });
    });
  </script>
</body>
</html>


