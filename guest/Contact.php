<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact - HausTap</title>
  <link rel="stylesheet" href="css/contact.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
  <div class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img">
    <nav class="nav">
      <a href="#" class="active">Home</a>
      <a href="#">Services</a>
      <a href="#">Bookings</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </nav>
   <div class="header-right">
      <div class="search-box">
        <input type="text" placeholder="Search services">
        <i class="fa fa-search"></i>
      </div>
      
      <div class="signup-link">
        <a href="#">Sign up</a>
        
      </div>
      <span>|</span>
      <div class="login-link"><a href="#">Login</a></div>

    </div>
  </div>

  <!-- MAIN SECTION -->
  <section class="contact-section">
    <div class="tab-container">
      <div class="tabs">
        <button class="tab active">Chat</button>
        <button class="tab">Connect Haustap with</button>
      </div>

      <div class="tab-content chat-tab active">
        <div class="chat-box">
          <p>No messages</p>
        </div>
      </div>

      <div class="tab-content connect-tab">
        <div class="social-icons">
          <div class="social-card">
            <img src="images/facebook.png" alt="Facebook">
            <a href="#">Facebook page</a>
          </div>
          <div class="social-card">
            <img src="images/instagram.png" alt="Instagram">
            <a href="#">Instagram page</a>
          </div>
          <div class="social-card">
            <img src="images/twitter.png" alt="X">
            <a href="#">X</a>
          </div>
        </div>

        <p class="email-text">Or send us your concern via email:</p>

        <div class="contact-info">
          <h4>Contact Us</h4>
          <p>Email: <a href="mailto:haustap_ph@gmail.com">haustap_ph@gmail.com</a></p>
          <p>Phone: 09451234521</p>
          <p>Phone: 09264502561</p>
          <p>Address: 29 San Pedro, Laguna City of Sta Rosa, Laguna</p>
          <p>If you have any questions or feedback, feel free to reach out!</p>
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
        <div class="contact-information">
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

  <script>
    // Tab switching functionality
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach((tab, index) => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));
        tab.classList.add('active');
        contents[index].classList.add('active');
      });
    });
  </script>
</body>
</html>
