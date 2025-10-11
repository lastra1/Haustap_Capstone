<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Laptop & Desktop PC</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/laptop_desktop.css" />
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
  <h1 class="main-title">Tech & Gadget</h1>
  <button class="subcategory-btn">SUBCATEGORY</button>

  <!-- Subcategory Navigation -->
  <nav class="subcategory-nav">
    <ul>
      <li>Mobile Phone</li>
      <li class="active">Laptop & Desktop PC</li>
      <li>Tablet & iPad</li>
      <li>Game & Console</li>
    </ul>
  </nav>

  <div class="services-container">
    <section class="service-section">
      <div class="service-grid">

        <label class="service-card">
          <input type="radio" name="tech" checked />
          <div class="service-content">
            <h3>Fan / Cooling Repair (Laptop)</h3>
            <p class="price">₱500 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Diagnosis of cooling system (fan, vents, heat sink)<br>
              Cleaning of dust and minor obstructions<br>
              Fan repair or replacement (part provided separately if needed)<br>
              Thermal paste application (if required)<br>
              Overheating test after repair
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Keyboard Replacement (Laptop)</h3>
            <p class="price">₱500 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Removal of defective keyboard<br>
              Installation of new keyboard (client-provided or stock)<br>
              Functional test of all keys<br>
              Proper assembly and casing check
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>OS Reformat + Software Installation (Laptop)</h3>
            <p class="price">₱700 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Full OS reinstallation (Windows/macOS/Linux as provided)<br>
              Installation of basic drivers (audio, display, network, etc.)<br>
              Installation of up to 3 client-provided software/applications<br>
              Basic system optimization and testing<br>
              Data backup not included
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Fan / Cooling Repair (Desktop PC)</h3>
            <p class="price">₱500 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Diagnosis of cooling system (fan, vents, heat sink)<br>
              Cleaning of dust and minor obstructions<br>
              Fan replacement (part provided separately if needed)<br>
              Thermal paste application (if required)<br>
              Overheating test after repair
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>Keyboard Replacement (Desktop PC)</h3>
            <p class="price">₱500 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Replacement of external desktop keyboard<br>
              Installation of new keyboard (client-provided or stock)<br>
              Functional test of all keys
            </p>
          </div>
        </label>

        <label class="service-card">
          <input type="radio" name="tech" />
          <div class="service-content">
            <h3>OS Reformat + Software Installation (Desktop PC)</h3>
            <p class="price">₱700 per unit</p>
            <p><strong>Inclusions:</strong><br>
              Full OS reinstallation (Windows/Linux as provided)<br>
              Installation of basic drivers (audio, display, network, etc.)<br>
              Installation of up to 3 client-provided software/applications<br>
              Basic system optimization and testing<br>
              Data backup not included (can be requested separately)
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
