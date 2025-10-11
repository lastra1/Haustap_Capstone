<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Indoor Services | Plumbing | Homi</title>
  <link rel="stylesheet" href="css/indoor-services.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="#"><img src="images/logo.png" alt="Haustap Logo"></a>
    </div>
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#">Bookings</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </nav>
    <div class="header-right">
      <div class="search-box">
        <input type="text" placeholder="Search services">
        <i class="fa fa-search"></i>
      </div>
      <a href="#" class="account-link">
        <i class="fa fa-user account-icon"></i>
        My Account
      </a>
    </div>
  </header>
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
        <div class="service-title">Inspection Fee</div>
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
        <input type="radio" name="service" class="service-radio" id="water-heater">
        <label for="water-heater" class="radio-label"></label>
        <div class="service-title">Water heater installation - Basic</div>
        <div class="service-price">₱1,500 per unit</div>
        <div class="service-details">
          Basic installation of heater unit.<br>
          Connection of water lines to water line.<br>
          Leak & functionality checks.<br>
          Electrical wiring not included (separate fee).
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="pipe-install">
        <label for="pipe-install" class="radio-label"></label>
        <div class="service-title">Pipe installation - New connection</div>
        <div class="service-price">₱200 per unit</div>
        <div class="service-details">
          Installation of short pipes (any kind, faucet connection).<br>
          Testing of water flow.<br>
          Water pressure test.
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
  <footer>
    <div class="footer-content">
      <!-- Left Section -->
      <div class="footer-left">
        <h4>ABOUT HausTap</h4>
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Policies</a></li>
          <li><a href="#">Our Sitemap</a></li>
          <li><a href="#">Our Services</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Testimonials</a></li>
        </ul>
      </div>

      <!-- Center Section -->
      <div class="footer-center">
        <img src="images/logo.png" alt="HausTap Logo" />
        <p>Your space. Your peace. Your Glow</p>
      </div>

      <!-- Right Section -->
      <div class="footer-right">
        <h4>FOLLOW US</h4>
        <ul>
          <li><i class="fab fa-facebook-f"></i> Facebook</li>
          <li><i class="fab fa-instagram"></i> Instagram</li>
          <li><i class="fab fa-twitter"></i> Twitter</li>
        </ul>
        <div class="contact-info">
          <p>
            Address: Abc Road 12345<br />
            Philippines<br />
            Phone: +65 949 9226 246<br />
            Email: HAUSTAP_PH@gmail.com
          </p>
        </div>
      </div>
    </div>
    <div class="footer-bottom">2025 HausTap. All Rights Reserved.</div>
  </footer>
</body>
</html>