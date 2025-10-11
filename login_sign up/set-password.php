<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Set Your Password | HausTap</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <link rel="stylesheet" href="css/set-password.css" />
</head>
<body>
  <!-- HEADER -->
  <header>
    <img src="image/logo.png" alt="HausTap Logo" class="header-logo" />
  </header>

  <!-- MAIN CONTENT -->
  <main>
    <div class="password-box">
      <div class="back-arrow">
        <i class="fas fa-arrow-left"></i>
      </div>
      <h3>Set your password</h3>
      <h4>Create a new password</h4>
      <form>
        <div class="password-input">
          <input type="password" placeholder="Password" required />
          <span class="toggle-password">
            <i class="fas fa-eye-slash"></i>
          </span>
        </div>
        <ul class="password-rules">
          <li>At least one lowercase character</li>
          <li>At least one uppercase character</li>
          <li>8–16 characters</li>
          <li>Only letters and numbers can be used</li>
        </ul>
        <button type="submit" class="next-btn">Next</button>
      </form>
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
        <img src="image/logo.png" alt="HausTap Logo" />
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
</body>
</html>
