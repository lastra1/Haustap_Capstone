<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Account | My Vouchers</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/my_voucher.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
  <!-- HEADER -->
  <header class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img" />
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#">Bookings</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </nav>
    <div class="header-right">
      <div class="icon-button notification-box">
        <i class="fa-regular fa-bell"></i>
      </div>

      <a href="#" class="icon-button account-link">
        <i class="bi bi-person-circle"></i>
        <span>My Account</span>
      </a>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="account-page">
    <div class="account-container">
      <!-- LEFT SIDEBAR -->
      <aside class="sidebar">
        <div class="profile-card">
          <div class="profile-header-side">
            <i class="fa-solid fa-user fa-2x"></i>
            <div class="profile-text">
              <p class="profile-name">Jenn Bornilla</p>
              <button class="edit-profile-btn">
                <i class="fa-solid fa-pen"></i> Edit Profile
              </button>
            </div>
          </div>
        </div>

        <nav class="sidebar-nav">
          <div class="sidebar-nav-group">
            <h4><i class="fa-solid fa-user-circle"></i> My Account</h4>
            <ul>
              <li><a href="#">Profile</a></li>
              <li><a href="#">Addresses</a></li>
              <li><a href="#">Privacy Settings</a></li>
            </ul>
          </div>
          <ul class="sidebar-secondary">
            <li><i class="fa-solid fa-user-group"></i> Referral</li>
            <li><a href="#" class="active"><i class="fa-solid fa-ticket"></i> My Vouchers</a></li>
            <li><i class="fa-solid fa-link"></i> Connect Haustap</li>
            <li><i class="fa-solid fa-file-contract"></i> Terms and Conditions</li>
            <li><i class="fa-solid fa-star"></i> Rate HOMI</li>
            <li><i class="fa-solid fa-circle-info"></i> About us</li>
          </ul>

          <button class="logout-btn">Log out</button>
        </nav>
      </aside>

      <!-- RIGHT SECTION: MY VOUCHERS -->
      <section class="profile-section">
        <div class="profile-box voucher-box">
          <div class="voucher-header">
            <h2>My Vouchers</h2>
            <a href="#" class="view-history">View Voucher History</a>
          </div>
          <hr class="divider">

          <!-- Loyalty Bonus -->
          <section class="loyalty-section">
            <h3>Unlock your Loyalty Bonus</h3>
            <p>Once you completed the remaining bookings you can enjoy a <strong>₱50 voucher</strong></p>

            <div class="progress-container">
              <p class="progress-title">Complete 10 Bookings</p>
              <div class="progress-circles">
                <div class="circle filled"></div>
                <div class="circle filled"></div>
                <div class="circle filled"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle final">₱50 Voucher</div>
              </div>
              <p class="progress-sub">Complete within 3 months</p>
            </div>

            <p class="progress-note">
              Complete your 10 remaining bookings to earn a ₱50 voucher
            </p>
          </section>

          <hr class="divider">

          <!-- Exclusive Vouchers -->
          <section class="exclusive-section">
            <h3>Enjoy Exclusive HOMI Vouchers</h3>
            <div class="voucher-grid">
              <div class="voucher-card">
                <h4>Welcome Voucher</h4>
                <p><strong>₱50 OFF for First-Time Users</strong></p>
                <p>New here? Book your first service today and enjoy ₱50 off as our welcome gift.</p>
                <p class="condition">Condition: First time users only</p>
              </div>

              <div class="voucher-card">
                <h4>Referral Bonus</h4>
                <p><strong>Earn ₱10 Voucher for every Successful Referral</strong></p>
                <p>Share HAUSTAP with friends! Once your friend completes their first booking, you earn ₱10 voucher.</p>
                <p class="condition">Condition: Voucher will be activated after your friend's first completed booking</p>
              </div>

              <div class="voucher-card">
                <h4>Loyalty Bonus</h4>
                <p><strong>₱50 Voucher after 10 Completed Bookings</strong></p>
                <p>After 10 completed bookings, enjoy a ₱50 voucher as our thank-you gift.</p>
                <p class="condition">Condition: Must be completed within 3 months</p>
              </div>
            </div>
          </section>
        </div>
      </section>
    </div>
  </main>

  <!-- FOOTER -->
  <footer>
    <div class="footer-content">
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

      <div class="footer-center">
        <img src="images/logo.png" alt="HausTap Logo" />
        <p>Your space. Your peace. Your Glow</p>
      </div>

      <div class="footer-right">
        <h4>FOLLOW US</h4><br>
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
</body>
</html>
