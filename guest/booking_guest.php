<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/booking_guest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>HausTap - Bookings</title>
    
</head>
<body>
     <div class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img">
    
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#" class="active">Bookings</a>
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

    <!-- Tabs Section -->
    <div class="tabs-container">
        <div class="tabs">
            <button class="tab active" data-tab="pending">Pending</button>
            <button class="tab" data-tab="ongoing">Ongoing</button>
            <button class="tab" data-tab="completed">Completed</button>
            <button class="tab" data-tab="cancelled">Cancelled</button>
            <button class="tab" data-tab="return">Return</button>
        </div>

        <div id="pending" class="tab-content active">
            <p class="no-bookings">No Pending bookings</p>
        </div>

        <div id="ongoing" class="tab-content">
            <p class="no-bookings">No Ongoing bookings</p>
        </div>

        <div id="completed" class="tab-content">
            <p class="no-bookings">No Completed bookings</p>
        </div>

        <div id="cancelled" class="tab-content">
            <p class="no-bookings">No Cancelled bookings</p>
        </div>

        <div id="return" class="tab-content">
            <p class="no-bookings">No Return bookings</p>
        </div>
    </div>

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

    <script>
        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab
                tab.classList.add('active');

                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
</body>
</html>