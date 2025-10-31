<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Game & Console</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/game_console.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
 <div class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img">
    
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#">Bookings</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </nav>

    <!-- Right side (Search + Auth Links) -->
    <div class="header-right">
      <div class="search-box">
        <input type="text" placeholder="Search services">
        <i class="fa fa-search"></i>
      </div>

      <!-- Added spacing handled by CSS below -->
      <div class="auth-links">
        <div class="signup-link">
          <a href="#">Sign up</a>
        </div>
        <span>|</span>
        <div class="login-link">
          <a href="#">Login</a>
        </div>
      </div>
    </div>
  </div>

    </div>

  <!-- MAIN CONTENT -->
  <main>
  <h1 class="main-title">Tech & Gadget</h1>
  <button class="subcategory-btn">SUBCATEGORY</button>

  <!-- Subcategory Navigation -->
  <nav class="subcategory-nav">
    <ul>
      <li>Mobile Phone</li>
      <li>Laptop & Desktop PC</li>
      <li>Tablet & iPad</li>
      <li class="active">Game & Console</li>
    </ul>
  </nav>

  <div class="services-container">
    <section class="service-section">
      <div class="service-grid">
        <label class="service-card">
          <input type="radio" name="tech" checked />
          <div class="service-content">
            <h3>Controller repair</h3>
            <p class="price">₱300 per unit</p>
            <p><strong>Inclusions:</strong><br>
                Diagnosis of controller issues (buttons, joystick, triggers, or connectivity)<br>
                Cleaning and calibration of internal parts<br>
                Replacement of minor components/parts (if provided by client)<br>
                Functionality test and gameplay test after repair
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>HDMI port repair</h3>
            <p class="price">₱700 per unit</p>
            <p><strong>Inclusions:</strong><br>
                Diagnosis of HDMI port issue (loose, bent, or damaged pins)<br>
                Removal of faulty HDMI port<br>
                Installation of new HDMI port (customer-provided or available stock)<br>
                Testing of video/audio output to monitor/TV<br>
                Device assembly and functionality check
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Disc Drive Repair / Replacement </h3>
            <p class="price">₱800 per unit</p>
            <p><strong>Inclusions:</strong><br>
                Diagnosis of disc reading/ejecting issues<br>
                Cleaning of optical lens<br>
                Adjustment or repair of disc tray mechanism<br>
                Replacement of faulty disc drive (if provided by client)<br>
                Playback test with game disc
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Power Supply Repair / Replacement </h3>
            <p class="price">₱900 per unit</p>
            <p><strong>Inclusions:</strong><br>
                Diagnosis of power-related issues (no power, sudden shutdowns)<br>
                Checking and repairing internal power supply<br>
                Replacement of power supply unit (if provided by client)<br>
                Functionality and safety test after repai
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Software Reinstallation / Update </h3>
            <p class="price">₱300 per unit</p>
            <p><strong>Inclusions:</strong><br>
                Diagnosis of controller issues (buttons, joystick, triggers, or connectivity)<br>
                Cleaning and calibration of internal parts<br>
                Replacement of minor components/parts (if provided by client)<br>
                Functionality test and gameplay test after repair
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>HDMI port repair</h3>
            <p class="price">₱600 per unit</p>
            <p><strong>Inclusions:</strong><br>
                System software update/reinstallation (PlayStation, Xbox, Nintendo, etc.)<br>
                Installation of latest firmware version<br>
                Optimization of console performance<br>
                Testing of system functions and online connectivity
            </p>
          </div>
        </label>
      </div>
    </section>
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
            Address: Abc Road 12345<br>
            Philippines<br>
            Phone: +65 949 9226 246<br>
            Email: HAUSTAP_PH@gmail.com
          </p>
        </div>
      </div>
    </div>
    <div class="footer-bottom">2025 HausTap. All Rights Reserved.</div>
  </footer>
</body>
</html>
