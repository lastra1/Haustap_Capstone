<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outdoor Services - Homi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/Outdoor-Services.css">
</head>
<body>
    <header>
        <div class="logo">
            <div class="logo-icon">
                <img src="image/logo.png" alt="Homi Logo">
            </div>
        </div>
        
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#bookings">Bookings</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>

        <div class="header-right">
            <div class="search-bar">
                <input type="text" placeholder="Search services">
                <i class="fas fa-search"></i>
            </div>
            <a href="#account" class="account-link">My Account</a>
        </div>
    </header>

    <main>
        <h1 class="section-title">Outdoor Services</h1>

        <div class="category-section">
            <h2 class="category-title">Gardening & Landscaping</h2>
            
            <h3 class="subsection-title">Type of Garden</h3>
            
            <div class="garden-options">
                <div class="garden-card">
                    <div class="garden-info">
                        <h3>Small Garden</h3>
                        <p class="size">up to 50 sqm</p>
                        <p class="description">A compact outdoor space for light maintenance.</p>
                    </div>
                    <div class="radio-btn">
                        <input type="radio" name="garden" value="small">
                    </div>
                </div>

                <div class="garden-card">
                    <div class="garden-info">
                        <h3>Medium Garden</h3>
                        <p class="size">50-150 sqm</p>
                        <p class="description">A moderate-sized outdoor area, common in family homes.</p>
                    </div>
                    <div class="radio-btn">
                        <input type="radio" name="garden" value="medium">
                    </div>
                </div>

                <div class="garden-card">
                    <div class="garden-info">
                        <h3>Large Garden</h3>
                        <p class="size">(150-250 sqm)</p>
                        <p class="description">Expansive outdoor areas, often for villas or mansions.</p>
                    </div>
                    <div class="radio-btn">
                        <input type="radio" name="garden" value="large">
                    </div>
                </div>
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