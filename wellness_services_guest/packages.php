<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Packages</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/packages.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
  <div class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img">
    
    <nav class="nav">
      <a href="#" class="active">Home</a>
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

  <!-- MAIN CONTENT -->
  <main>
  <h1 class="main-title">Wellness Services</h1>
  <button class="subcategory-btn">SUBCATEGORY</button>

  <!-- Subcategory Navigation -->
  <nav class="subcategory-nav">
    <ul>
      <li>Massage</li>
      <li class="active">Packages</li>
    </ul>
  </nav>

  <div class="services-container">
    <section class="service-section">
      <div class="service-grid">
        <label class="service-card">
          <input type="radio" name="massage" checked />
          <div class="service-content">
            <h3>Total Relaxation Package</h3>
            <p class="price">₱800</p>
            <p>Relaxing massage to rSwedish Full Body Massage<br>
            (60 mins) + Reflexology (45 mins)elieve tension and improve<br>
            circulation.
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="massage" />
          <div class="service-content">
            <h3>Stress Relief Duo</h3>
            <p class="price">₱900</p>
            <p>Back & Shoulder Massage (30 mins) + Scalp & Head<br>
            Massage (30 mins)
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
