<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Packages</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/packages_services.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
  <!-- HEADER -->
  <header class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img" />
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#" class="active">Services</a>
      <a href="#">Bookings</a>
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
  <h1 class="main-title">Packages</h1>
  <button class="subcategory-btn">SUBCATEGORY</button>

  <!-- Subcategory Navigation -->
  <nav class="subcategory-nav">
    <ul>
      <li>Hair Services</li>
      <li>Nail Care</li>
      <li>Make-up</li>
      <li>Lashes</li>
      <li class="active">Packages</li>
    </ul>
  </nav>

  <div class="services-container">
    <section class="service-section">
      <div class="service-grid">
        <label class="service-card">
          <input type="radio" name="packages" checked />
          <div class="service-content">
            <h3>Basic Care Package</h3>
            <p class="price">Starts at ₱1,000</p>
            <p><strong>Inclusions:</strong><br>
              Haircut (Ladies or Men)<br>
              Manicure with trimming, shaping, and polish<br>
              Pedicure with foot soak, cleaning, and polish
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="packages" />
          <div class="service-content">
            <h3>Glam Essentials Package</h3>
            <p class="price">Starts at ₱2,200</p>
            <p><strong>Inclusions:</strong><br>
              Professional blow-dry and hairstyling<br>
              Gel manicure with long-lasting polish<br>
              Classic lash extensions for a natural glam look
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="packages" />
          <div class="service-content">
            <h3>Event Ready Package</h3>
            <p class="price">Starts at ₱3,500</p>
            <p><strong>Inclusions:</strong><br>
              Full make-up for special occasions<br>
              Hybrid lash extensions for fuller eyes<br>
              Simple hairstyling to complete the look
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="packages" />
          <div class="service-content">
            <h3>Bridal Radiance Package</h3>
            <p class="price">Starts at ₱8,000</p>
            <p><strong>Inclusions:</strong><br>
              Bridal make-up (trial + wedding day)<br>
              Volume lash extensions for elegant eyes<br>
              Bridal hairstyling for a timeless finish
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="packages" />
          <div class="service-content">
            <h3>Mani + Pedi Combo</h3>
            <p class="price">Starts at ₱500</p>
            <p><strong>Inclusions:</strong><br>
              Complete hand and foot nail cleaning<br>
              Nail shaping, cuticle care, and polish<br>
              Relaxing soak and light massage
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="packages" />
          <div class="service-content">
            <h3>Gel Mani + Pedi Combo</h3>
            <p class="price">Starts at ₱1,300</p>
            <p><strong>Inclusions:</strong><br>
              Gel manicure with long-lasting polish<br>
              Gel pedicure with durable glossy finish<br>
              Ideal for low-maintenance, polished nails
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
