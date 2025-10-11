<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lashes Services | Beauty Salon</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/lash_services.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
  <!-- HEADER -->
  <header class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img" />
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#" class="active">Bookings</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </nav>
    <div class="header-right">
      <div class="search-box">
        <input type="text" placeholder="Search services" />
        <i class="fa fa-search"></i>
      </div>
      <a href="#" class="account-link">
        <i class="fa fa-user account-icon"></i> My Account
      </a>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main>
    <h1 class="main-title">Lashes Services</h1>
    <button class="subcategory-btn">SUBCATEGORY</button>
    <nav class="subcategory-nav">
      <ul>
        <li>Hair Services</li>
        <li>Nail Care</li>
        <li>Make-up</li>
        <li class="active">Lashes</li>
        <li>Packages</li>
      </ul>
    </nav>

    <div class="services-container">
      <section class="service-section">
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="lashes" checked />
            <div class="service-content">
              <h3>Classic Lash Extensions</h3>
              <p class="price">Starts at ₱500</p>
              <p><strong>Inclusions:</strong><br>
                1:1 lash application for a natural look<br>
                Lightweight and comfortable for daily wear<br>
                Enhances length and curl without heavy volume
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="lashes" />
            <div class="service-content">
              <h3>Hybrid Lash Extensions</h3>
              <p class="price">Starts at ₱800</p>
              <p><strong>Inclusions:</strong><br>
                Combination of classic and volume lash techniques<br>
                Fuller and more textured effect<br>
                Balanced style for both natural and glam looks
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="lashes" />
            <div class="service-content">
              <h3>Volume Lash Extensions</h3>
              <p class="price">Starts at ₱1,000</p>
              <p><strong>Inclusions:</strong><br>
                3D–6D lash fans applied for dramatic volume<br>
                Creates a glamorous, eye-catching effect<br>
                Ideal for clients who prefer bold lashes
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="lashes" />
            <div class="service-content">
              <h3>Mega Volume Lash Extensions</h3>
              <p class="price">Starts at ₱1,500</p>
              <p><strong>Inclusions:</strong><br>
                Multiple ultra-fine lash fans for extra density<br>
                Intense, dramatic lash look<br>
                Best for special occasions or high-glam styles
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="lashes" />
            <div class="service-content">
              <h3>Lash Lift + Tint</h3>
              <p class="price">Starts at ₱500</p>
              <p><strong>Inclusions:</strong><br>
                Lifts and curls natural lashes from the root<br>
                Tint adds depth and mascara-like effect<br>
                Lasts several weeks with low maintenance
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="lashes" />
            <div class="service-content">
              <h3>Lower Lash Extensions</h3>
              <p class="price">Starts at ₱300</p>
              <p><strong>Inclusions:</strong><br>
                Extensions applied to bottom lashes<br>
                Enhances definition and balance to eye look<br>
                Complements upper lash extensions
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="lashes" />
            <div class="service-content">
              <h3>Lash Removal</h3>
              <p class="price">Starts at ₱500</p>
              <p><strong>Inclusions:</strong><br>
                Gentle and safe removal of extensions<br>
                Protects natural lashes from damage<br>
                Recommended for switching lash styles
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="lashes" />
            <div class="service-content">
              <h3>Lash Retouch / Refill (2–3 weeks)</h3>
              <p class="price">Starts at ₱800</p>
              <p><strong>Inclusions:</strong><br>
                Fills in gaps from natural lash shedding<br>
                Maintains fullness and shape of extensions<br>
                Keeps lashes looking fresh and even
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
