<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Type of Cleaning | Homi</title>
  <link rel="stylesheet" href="css/indoor-cleaning.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="#"><img src="image/logo.png" alt="Haustap Logo"></a>
    </div>
    <nav class="nav">
      <a href="#">Home</a>
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
      <a href="#" class="account-link">
        <i class="fa fa-user account-icon"></i>
        My Account
      </a>
  </header>
  <main>
    <h1 class="main-title">Type of Cleaning</h1>
    <button class="cleaning-type-btn">Bungalow</button>
    <div class="cleaning-cards-container">
      <div class="cleaning-cards-row">
        <div class="cleaning-card">
          <input type="radio" name="cleaning" class="cleaning-radio" id="basic-cleaning">
          <label for="basic-cleaning" class="radio-label"></label>
          <div class="cleaning-title">Basic Cleaning – 1 Cleaner</div>
          <div class="cleaning-price">₱1,000</div>
          <div class="cleaning-inclusions-title">Inclusions:</div>
          <ul class="cleaning-inclusions">
            <li>Living Room: walls, mop, dusting furniture, trash removal</li>
            <li>Bedroom: bed making, sweeping, dusting, trash removal</li>
            <li>Hallways: mop & sweep, remove cobwebs</li>
            <li>Windows & Mirrors: quick wipe</li>
          </ul>
        </div>
        <div class="cleaning-card">
          <input type="radio" name="cleaning" class="cleaning-radio" id="standard-cleaning">
          <label for="standard-cleaning" class="radio-label"></label>
          <div class="cleaning-title">Standard Cleaning – 2 Cleaners</div>
          <div class="cleaning-price">₱2,000</div>
          <div class="cleaning-inclusions-title">Inclusions:</div>
          <ul class="cleaning-inclusions">
            <li>All Basic Cleaning tasks plus:</li>
            <li>Kitchen: wipe countertops, sink cleaning, stove top degrease, trash removal</li>
            <li>Bathrooms: scrub toilet, sink, shower, floor disinfecting</li>
            <li>Furniture: cleaning under/behind furniture</li>
            <li>Windows & Mirrors: full wipe & polish</li>
          </ul>
        </div>
      </div>
      <div class="cleaning-cards-row">
        <div class="cleaning-card wide">
          <input type="radio" name="cleaning" class="cleaning-radio" id="deep-cleaning">
          <label for="deep-cleaning" class="radio-label"></label>
          <div class="cleaning-title">Deep Cleaning – 3 Cleaners</div>
          <div class="cleaning-price">₱3,000</div>
          <div class="cleaning-inclusions-title">Inclusions:</div>
          <ul class="cleaning-inclusions">
            <li>All Standard Cleaning tasks plus:</li>
            <li>Flooring: scrubbing tiles/grout, polishing if applicable</li>
            <li>Appliances: behind refrigerator, oven, washing machine</li>
            <li>Carpets/Rugs: vacuum or shampoo</li>
            <li>Disinfection: doorknobs, switches, high-touch surfaces</li>
          </ul>
        </div>
      </div>
      <div class="cleaning-note">Cleaning materials are provided by the client</div>
      <nav class="pagination">
        <ul>
          <li><a href="#">«</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li><a href="#">»</a></li>
        </ul>
      </nav>
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