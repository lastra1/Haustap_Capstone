<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Make-Up Services</title>
  <link rel="stylesheet" href="css/makeup_services.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <div class="logo">
      <a href="#"><img src="images/logo.png" alt="Haustap Logo"></a>
    </div>
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#" class="active">Services</a>
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

  <!-- MAIN CONTENT -->
  <main>
  <h1 class="main-title">Beauty Services</h1>
  <button class="subcategory-btn">SUBCATEGORY</button>

  <!-- Subcategory Navigation -->
  <nav class="subcategory-nav">
    <ul>
      <li>Hair Services</li>
      <li>Nail Care</li>
      <li class="active">Make-up</li>
      <li>Lashes</li>
      <li>Packages</li>
    </ul>
  </nav>

  <div class="services-container">
    <section class="service-section">
      <div class="service-grid">
        <!-- Card 1 -->
        <label class="service-card">
          <input type="radio" name="makeup" checked>
          <div class="service-content">
            <h3>Basic/Day Make-Up</h3>
            <p class="price">₱1,000</p>
            <p><strong>Inclusions:</strong><br>
              Light foundation & concealer<br>
              Natural eyeshadow & brows<br>
              Mascara, blush & lip tint
            </p>
          </div>
        </label>

        <!-- Card 2 -->
        <label class="service-card">
          <input type="radio" name="makeup">
          <div class="service-content">
            <h3>Evening/Party Make-Up</h3>
            <p class="price">₱1,200</p>
            <p><strong>Inclusions:</strong><br>
              Full coverage base<br>
              Bold eyeshadow & eyeliner<br>
              False lashes (optional)<br>
              Contour, highlighter & bold lips
            </p>
          </div>
        </label>

        <!-- Card 3 -->
        <label class="service-card">
          <input type="radio" name="makeup">
          <div class="service-content">
            <h3>Bridal Make-Up (Trial + Wedding Day)</h3>
            <p class="price">₱5,000</p>
            <p><strong>Inclusions:</strong><br>
              Trial session + final bridal look<br>
              Long-lasting HD foundation<br>
              Elegant eyes & false lashes<br>
              Contour, highlight & bridal lips<br>
              Setting spray for all-day hold
            </p>
          </div>
        </label>

        <!-- Card 4 -->
        <label class="service-card">
          <input type="radio" name="makeup">
          <div class="service-content">
            <h3>Debut/Prom Make-Up</h3>
            <p class="price">₱1,000</p>
            <p><strong>Inclusions:</strong><br>
              Medium coverage base<br>
              Fresh glam eyes & youthful brows<br>
              Blush & glossy/natural lips
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
