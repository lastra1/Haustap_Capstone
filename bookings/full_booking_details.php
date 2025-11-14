<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HausTap Bookings</title>
  <link rel="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/full_booking_details.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

  <!-- Header -->
   <div class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img">
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#" class="active">Bookings</a>
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
  </div>

  <main class="booking-details-container">
    <div class="booking-box">
      <button class="close-btn">✕</button>

      <h1>Home Cleaning</h1>
      <span class="sub-text">Bungalow - Basic Cleaning</span>

      <hr class="divider-black">

      <div class="info-section">
        <p><strong>Date:</strong> May 20, 2025</p>
        <p><strong>Time:</strong> 1:00 PM</p>
        <p><strong>Address:</strong> B1 L50 Mango St. Phase 1 Saint Joseph Village 10<br>
          Barangay Langgam, City of San Pedro, Laguna 4023
        </p>
        <div class="note-section">
          <label><strong>Note:</strong></label>
          <textarea placeholder="Enter note here..."></textarea>
        </div>
      </div>

      <div class="voucher-box">
        <span class="voucher-icon"><i class="fa fa-ticket"></i> Add a Voucher</span>
        <button class="toggle-btn">▼</button>
      </div>

      <hr class="divider-gray">

    <div class="total-section">
  <p class="subtotal"><span><b>Sub Total:</b></span> ₱800.00</p>
  <p class="voucher"><span><b>Voucher Discount:</b></span> 0</p>
  <p class="total"><span><b>Total:</b></span> ₱800.00</p>
    </div>


      <p class="note-text">
        Full payment will be collected directly by the service provider upon completion of the service.
      </p>

      <hr class="divider-gray">
        <!-- booking-footer -->
        <div class="booking-footer">
          <div class="service-provider">
            <div class="service-provider-top">
              <i class="fa fa-user account-icon"></i>
              <span class="name">Ana Santos</span>
              <i class="fa fa-comment message-icon"></i>
            </div>
            <div class="rating">
              ⭐ (4.9)
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