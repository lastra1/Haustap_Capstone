<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cleaning Services - Homi</title>
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/cleaning.css">
    <link rel="stylesheet" href="css/responsive.css">
<link rel="stylesheet" href="/client/css/homepage.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
    <!-- Header -->
    <?php include dirname(__DIR__) . "/client/includes/header.php"; ?>

    <!-- Main Content -->
    <main class="cleaning-container">
        <section class="type-selector">
            <h2>Type of Cleaning</h2>
            <select>
                <option value="bungalow">Bungalow</option>
                <option value="condo">Condominium</option>
                <option value="duplex">Duplex</option>
                <option value="hotel">Hotel</option>
                <option value="Motel">Motel</option>
                <option value="Container House">Container House</option>
                <option value="Stilt">Stilt House</option>
                <option value="Mansion">Mansion</option>
                <option value="Villa">Villa</option>
            </select>
        </section>

        <!-- Cleaning Packages -->
        <section class="cleaning-packages">
            <!-- Basic Cleaning -->
            <div class="cleaning-package">
                <div class="package-header">
                    <h3>
                        <span class="package-title">Basic Cleaning - 1 Cleaner</span>
                        <input type="radio" name="cleaning-package" value="basic" class="package-radio">
                    </h3>
                    <span class="price">₱1,000</span>
                </div>
                <div class="package-details">
                    <p>Inclusions:</p>
                    <ul>
                        <li>Living Room: walls, mop, dusting furniture, trash removal</li>
                        <li>Bedroom: bed making, sweeping, dusting, trash removal</li>
                        <li>Hallways: mop & sweep, remove cobwebs</li>
                        <li>Windows & Mirrors: quick wipe</li>
                    </ul>
                </div>
            </div>

            <!-- Standard Cleaning -->
            <div class="cleaning-package">
                <div class="package-header">
                    <h3>
                        <span class="package-title">Standard Cleaning - 2 Cleaners</span>
                        <input type="radio" name="cleaning-package" value="standard" class="package-radio">
                    </h3>
                    <span class="price">₱2,000</span>
                </div>
                <div class="package-details">
                    <p>Inclusions:</p>
                    <ul>
                        <li>All Basic Cleaning tasks plus:</li>
                        <li>Kitchen: wipe countertops, sink cleaning, stove top degrease, trash removal</li>
                        <li>Bathroom: cleaning all surfaces, shower, floor disinfecting</li>
                        <li>Furniture: dusting under/behind furniture</li>
                        <li>Windows & Mirrors: full wipe & polish</li>
                    </ul>
                </div>
            </div>

            <!-- Deep Cleaning -->
            <div class="cleaning-package">
                <div class="package-header">
                    <h3>
                        <span class="package-title">Deep Cleaning - 3 Cleaners</span>
                        <input type="radio" name="cleaning-package" value="deep" class="package-radio">
                    </h3>
                    <span class="price">₱3,000</span>
                </div>
                <div class="package-details">
                    <p>Inclusions:</p>
                    <ul>
                        <li>All Standard Cleaning tasks plus:</li>
                        <li>Flooring: scrubbing stains/grout, polishing if applicable</li>
                        <li>Appliances: defrost refrigerator, oven, washing machine</li>
                        <li>Cabinet tops: dusting and cleaning</li>
                        <li>Disinfection: doorknobs, switches, high-touch surfaces</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Pagination -->
        <div class="pagination">
            <button>&lt;</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button>4</button>
            <button>5</button>
            <button>&gt;</button>
        </div>

        <p class="cleaning-note">Cleaning materials are provided by the client</p>
    </main>

     <!-- FOOTER -->
  <?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>
  <script>
    // Booking flow for cleaning packages page: persist label and route with params
    document.addEventListener('DOMContentLoaded', function () {
      function hasToken(){
        try { return !!localStorage.getItem('haustap_token'); } catch(e){ return false; }
      }
      const houseSelect = document.querySelector('.type-selector select');
      const packageRadios = document.querySelectorAll('input.package-radio');
      const pagination = document.querySelector('.pagination');
      const nextBtn = pagination ? pagination.querySelector('button:last-child') : null;

      function getSelectedRadio() {
        return document.querySelector('input.package-radio:checked');
      }

      function getCleaningType() {
        const r = getSelectedRadio();
        return r ? r.value : null; // values: basic | standard | deep
      }

      function getHouseSlug() {
        const v = houseSelect ? (houseSelect.value || '').trim() : '';
        return v.toLowerCase().replace(/\s+/g, '-');
      }

      function getPackageTitle() {
        const r = getSelectedRadio();
        const pkg = r ? r.closest('.cleaning-package') : null;
        const titleEl = pkg ? pkg.querySelector('.package-title') : null;
        return titleEl ? titleEl.textContent.trim() : '';
      }

      function persistLabel() {
        const houseText = houseSelect ? (houseSelect.options[houseSelect.selectedIndex]?.text || '').trim() : '';
        const pkgTitle = getPackageTitle();
        const label = houseText && pkgTitle ? `${houseText} - ${pkgTitle}` : houseText || pkgTitle;
        try { localStorage.setItem('selected_service_name', label); } catch (e) {}
      }

      function parsePriceText(txt) {
        const cleaned = String(txt || '').replace(/,/g, '');
        const m = cleaned.match(/(\d+(?:\.\d+)?)/);
        return m ? Number(m[1]) : null;
      }
      function persistPrice() {
        const r = getSelectedRadio();
        const pkg = r ? r.closest('.cleaning-package') : null;
        const p = pkg ? pkg.querySelector('.price') : null;
        const price = p ? parsePriceText(p.textContent) : null;
        try {
          if (price != null && !isNaN(price)) {
            localStorage.setItem('selected_service_price', String(price));
          }
        } catch (e) {}
      }

      packageRadios.forEach(radio => {
        radio.addEventListener('change', () => {
          // Persist and immediately redirect on selection
          persistLabel();
          // get price for query param pass-through
          const r = getSelectedRadio();
          const pkg = r ? r.closest('.cleaning-package') : null;
          const pEl = pkg ? pkg.querySelector('.price') : null;
          const pVal = pEl ? parsePriceText(pEl.textContent) : null;
          persistPrice();
          const type = getCleaningType();
          const house = getHouseSlug();
          if (type) {
            // Guests stay on this page after selecting; proceed via Next
            // Logged-in users proceed immediately
            if (hasToken()) {
              let url = `/booking_process/booking_location.php?house=${encodeURIComponent(house)}&cleaning=${encodeURIComponent(type)}`;
              if (pVal != null && !isNaN(pVal)) { url += `&price=${encodeURIComponent(String(pVal))}`; }
              window.location.href = url;
            }
          }
        });
      });

      if (houseSelect) {
        houseSelect.addEventListener('change', () => {
          // Refresh label if a package is already selected
          if (getSelectedRadio()) persistLabel();
        });
      }

      if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
          e.preventDefault();
          const type = getCleaningType();
          const house = getHouseSlug();
          if (!type) {
            alert('Please select a cleaning package first.');
            return;
          }
          persistLabel();
          // get price for query param pass-through
          const r = getSelectedRadio();
          const pkg = r ? r.closest('.cleaning-package') : null;
          const pEl = pkg ? pkg.querySelector('.price') : null;
          const pVal = pEl ? parsePriceText(pEl.textContent) : null;
          persistPrice();
          let url = `/booking_process/booking_location.php?house=${encodeURIComponent(house)}&cleaning=${encodeURIComponent(type)}`;
          if (pVal != null && !isNaN(pVal)) { url += `&price=${encodeURIComponent(String(pVal))}`; }
          if (!hasToken()) {
            window.location.href = '/login';
            return;
          }
          window.location.href = url;
        });
      }
    });
  </script>
</body>
</html>


