<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up | HausTap</title>
  <link rel="stylesheet" href="css/sign up.css">
  <script src="config.js"></script>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="image/logo.png" alt="HausTap Logo" width="120" height="100">
    </div>
    <form class="signup-form">
      <h2>Sign Up</h2>
      <div class="row">
        <div>
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" name="firstName" required>
        </div>
        <div>
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="lastName" required>
        </div>
      </div>
      <div class="row">
        <div>
          <label for="birthMonth">Birth Month</label>
          <input type="number" id="birthMonth" name="birthMonth" min="1" max="12" required>
        </div>
        <div>
          <label for="birthDay">Day</label>
          <input type="number" id="birthDay" name="birthDay" min="1" max="31" required>
        </div>
        <div>
          <label for="birthYear">Year</label>
          <input type="number" id="birthYear" name="birthYear" min="1900" max="2025" required>
        </div>
      </div>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      <label for="mobile">Mobile Number</label>
      <input type="text" id="mobile" name="mobile" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required>
      <button type="submit">Sign Up</button>
      <div class="login-link">
        Already have an account? <a href="#">Login</a>
      </div>
      <button type="button" class="partner-btn">Become a HausTap Partner</button>
    </form>
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
        <img src="image/logo.png" alt="HausTap Logo" />
        <p>Your space. Your peace. Your Glow</p>
      </div>

      <!-- Right Section -->
      <div class="footer-right">
        <h4>FOLLOW US</h4> <br>
        <ul>
          <li><i class="fab fa-facebook-f"></i> Facebook</li>
          <li><i class="fab fa-instagram"></i> Instagram</li>
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
  <script>
    (function() {
      const form = document.querySelector('.signup-form');
      if (!form) return;

      form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const firstName = document.getElementById('firstName').value.trim();
        const lastName = document.getElementById('lastName').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const mobile = document.getElementById('mobile').value.trim();

        const birthMonth = document.getElementById('birthMonth').value;
        const birthDay = document.getElementById('birthDay').value;
        const birthYear = document.getElementById('birthYear').value;

        const payload = {
          firstName,
          lastName,
          email,
          password,
          confirmPassword,
          mobile,
          birthMonth,
          birthDay,
          birthYear
        };

        try {
          const base = window.API_BASE_URL || 'http://127.0.0.1:8001/auth';
          const res = await fetch(`${base}/register`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });

          const data = await res.json();
          if (res.status === 201) {
            // Align token key with Expo app for consistency
            localStorage.setItem('auth_token', data.token);
            // Redirect to homepage without changing UI layout
            window.location.href = '../guest/homepage.php';
            return;
          }

          console.error('Registration failed:', data);
          alert('Registration failed. Please check your details.');
        } catch (err) {
          console.error('Network error:', err);
          alert('Network error. Please try again.');
        }
      });
    })();
  </script>
</body>
</html>