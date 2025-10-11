<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | HausTap</title>
  <link rel="stylesheet" href="css/reset password.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

  <!-- Header -->
  <header>
    <img src="image/logo.png" alt="HausTap Logo" class="logo">
  </header>

  <!-- Reset Password Box -->
  <main>
    <div class="reset-box">
      <div class="back-arrow">←</div>
      <h4>Reset Password</h4>
      <form id="resetForm">
        <input type="email" id="email" placeholder="Email" required>
        <p id="errorMsg" class="error">Invalid email address. Please try again.</p>
        <button type="submit">Next</button>
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

  <script>
    const form = document.getElementById("resetForm");
    const emailInput = document.getElementById("email");
    const errorMsg = document.getElementById("errorMsg");

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      const emailValue = emailInput.value.trim();
      if (!emailValue || !emailValue.includes("@")) {
        emailInput.classList.add("invalid");
        errorMsg.style.display = "block";
      } else {
        emailInput.classList.remove("invalid");
        errorMsg.style.display = "none";
        alert("Password reset link sent!");
      }
    });
  </script>

</body>
</html>
