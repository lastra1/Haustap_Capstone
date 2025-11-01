<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log In | HausTap</title>
  <link rel="stylesheet" href="css/login.css">
  <script src="config.js"></script>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="image/logo.png" alt="HausTap Logo" width="120" height="100">
    </div>
    <form class="login-form">
      <h2>Log In</h2>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <a href="#" class="forgot">Forgot Password?</a>
      <button type="submit">Log In</button>
      <div class="signup-link">
        New to HausTap? <a href="#">Sign Up</a>
      </div>
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
      const form = document.querySelector('.login-form');
      if (!form) return;

      form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        try {
          const base = window.API_BASE_URL || 'http://127.0.0.1:8001/auth';
          const res = await fetch(`${base}/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
          });

          const data = await res.json();
          if (!res.ok) {
            console.error('Login failed:', data);
            alert(data.message || 'Login failed');
            return;
          }

          // Align token key with Expo app for consistency
          localStorage.setItem('auth_token', data.token);
          // Redirect to homepage without changing UI layout
          window.location.href = '../guest/homepage.php';
        } catch (err) {
          console.error('Network error:', err);
          alert('Network error. Please try again.');
        }
      });
    })();
  </script>
</body>
</html>