<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Type of Cleaning | Homi</title>
  <link rel="stylesheet" href="css/indoor-cleaning.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

  <main>
    <h1 class="main-title">Type of Cleaning</h1>
    <button class="subcategory-btn">Duplex Larger</button>
    <div class="services-container">
      <div class="service-grid">
        <div class="service-card">
          <input type="radio" name="cleaning" id="basic-cleaning">
          <label for="basic-cleaning" class="radio-label"></label>
          <div class="service-content">
            <h3>Basic Cleaning – 2 Cleaner</h3>
            <div class="price">₱2,500</div>
            <p><strong>Inclusions:</strong></p>
            <ul>
              <li>All main areas swept, mopped, dusted</li>
              <li>Trash collection</li>
              <li>Windows/mirrors wiped</li>  
            </ul>
          </div>
        </div>
        <div class="service-card">
          <input type="radio" name="cleaning" id="standard-cleaning">
          <label for="standard-cleaning" class="radio-label"></label>
          <div class="service-content">
            <h3>Standard Cleaning – 3-4 Cleaners</h3>
            <div class="price">₱5,500</div>
            <p><strong>Inclusions:</strong></p>
            <ul>
              <li>All Basic Cleaning tasks</li>
              <li>Kitchen deep clean</li>
              <li>Bathrooms scrubbed & disinfected</li>
              <li>Furniture base & underside cleaning</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="service-grid">
        <div class="service-card wide">
          <input type="radio" name="cleaning" id="deep-cleaning">
          <label for="deep-cleaning" class="radio-label"></label>
          <div class="service-content">
            <h3>Deep Cleaning – 3 Cleaners</h3>
            <div class="price">₱8,000</div>
            <p><strong>Inclusions:</strong></p>
            <ul>
              <li>All Standard Cleaning tasks</li>
              <li>Grout & tile scrubbing</li>
              <li>Behind appliances cleaning</li>
              <li>Carpets vacuum/shampoo</li>
              <li>Disinfection high-touch</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="cleaning-note">Cleaning materials are provided by the client</div>
       <div class="pagination">
      <button>&lt;</button>
      <button class="active">1</button>
      <button>2</button>
      <button>3</button>
      <button>4</button>
      <button>5</button>
      <button>&gt;</button>
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
        <img src="image/logo.png" alt="HausTap Logo" />
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