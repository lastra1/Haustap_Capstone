<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mobile Phone</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/tech_gadget/css/mobile_phone.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="/client/css/homepage.css"></head>

<body>
  <!-- HEADER -->
    <?php include dirname(__DIR__) . "/client/includes/header.php"; ?>

  <!-- MAIN CONTENT -->
  <main>
  <h1 class="main-title">Tech & Gadget</h1>
  <button class="subcategory-btn">SUBCATEGORY</button>

  <!-- Subcategory Navigation -->
  <nav class="subcategory-nav">
    <ul>
      <li class="active">Mobile Phone</li>
  <li><a href="/tech_gadget/laptop_desktop.php">Laptop & Desktop PC</a></li>
      <li><a href="/tech_gadget/tablet_ipad.php">Tablet & iPad</a></li>
      <li><a href="/tech_gadget/game_console.php">Game & Console</a></li>
    </ul>
  </nav>

  <div class="services-container">
    <section class="service-section">
      <div class="service-grid">
        <label class="service-card">
          <input type="radio" name="tech" checked />
          <div class="service-content">
            <h3>Charging Port Repair - iOS</h3>
            <p class="price">â‚±600 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Detailed check of charging dock/port<br>
              Cleaning or replacement of faulty port<br>
              Re-soldering and alignment adjustments<br>
              Charging and data transfer test
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Screen Replacement - Android</h3>
            <p class="price">â‚±500 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Removal of broken/damaged screen<br>
              Installation of replacement screen (customer-provided or stock)<br>
              Functionality test for touch and display<br>
              Basic cleaning of device exterior
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Screen Replacement - iOS</h3>
            <p class="price">â‚±700 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Safe removal of damaged screen<br>
              Installation of replacement screen<br>
              Touch responsiveness and display quality test<br>
              Device assembly and sealing check
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Battery Replacement - Android</h3>
            <p class="price">â‚±300 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Removal of old/non-working battery<br>
              Installation of new battery (customer-provided or stock)<br>
              Power-on and charging function test<br>
              Proper disposal of defective battery
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Battery Replacement - iOS</h3>
            <p class="price">â‚±500 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Safe removal of swollen/damaged battery<br>
              Installation of new battery<br>
              Power, charging, and battery health check<br>
              Device reassembly with secure fitting
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Charging Port Repair - Android</h3>
            <p class="price">â‚±400 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Diagnosis of charging port issue<br>
              Cleaning or replacement of charging port<br>
              Soldering work (if required)<br>
              Testing for charging stability and USB connection
            </p>
          </div>
        </label>
      </div>
    </section>
  </div>
</main>


  <!-- FOOTER -->
  <?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      var radios = Array.prototype.slice.call(document.querySelectorAll('input[type="radio"][name="tech"]'));
      var activeSubcat = document.querySelector('.subcategory-nav li.active');
      function normalizeLabel(txt){ return String(txt||'').replace(/\s+/g,' ').trim(); }
      function buildLabel(card){
        var titleEl = card ? card.querySelector('.service-content h3') : null;
        var subcat = activeSubcat ? normalizeLabel(activeSubcat.textContent) : 'Tech & Gadget';
        var serviceTitle = titleEl ? normalizeLabel(titleEl.textContent) : '';
        return subcat + ' - ' + serviceTitle;
      }
      function proceed(card){
        var label = buildLabel(card);
        try { localStorage.setItem('selected_service_name', label); } catch(e){}
        window.location.href = '/booking_process/booking_location.php?service=' + encodeURIComponent(label);
      }
      radios.forEach(function(r){
        r.addEventListener('change', function(){ proceed(r.closest('.service-card')); });
        r.addEventListener('click', function(){ if (r.checked) proceed(r.closest('.service-card')); });
      });
    });
  </script>
</body>
</html>




