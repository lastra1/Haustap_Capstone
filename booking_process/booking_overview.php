<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Booking Overview</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/booking_overview.css" />
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

<main class="booking-overview">
  <h1 class="page-title">Booking Overview</h1>

  <section class="overview-box">
    <div class="service-header">
      <h2>Home Cleaning</h2>
      <h3><strong>Bungalow - Basic Cleaning</strong></h3>
      <hr>
    </div>

    <div class="details">
      <p><strong>Date:</strong> May 21, 2025</p>
      <p><strong>Time:</strong> 1:00 PM</p>
      <p class="multi-line">
        <strong>Address:</strong> B1 L50 Mango St. Phase 1 Saint Joseph Village 10,
        Barangay Langgam, City of San Pedro, Laguna 4023
      </p>
      <p class="multi-line">
        <strong>You selected:</strong> <b>Bungalow 80 - 150 sqm</b>
      </p>
      <p class="multi-line">
        <strong></strong> <b>Basic Cleaning - 1 Cleaner</b>
      </p>

      <div class="inclusions multi-line">
        <p>
          Inclusions:<br
          Living Room: walis, mop, dusting furniture, trash removal<br>
          Bedrooms: bed making, sweeping, dusting, trash removal<br>
          Hallways: mop & sweep, remove cobwebs<br>
          Windows & Mirrors: quick wipe
        </p>
      </div>
    </div>

    <div class="notes-section">
      <label for="notes" class="notes-label"><b>Notes:</b></label>
      <textarea id="notes"></textarea>
      <hr>
    </div>

    <div class="voucher-section">
      <div class="voucher-left">
        <i class="fa-solid fa-ticket icon"></i>
        <span>Add a Voucher</span>
      </div>
      <div class="voucher-toggle">
        <button class="toggle-btn">></button>
      </div>
    </div>

    <div class="summary">
  <div class="summary-row">
    <strong>Sub Total:</strong> <span>₱800.00</span>
  </div>
  <div class="summary-row">
    <strong>Voucher Discount:</strong> <span>₱0</span>
  </div>
  <div class="summary-row total">
    <strong>TOTAL:</strong> <span>₱800.00</span>
  </div>
</div>

    <p class="footer-note">
      Full payment will be collected directly by the service provider upon completion of the service.
    </p>
  </section>

    <!-- PAGINATION -->
    <div class="pagination">
      <button>&lt;</button>
      <button class="active">1</button>
      <button class="active">2</button>
      <button class="active">3</button>
      <button class="active">4</button>
      <button class="active">5</button>
      <button>&gt;</button>
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
