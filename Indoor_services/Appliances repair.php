<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Indoor Services | Appliance Repair | Homi</title>
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
      <span class="tab">Electrical</span>
      <span class="tab active">Appliance Repair</span>
      <span class="tab">Pest Control</span>
    </div>
    <div class="services-container">
      <!-- 1st row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="inspection-fee">
        <label for="inspection-fee" class="radio-label"></label>
        <div class="service-title">Inspection Fee</div>
        <div class="service-price">₱300</div>
        <div class="service-details">
          Individually by a technician.<br>
          On-site assessment of needs.<br>
          Recommendations for repair/solutions.<br>
          <strong>No actual repair or installation included</strong>
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="refrigerator-repair">
        <label for="refrigerator-repair" class="radio-label"></label>
        <div class="service-title">Refrigerator Repair</div>
        <div class="service-price">₱800 per unit</div>
        <div class="service-details">
          Cooling issue, replacement of thermostat, compressor<br>
          Cleaning of evaporator, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 2nd row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="commercial-freezer">
        <label for="commercial-freezer" class="radio-label"></label>
        <div class="service-title">Commercial Freezer Repair</div>
        <div class="service-price">₱1,000 per unit</div>
        <div class="service-details">
          Cooling issue, replacement of thermostat, compressor<br>
          Cleaning of evaporator, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="tv-repair-32">
        <label for="tv-repair-32" class="radio-label"></label>
        <div class="service-title">TV Repair (up to 32”)</div>
        <div class="service-price">₱600 per unit</div>
        <div class="service-details">
          Power/Display issues, sound issues, remote troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 3rd row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="tv-repair-33-50">
        <label for="tv-repair-33-50" class="radio-label"></label>
        <div class="service-title">TV Repair (33” to 50”)</div>
        <div class="service-price">₱800 per unit</div>
        <div class="service-details">
          Power/Display issues, sound issues, remote troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="tv-repair-51-80">
        <label for="tv-repair-51-80" class="radio-label"></label>
        <div class="service-title">TV Repair (51” to 80”)</div>
        <div class="service-price">₱1,000 per unit</div>
        <div class="service-details">
          Power/Display issues, sound issues, remote troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 4th row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="tv-install">
        <label for="tv-install" class="radio-label"></label>
        <div class="service-title">TV Installation</div>
        <div class="service-price">₱500 per unit</div>
        <div class="service-details">
          Mounting of TV on wall, connection to power<br>
          Setup of cable, minor configuration<br>
          Excludes replacement parts
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="washing-machine-repair">
        <label for="washing-machine-repair" class="radio-label"></label>
        <div class="service-title">Washing Machine Repair</div>
        <div class="service-price">₱800 per unit</div>
        <div class="service-details">
          Power/Drain issues, cleaning, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 5th row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="washing-machine-top-load">
        <label for="washing-machine-top-load" class="radio-label"></label>
        <div class="service-title">Washing Machine Cleaning Top Load</div>
        <div class="service-price">₱500 per unit</div>
        <div class="service-details">
          Drum cleaning, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="washing-machine-front-load">
        <label for="washing-machine-front-load" class="radio-label"></label>
        <div class="service-title">Washing Machine Cleaning Front Load</div>
        <div class="service-price">₱700 per unit</div>
        <div class="service-details">
          Drum cleaning, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 6th row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="stand-fan-repair">
        <label for="stand-fan-repair" class="radio-label"></label>
        <div class="service-title">Stand Fan Repair</div>
        <div class="service-price">₱300 per unit</div>
        <div class="service-details">
          Motor/Blade issues, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="tower-fan-repair">
        <label for="tower-fan-repair" class="radio-label"></label>
        <div class="service-title">Tower Fan Repair</div>
        <div class="service-price">₱700 per unit</div>
        <div class="service-details">
          Motor/Blade issues, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 7th row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="range-hood-repair">
        <label for="range-hood-repair" class="radio-label"></label>
        <div class="service-title">Range Hood Repair</div>
        <div class="service-price">₱800 per unit</div>
        <div class="service-details">
          Motor/Filter issues, cleaning, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="range-hood-install">
        <label for="range-hood-install" class="radio-label"></label>
        <div class="service-title">Range Hood Installation</div>
        <div class="service-price">₱600 per unit</div>
        <div class="service-details">
          Mounting and connection, minor troubleshooting<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 8th row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="microwave-repair-small">
        <label for="microwave-repair-small" class="radio-label"></label>
        <div class="service-title">Microwave Repair - Small</div>
        <div class="service-price">₱600 per unit</div>
        <div class="service-details">
          Power/Heating issues<br>
          Excludes replacement parts
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="microwave-repair-medium">
        <label for="microwave-repair-medium" class="radio-label"></label>
        <div class="service-title">Microwave Repair - Medium</div>
        <div class="service-price">₱700 per unit</div>
        <div class="service-details">
          Power/Heating issues<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 9th row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="microwave-repair-large">
        <label for="microwave-repair-large" class="radio-label"></label>
        <div class="service-title">Microwave Repair - Large</div>
        <div class="service-price">₱850 per unit</div>
        <div class="service-details">
          Power/Heating issues<br>
          Excludes replacement parts
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="oven-repair">
        <label for="oven-repair" class="radio-label"></label>
        <div class="service-title">Oven Repair</div>
        <div class="service-price">₱1200 per unit</div>
        <div class="service-details">
          Heating/Power issues, thermostat, wiring<br>
          Excludes replacement parts
        </div>
      </div>
      <!-- 10th row -->
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="rice-cooker-repair">
        <label for="rice-cooker-repair" class="radio-label"></label>
        <div class="service-title">Rice Cooker Repair</div>
        <div class="service-price">₱400 per unit</div>
        <div class="service-details">
          Power/Heating issues<br>
          Excludes replacement parts
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