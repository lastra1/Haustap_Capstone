<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Indoor Services | Homi</title>
  <link rel="stylesheet" href="css/indoor-services.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="#"><img src="images/logo.png" alt="Haustap logo"></a>
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
      <span class="tab active">Handyman</span>
      <span class="tab">Plumbing</span>
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
          Evaluation by a handyman.<br>
          Includes on-site assessment of needs.<br>
          Recommendations for repair/solutions.<br>
          <strong>No actual repair or installation included</strong>
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="furniture-small">
        <label for="furniture-small" class="radio-label"></label>
        <div class="service-title">Furniture Assembly - Small Items</div>
        <div class="service-price">₱350 per unit</div>
        <div class="service-details">
          Includes assembly of stools, side tables, shelves<br>
          Assembling basic flat pack furniture<br>
          Minor adjustment per proper function
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="furniture-medium">
        <label for="furniture-medium" class="radio-label"></label>
        <div class="service-title">Furniture Assembly - Medium Items</div>
        <div class="service-price">₱500 per unit</div>
        <div class="service-details">
          Includes chairs, study table, cabinet<br>
          Assembly of medium scale furniture<br>
          Minor adjustment per proper function
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="furniture-large">
        <label for="furniture-large" class="radio-label"></label>
        <div class="service-title">Furniture Assembly - Large Items</div>
        <div class="service-price">₱800 per unit</div>
        <div class="service-details">
          Includes beds, sofa, cabinets<br>
          Assembly of large scale furniture<br>
          Minor adjustment per proper function
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="door-knob">
        <label for="door-knob" class="radio-label"></label>
        <div class="service-title">Door knob / Lock replacement</div>
        <div class="service-price">₱400 per unit</div>
        <div class="service-details">
          Installation of new door knob, lock, or hinge<br>
          Removal and disposal of old knob, lock, or hinge<br>
          Lubrication of moving parts if needed<br>
          Location of new door knob if needed
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="door-hinge">
        <label for="door-hinge" class="radio-label"></label>
        <div class="service-title">Door hinge replacement</div>
        <div class="service-price">₱300 per unit</div>
        <div class="service-details">
          Installation of new door hinge<br>
          Removal and disposal of old hinge<br>
          Lubrication of moving parts if needed<br>
          Functionality check after repair
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="sliding-door">
        <label for="sliding-door" class="radio-label"></label>
        <div class="service-title">Sliding door / Closet adjustment</div>
        <div class="service-price">₱350 per unit</div>
        <div class="service-details">
          Adjustment of hardware<br>
          Repair and replacement of parts, knobs, or hinges<br>
          Lubrication of moving parts if needed<br>
          Functionality check after repair
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="loose-chair">
        <label for="loose-chair" class="radio-label"></label>
        <div class="service-title">Loose chair / Desk repair</div>
        <div class="service-price">₱400 per unit</div>
        <div class="service-details">
          Repair/replacement of screws, bolts, or hinges<br>
          Refastening of parts, legs, arms, or doors<br>
          Tightening of loose components<br>
          Functionality check after repair
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="cabinet-align">
        <label for="cabinet-align" class="radio-label"></label>
        <div class="service-title">Cabinet alignment / Fix</div>
        <div class="service-price">₱400 per unit</div>
        <div class="service-details">
          Realignment of panels, drawers, or doors<br>
          Replacement of broken, bent, or stuck hinges<br>
          Lubrication of moving parts if needed<br>
          Functionality check after repair
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="minor-wood">
        <label for="minor-wood" class="radio-label"></label>
        <div class="service-title">Minor wooden repairs</div>
        <div class="service-price">₱400 per panel/part</div>
        <div class="service-details">
          Refitting of panels, drawers, or doors<br>
          Repairing of cracks, splits, or chips<br>
          Replacement of broken, bent, or stuck hinges<br>
          Lubrication of moving parts if needed<br>
          Functionality check after repair
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="curtain-blinds">
        <label for="curtain-blinds" class="radio-label"></label>
        <div class="service-title">Curtain rod / Blinds installations</div>
        <div class="service-price">₱300 per unit</div>
        <div class="service-details">
          Installation and securing proper placement<br>
          Drilling and screwing with safety screws/anchors<br>
          Clean-up of minor dust/debris after work
        </div>
      </div>
      <div class="service-card">
        <input type="radio" name="service" class="service-radio" id="mirror-install">
        <label for="mirror-install" class="radio-label"></label>
        <div class="service-title">Mirror installation</div>
        <div class="service-price">₱300 per unit</div>
        <div class="service-details">
          Measuring and securing proper placement<br>
          Drilling and screwing with safety screws/anchors<br>
          Clean-up of minor dust/debris after work
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