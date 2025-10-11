<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Booking Location</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/booking_location.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
  <!-- HEADER -->
  <header class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img" />
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#" class="active">Bookings</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </nav>
    <div class="header-right">
      <div class="search-box">
        <input type="text" placeholder="Search services" />
        <i class="fa fa-search"></i>
      </div>
      <a href="#" class="account-link">
        <i class="fa fa-user account-icon"></i> My Account
      </a>
    </div>
  </header>

 <main class="booking-location-page">
    <h1 class="page-title">Booking Location</h1>
    <button class="subcategory-btn"><b>Bungalow</b></button>

    <section class="booking-layout">
      <!-- LEFT SIDE -->
      <div class="left-column">
        <!-- Pin Location Box -->
        <div class="pin-box">
          <label for="pinLocation"><i class="fa fa-map-marker" aria-hidden="true"></i> Pin Location:</label>
          <input type="text" id="pinLocation" placeholder="Pin your location" />
        </div>

        <!-- Insert Type of House Box -->
        <div class="house-type-box">
          <label for="houseType"><i class="fa fa-home" aria-hidden="true"></i> Insert Type of House:</label>
          <input type="text" id="houseType" placeholder="Insert Type of House #" />
        </div>

        <!-- Map Container (Ready for Backend Integration) -->
        <div id="map" class="map-container">
          <p class="map-placeholder-text">Map area (ready for API integration)</p>
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="right-column">
        <!-- Set Address Box -->
        <div class="address-box">
          <div class="address-header">
            <i class="fa-solid fa-house icon"></i>
            <h3>Set Address</h3>
          </div>
          <div class="address-body">
            <p>Blk 11 Lot 6 Mary St. Saint Joseph Village 10<br>
              Brgy. Langgam San Pedro City, Laguna</p>
            <button class="edit-btn">Edit</button>
          </div>
        </div>

        <!-- Saved Address Box -->
        <div class="address-box">
          <div class="address-header">
            <div class="header-left">
              <i class="fa-solid fa-floppy-disk icon"></i>
              <h3>Saved Address</h3>
            </div>
            <input type="radio" name="savedAddress" />
          </div>
          <div class="address-body">
            <p>Blk 11 Lot 6 Apple St. Saint Joseph Village 10<br>
              Brgy. Langgam San Pedro City, Laguna</p>
          </div>
        </div>
      </div>
    </section>

    <!-- PAGINATION -->
    <div class="pagination">
      <button>&lt;</button>
      <button class="active">1</button>
      <button class="active">2</button>
      <button class="active">3</button>
      <button>4</button>
      <button>&gt;</button>
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
</body>
</html>
