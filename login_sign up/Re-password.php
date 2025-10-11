<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enter Verification Code | HausTap</title>
  <link rel="stylesheet" href="css/re-password.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

  <!-- Header -->
  <header>
    <img src="image/logo.png" alt="HausTap Logo" class="logo">
  </header>

  <!-- Verification Box -->
  <main>
    <div class="verify-box">
      <div class="back-arrow">←</div>
      <h4>Enter Verification Code</h4>
      <p>Your verification code is sent via Email to<br>
        <strong>JennBornilla@gmail.com</strong>
      </p>

      <div class="otp-inputs">
        <input type="text" maxlength="1">
        <input type="text" maxlength="1">
        <input type="text" maxlength="1">
        <input type="text" maxlength="1">
        <input type="text" maxlength="1">
        <input type="text" maxlength="1">
      </div>

      <p class="countdown">Pls wait until <span id="timer">300</span> seconds to resend</p>
      <button type="button" id="nextBtn">Next</button>

      <p id="errorMsg" class="error">Invalid OTP. Please try again.</p>
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
    // Countdown timer
    let timeLeft = 300;
    const timer = document.getElementById("timer");
    const countdown = setInterval(() => {
      timeLeft--;
      timer.textContent = timeLeft;
      if (timeLeft <= 0) clearInterval(countdown);
    }, 1000);

    // OTP validation
    const nextBtn = document.getElementById("nextBtn");
    const inputs = document.querySelectorAll(".otp-inputs input");
    const errorMsg = document.getElementById("errorMsg");

    nextBtn.addEventListener("click", () => {
      const otp = Array.from(inputs).map(i => i.value).join("");
      if (otp !== "123456") {
        errorMsg.style.display = "block";
        inputs.forEach(i => i.style.border = "1px solid red");
      } else {
        errorMsg.style.display = "none";
        alert("OTP verified successfully!");
      }
    });
  </script>

</body>
</html>
