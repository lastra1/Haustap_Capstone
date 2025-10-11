<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nail Services | Beauty Salon</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/nail_services.css" />
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
    <h1 class="main-title">Nail Care Services</h1>
    <button class="subcategory-btn">SUBCATEGORY</button>

    <!-- Subcategory Navigation -->
    <nav class="subcategory-nav">
      <ul>
        <li>Hair Services</li>
        <li class="active">Nail Care</li>
        <li>Make-up</li>
        <li>Lashes</li>
        <li>Packages</li>
      </ul>
    </nav>

    <div class="services-container">
      <!-- ROW 1 -->
      <section class="service-section">
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Manicure</h3>
              <p class="price">₱250</p>
              <p><strong>Inclusions:</strong><br>
                 Nail trimming and shaping (square, round, oval, etc.)<br>
                 Cuticle cleaning and pushing<br>
                 Nail buffing for smoothness<br>
                 Application of base coat, polish, and top coat<br>
                 Quick hand massage with lotion or oil
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Pedicure</h3>
              <p class="price">₱300</p>
              <p><strong>Inclusions:</strong><br>
                 Warm foot soak for relaxation<br>
                 Nail cutting and shaping<br>
                 Cuticle cleaning and pushing<br>
                 Gentle removal of dead skin or light calluses<br>
                 Application of base coat, polish, and top coat<br>
                 Light foot massage
              </p>
            </div>
          </label>
        </div>
      </section>

      <!-- ROW 2 -->
      <section class="service-section">
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Gel Manicure</h3>
              <p class="price">₱700</p>
              <p><strong>Inclusions:</strong><br>
                 Nail shaping and cuticle cleaning<br>
                 Buffing for proper gel adhesion<br>
                 Application of gel layers with UV/LED curing<br>
                 Glossy finish (2–3 weeks wear)<br>
                 Optional nail art or design
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Gel Pedicure</h3>
              <p class="price">₱800</p>
              <p><strong>Inclusions:</strong><br>
                 Relaxing foot soak<br>
                 Nail trimming and cuticle cleaning<br>
                 Application of gel polish with curing<br>
                 Chip-resistant color<br>
                 Light foot massage
              </p>
            </div>
          </label>
        </div>
      </section>

      <!-- ROW 3 -->
      <section class="service-section">
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Acrylic or Gel Extensions</h3>
              <p class="price">₱1,000</p>
              <p><strong>Inclusions:</strong><br>
                 Natural nail prep: cleaning, buffing, and cuticle care<br>
                 Application of nail tips or forms for extension<br>
                 Acrylic or gel overlay shaped to desired length<br>
                 Polish or gel color application
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Polygel Extensions</h3>
              <p class="price">₱1,200</p>
              <p><strong>Inclusions:</strong><br>
                 Natural nail preparation (cleaning and buffing)<br>
                 Application of polygel using dual forms<br>
                 Lightweight yet durable shaping<br>
                 Polish or gel color finish
              </p>
            </div>
          </label>
        </div>
      </section>

      <!-- ROW 4 -->
      <section class="service-section">
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Hand Spa</h3>
              <p class="price">₱500</p>
              <p><strong>Inclusions:</strong><br>
                 Cleansing wash and exfoliating scrub<br>
                 Cuticle softening soak<br>
                 Moisturizing mask or cream<br>
                 Relaxing hand massage
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Foot Spa</h3>
              <p class="price">₱600</p>
              <p><strong>Inclusions:</strong><br>
                 Warm foot soak with salts<br>
                 Exfoliating scrub and callus removal<br>
                 Moisturizing mask<br>
                 Foot massage
              </p>
            </div>
          </label>
        </div>
      </section>

      <!-- ROW 5 -->
      <section class="service-section">
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="nail">
            <div class="service-content">
              <h3>Paraffin Wax (Hands or Feet)</h3>
              <p class="price">₱400</p>
              <p><strong>Inclusions:</strong><br>
                 Gentle cleansing and hydrating cream<br>
                 Warm paraffin wax dip<br>
                 Wax wrapping for deep moisture<br>
                 Soft, rejuvenated skin after removal
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