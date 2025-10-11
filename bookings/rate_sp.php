 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HausTap Bookings</title>
  <link rel="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/rate_sp.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

  <!-- Header -->
   <div class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img">
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#" class="active">Bookings</a>
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
    </div>
  </div>
 
 <main class="rate-container">
    <p>Rate Your Service Provider</p>

    <div class="service-info">
      <h3>Home Cleaning</h3>
      <h3>Bungalow - Basic Cleaning</h3>
      <p>Provider: Ana Santos | Date: May 21, 2025</p>
    </div>

    <div class="rating-overall">
      <span class="label">Overall Rating</span>
      <div class="stars">
        <span class="star">★</span>
        <span class="star">★</span>
        <span class="star">★</span>
        <span class="star">★</span>
        <span class="star">★</span>
        <span class="rating-text">Amazing</span>
      </div>
    </div>

    <div class="experience-box">
      <p class="experience-title">Tell us about your experience with the service</p>
      <textarea placeholder="Share your thoughts here..."></textarea>

      <div class="experience-actions">
        <div class="left-buttons">
          <button class="btn-photo">📷 Add Photo</button>
          <button class="btn-video">🎥 Add Video</button>
        </div>
        <small class="right-note">Add 100 characters with 1 photo and 1 video</small>
      </div>
    </div>

    <div class="privacy-section">
      <label>
        <input type="checkbox">
        Show username on your review
      </label>
      <p class="small-text">Your name will be shown as "username"</p>
    </div>

    <div class="aspect-section">
      <span class="section-title">Rate Specific Aspects</span>
      <ul>
        <li>Professionalism <span class="star-group">★★★★★</span></li>
        <li>Punctuality <span class="star-group">★★★★★</span></li>
        <li>Quality of Work <span class="star-group">★★★★★</span></li>
        <li>Communication <span class="star-group">★★★★★</span></li>
      </ul>

      <span class="section-title">About Service</span>
      <ul>
        <li>Booking Process <span class="star-group">★★★★★</span></li>
        <li>Value for Money <span class="star-group">★★★★★</span></li>
      </ul>
    </div>

    <div class="form-actions">
      <button class="btn-cancel">Cancel</button>
      <button class="btn-submit">Submit</button>
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
