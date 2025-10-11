<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HausTap Bookings</title>
  <link rel="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/request_return.css">
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

<!-- REQUEST RETURN PAGE -->
<section class="request-return-page">

  <!-- Header outside the boxes -->
  <h2 class="request-return-title">Request Return</h2>

  <!-- Box 1 -->
  <div class="request-box">
    <div class="help-section">
      <h3>How Can We Help?</h3>
      <span class="free-return">| FREE RETURN</span>
    </div>
  </div>

  <!-- Box 2 -->
  <div class="request-box">
    <div class="product-section">
      <h3>Product You Want to Return</h3>
      <p class="product-title">Home Cleaning</p>
      <p class="product-sub">Bungalow - Basic Cleaning</p>
    </div>
  </div>

  <!-- Box 3 -->
  <div class="request-box">
    <div class="reason-section">
      <h3>Why Do You Want to Return?</h3>

      <div class="reason-row">
        <label for="reason">Reason:</label>
        <select id="reason" name="reason" required>
        <option value="" disabled selected hidden>Select a reason</option>
          <option>Service not delivered (no-show)</option>
          <option>Incomplete service (not finished)</option>
          <option>Wrong service provided</option>
          <option>Poor service quality</option>
          <option>Tools/Equipment issue</option>
          <option>Property damaged during service</option>
          <option>Miscommunication in booking details</option>
          <option>Safety concern</option>
          <option>Promised inclusions not delivered</option>
          <option>Double booking issue</option>
          <option>Changed mind after service result</option>
          <option>Others (please specify)</option>
        </select>
      </div>

      <div class="description-row">
        <label for="description">Description:</label>
        <textarea id="description" placeholder="Leave your comments here"></textarea>
      </div>

      <div class="button-row">
        <button class="cancel-btn">Cancel</button>
        <button class="submit-btn">Submit</button>
      </div>
    </div>
  </div>

</section>

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