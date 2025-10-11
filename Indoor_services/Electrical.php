<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Indoor Services | Electrical | Homi</title>
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
      <span class="tab">Plumbing</span>
      <span class="tab active">Electrical</span>
      <span class="tab">Appliance Repair</span>
      <span class="tab">Pest Control</span>
    </div>
    <div class="services-container">
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="inspection-fee">
        <label for="inspection-fee" class="radio-label"></label>
        <div class="service-title">Inspection Fee</div>
        <div class="service-price">₱300 <span class="note">Applies if install not processed</span></div>
        <div class="service-details">
          <strong>Inclusions:</strong><br>
          On-site visit by electrician<br>
          Assessment of wiring/electrical issue<br>
          Basic recommendations / cost estimate<br>
          Repair not included
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="outlet-install">
        <label for="outlet-install" class="radio-label"></label>
        <div class="service-title">Outlet installation / repair</div>
        <div class="service-price">₱400 per outlet</div>
        <div class="service-details">
          <strong>Inclusions:</strong><br>
          Mounting of new outlet or repair of damaged one<br>
          Electrical connection and safety check<br>
          Test using appliance or tester
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="light-switch-repair">
        <label for="light-switch-repair" class="radio-label"></label>
        <div class="service-title">Light Switch repair</div>
        <div class="service-price">₱400 per repair</div>
        <div class="service-details">
          <strong>Inclusions:</strong><br>
          Removal of damaged socket (if any)<br>
          Installation of new socket<br>
          Connection to existing wiring<br>
          Functionality and safety test
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="light-install">
        <label for="light-install" class="radio-label"></label>
        <div class="service-title">Light installation</div>
        <div class="service-price">₱300 per install</div>
        <div class="service-details">
          <strong>Inclusions:</strong><br>
          Switch installation<br>
          Installation of bulb socket / fixture<br>
          Power-on functionality test
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="light-switch-replacement">
        <label for="light-switch-replacement" class="radio-label"></label>
        <div class="service-title">Light switch replacement</div>
        <div class="service-price">₱350 per replacement</div>
        <div class="service-details">
          <strong>Inclusions:</strong><br>
          Replacement of switch<br>
          Reject for repair as needed<br>
          Test switch and connected light
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="circuit-breaker">
        <label for="circuit-breaker" class="radio-label"></label>
        <div class="service-title">Circuit breaker installation / replacement</div>
        <div class="service-price">₱500 per install/replacement</div>
        <div class="service-details">
          <strong>Inclusions:</strong><br>
          Installation of breaker (if applicable)<br>
          Removal of old breaker<br>
          Proper wiring connection<br>
          Functionality and safety test
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="ceiling-fan">
        <label for="ceiling-fan" class="radio-label"></label>
        <div class="service-title">Ceiling fan installation</div>
        <div class="service-price">₱500 per install</div>
        <div class="service-details">
          <strong>Inclusions:</strong><br>
          Mount fan on ceiling<br>
          Proper electrical connection<br>
          Balance and functionality test
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