<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Cleaning Services | Homi</title>
  <link rel="stylesheet" href="/Homecleaning/css/indoor-cleaning.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/client/css/homepage.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
<?php include dirname(__DIR__) . "/client/includes/header.php"; ?>
  <main>
    <h1 class="main-title">Cleaning Services</h1>
    <button class="subcategory-btn">SUBCATEGORY</button>
    <div class="centered-section">
        <div class="breadcrumbs">
      <a href="/services/cleaning" aria-current="page">Home cleaning</a>
      <span> | </span>
      <a href="/services/cleaning/ac">AC cleaning</a>
      <span> | </span>
      <a href="/services/cleaning/ac-deep">AC Deep Cleaning (Chemical Cleaning)</a>
    </div>
      <div class="section-title">Type of House</div>
      <section class="house-group">
        <h2>Bungalow</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="bungalow">
            <label for="bungalow" class="radio-label"></label>
            <div class="house-title">Bungalow</div>
            <div class="house-desc">80-120 sqm<br>Single-story with wider living spaces, ideal for families.</div>
          </div>
        </div>
        <h2>Condominium</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="condo-studio">
            <label for="condo-studio" class="radio-label"></label>
            <div class="house-title">Condominium Studio / 1BR</div>
            <div class="house-desc">20-50 sqm<br>For singles, couples, or small families.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="condo-2br">
            <label for="condo-2br" class="radio-label"></label>
            <div class="house-title">Condominium 2BR</div>
            <div class="house-desc">60-100 sqm<br>2-bedroom units for small families, can add maid's room.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="condo-penthouse">
            <label for="condo-penthouse" class="radio-label"></label>
            <div class="house-title">Condominium Penthouse</div>
            <div class="house-desc">&gt;150 sqm<br>Luxury units at the top floor with variable, roomy unit sizes.</div>
          </div>
        </div>
        <h2>Duplex</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="duplex-sm">
            <label for="duplex-sm" class="radio-label"></label>
            <div class="house-title">Duplex</div>
            <div class="house-desc">Elevated 60-100 sqm<br>Shared wall, two separate entrances under one roof.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="duplex-lg">
            <label for="duplex-lg" class="radio-label"></label>
            <div class="house-title">Duplex</div>
            <div class="house-desc">Larger 120-200 sqm<br>2-storey duplex units with more functional areas.</div>
          </div>
        </div>
        <h2>Hotel</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="hotel-sm">
            <label for="hotel-sm" class="radio-label"></label>
            <div class="house-title">Hotel</div>
            <div class="house-desc">Suite (15-50 sqm)<br>Hotel rooms or suites with all guest areas.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="hotel-lg">
            <label for="hotel-lg" class="radio-label"></label>
            <div class="house-title">Hotel</div>
            <div class="house-desc">Suite (50-150 sqm)<br>Hotel suites with more entertaining and guest areas.</div>
          </div>
        </div>
        <h2>Motel</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="motel-sm">
            <label for="motel-sm" class="radio-label"></label>
            <div class="house-title">Motel</div>
            <div class="house-desc">Standard Room (15-30 sqm)<br>Basic lodging. Usually single room and bath.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="motel-lg">
            <label for="motel-lg" class="radio-label"></label>
            <div class="house-title">Motel</div>
            <div class="house-desc">Larger Room (30-60 sqm)<br>A lodging larger room with more unit amenities.</div>
          </div>
        </div>
        <h2>Container House</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="container-sm">
            <label for="container-sm" class="radio-label"></label>
            <div class="house-title">Container House</div>
            <div class="house-desc">Single (20-40 sqm)<br>Single modular prefab, suitable urban starter type.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="container-lg">
            <label for="container-lg" class="radio-label"></label>
            <div class="house-title">Container House</div>
            <div class="house-desc">Multiple (40-120 sqm)<br>Modular designs for combined families with more amenities.</div>
          </div>
        </div>
        <h2>Stilt House</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="stilt-sm">
            <label for="stilt-sm" class="radio-label"></label>
            <div class="house-title">Stilt House</div>
            <div class="house-desc">Small (30-60 sqm)<br>Raised structure, usually for shore or coastal areas.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="stilt-lg">
            <label for="stilt-lg" class="radio-label"></label>
            <div class="house-title">Stilt House</div>
            <div class="house-desc">Large (100-200 sqm)<br>Houses with more living and bathing areas.</div>
          </div>
        </div>
        <h2>Mansion</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="mansion-sm">
            <label for="mansion-sm" class="radio-label"></label>
            <div class="house-title">Mansion</div>
            <div class="house-desc">Small (150-300 sqm)<br>Luxury house usually with luxury features and staff rooms.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="mansion-lg">
            <label for="mansion-lg" class="radio-label"></label>
            <div class="house-title">Mansion</div>
            <div class="house-desc">Larger (300-1000 sqm)<br>Luxury mansion with more entertaining, staff and bath areas.</div>
          </div>
        </div>
        <h2>Villa</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="villa-sm">
            <label for="villa-sm" class="radio-label"></label>
            <div class="house-title">Villa</div>
            <div class="house-desc">Villa (100-250 sqm)<br>Standalone house with wider garden or garden + pool.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="villa-lg">
            <label for="villa-lg" class="radio-label"></label>
            <div class="house-title">Villa</div>
            <div class="house-desc">Larger (250-1000 sqm)<br>Luxury villa with more entertaining, bath and staff rooms.</div>
          </div>
        </div>
      </section>
    </div>
    <nav class="pagination">
      <ul>
        <li><a href="#" aria-label="Previous">&laquo;</a></li>
        
        
        
        
        
        <li><a href="#" aria-label="Next">&raquo;</a></li>
      </ul>
    </nav>
  </main>
  <!-- FOOTER -->
  <?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>
  <script>
  // Route Next arrow to the selected house type page
  document.addEventListener('DOMContentLoaded', function () {
    const nextLink = document.querySelector('nav.pagination a[aria-label="Next"]');
    const radios = document.querySelectorAll('input.house-radio');

    // Map radio IDs to their house-specific pages for cleaning type selection
    const routeMap = {
      'bungalow': '/Homecleaning/bungalow.php',
      'condo-studio': '/Homecleaning/condo_studio.php',
      'condo-2br': '/Homecleaning/condo_2br.php',
      'condo-penthouse': '/Homecleaning/penthouse.php',
      'duplex-sm': '/Homecleaning/duplex_smaller.php',
      'duplex-lg': '/Homecleaning/duplex_larger.php',
      'hotel-sm': '/Homecleaning/hotel_standard.php',
      'hotel-lg': '/Homecleaning/hotel_suite.php',
      'motel-sm': '/Homecleaning/motel_standard.php',
      'motel-lg': '/Homecleaning/motel_large.php',
      'container-sm': '/Homecleaning/house_container_single.php',
      'container-lg': '/Homecleaning/house_container_multiple.php',
      'stilt-sm': '/Homecleaning/Stilt_house_small.php',
      'stilt-lg': '/Homecleaning/Stilt_house_large.php',
      'mansion-sm': '/Homecleaning/Mansion_small.php',
      'mansion-lg': '/Homecleaning/mansion_larger.php',
      'villa-sm': '/Homecleaning/Villa_smaller.php',
      'villa-lg': '/Homecleaning/villa_larger.php',
    };

    function getSelectedRoute() {
      const checked = document.querySelector('input.house-radio:checked');
      if (!checked) return null;
      return routeMap[checked.id] || null;
    }

    // Keep href refreshed when selection changes
    radios.forEach(r => {
      r.addEventListener('change', () => {
        const route = getSelectedRoute();
        nextLink.setAttribute('href', route || '#');
        // Navigate immediately when a house type is selected
        if (route) {
          window.location.href = route;
        }
      });
    });

    nextLink.addEventListener('click', function (e) {
      const route = getSelectedRoute();
      if (!route) {
        e.preventDefault();
        alert('Please select a house type first.');
        return;
      }
      e.preventDefault();
      window.location.href = route;
    });
  });
  </script>
</body>
</html>


