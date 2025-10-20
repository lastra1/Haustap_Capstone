<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account Addresses</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  
  <link rel="stylesheet" href="css/account_address.css" />
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
              <li><a href="#" class="active">Addresses</a></li>
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
        </nav>
      </aside>

      <!-- RIGHT SECTION: ADDRESSES -->
      <section class="profile-section">
  <div class="profile-box">
    <div class="address-header">
      <h2 class="profile-header">Addresses</h2>
      <button class="add-address-btn"><i class="fa fa-plus"></i> Add New Address</button>
    </div>
    <hr class="divider">

    <!-- Address Card 1 -->
    <div class="address-box">
      <div class="address-info">
        <p class="address-name">Jen Bornilla</p>
        <p class="address-details">
          123 P. Burgos Street, Brgy. San Isidro, Quezon City, Metro Manila
        </p>
      </div>
      <div class="address-actions">
        <div class="action-top">
          <button class="edit-btn">Edit</button>
          <button class="delete-btn">Delete</button>
        </div>
          <button class="default-btn">Set as Default</button>
      </div>
    </div>

    <!-- Address Card 2 -->
    <div class="address-box">
      <div class="address-info">
        <p class="address-name">Maria Santos</p>
        <p class="address-details">
          45 Mabini Street, Brgy. Malate, Manila City, Metro Manila
        </p>
      </div>
      <div class="address-actions">
        <div class="action-top">
          <button class="edit-btn">Edit</button>
          <button class="delete-btn">Delete</button>
        </div>
          <button class="default-btn">Set as Default</button>
      </div>
    </div>
  </div>
</section>
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
