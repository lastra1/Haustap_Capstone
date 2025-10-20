<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Current Password</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/current_password.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
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
      <li><a href="#" class="active">Profile</a></li>
      <li><a href="#">Addresses</a></li>
      <li><a href="#">Privacy Settings</a></li>
    </ul>
  </div>
  <ul class="sidebar-secondary">
    <li><i class="fa-solid fa-user-group"></i> Referral</li>
    <li><i class="fa-solid fa-ticket"></i> My Vouchers</li>
    <li><i class="fa-solid fa-link"></i> Connect Haustap</li>
    <li><i class="fa-solid fa-file-contract"></i> Terms and Conditions</li>
    <li><i class="fa-solid fa-star"></i> Rate HOMI</li>
    <li><i class="fa-solid fa-circle-info"></i> About us</li>
  </ul>

  <button class="logout-btn">Log out</button>
</aside>

<div class="change-password-page">
  <div class="change-password-box">
    <div class="change-password-header">
      <button class="back-btn"><i class="fas fa-arrow-left"></i></button>
      <h2>Enter Your Password</h2>
    </div>

    <form class="password-form" method="POST" action="#">
     
      <div class="form-group password-toggle">
        
        <div class="input-wrapper">
          <input type="password" id="new-password" name="new_password" placeholder="Enter your password">
          <i class="fas fa-eye toggle-icon"></i>
        </div>
      </div>


      <button type="submit" class="submit-btn">Confirm</button>
    </form>
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
  
</body>
</html>