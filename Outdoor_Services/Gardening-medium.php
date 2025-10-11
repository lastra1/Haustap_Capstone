<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gardening Services - Haustap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/Gardening-medium.css">
</head>
<body>
    <header>
        <div class="logo">
            <div class="logo-icon">
                <img src="image/logo.png" alt="Haustap Logo">
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
        <h1 class="section-title">Type of Gardening</h1>
        
        <div class="garden-type">
            <span class="garden-type-badge">Medium Garden</span>
        </div>

        <h2 class="subtitle">Gardening & Landscaping</h2>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-header">
                    <div>
                        <h3 class="service-title">Inspection Fee</h3>
                        <p class="service-price">₱300</p>
                        <p class="service-note">Additional fee per gardener for inspection</p>
                    </div>
                    <div class="service-icon">
                        <input type="radio" name="service" value="inspection">
                    </div>
                </div>
                <div class="inclusions">
                    <p>Inspection for gardening and landscaping involves assessing the site's soil quality, drainage, and overall layout to ensure it meets healthy plant growth. It also helps identify any preparations or adjustments needed before starting the project for optimal results.</p>
                </div>
            </div>

            <div class="service-card">
                <div class="service-header">
                    <div>
                        <h3 class="service-title">Basic – 1 gardener</h3>
                        <p class="service-price">₱600</p>
                    </div>
                    <div class="service-icon">
                        <input type="radio" name="service" value="basic">
                    </div>
                </div>
                <div class="inclusions">
                    <p class="inclusions-title">Inclusions:</p>
                    <ul>
                        <li>Lawn mowing / trimming</li>
                        <li>Removing wilted leaves</li>
                        <li>Watering & basic upkeep</li>
                    </ul>
                </div>
            </div>

            <div class="service-card">
                <div class="service-header">
                    <div>
                        <h3 class="service-title">Standard – 2 gardeners</h3>
                        <p class="service-price">₱1,200</p>
                    </div>
                    <div class="service-icon">
                        <input type="radio" name="service" value="standard">
                    </div>
                </div>
                <div class="inclusions">
                    <p class="inclusions-title">Inclusions:</p>
                    <ul>
                        <li>All Basic tasks</li>
                        <li>Hedge & shrub trimming</li>
                        <li>Soil cultivation & fertilization</li>
                        <li>Flower bed maintenance</li>
                    </ul>
                </div>
            </div>

            <div class="service-card">
                <div class="service-header">
                    <div>
                        <h3 class="service-title">Deep – 3 gardeners</h3>
                        <p class="service-price">₱2,100</p>
                    </div>
                    <div class="service-icon">
                        <input type="radio" name="service" value="deep">
                    </div>
                </div>
                <div class="inclusions">
                    <p class="inclusions-title">Inclusions:</p>
                    <ul>
                        <li>All Standard tasks</li>
                        <li>Lawn care (mow, edge, fertilize)</li>
                        <li>Tree/shrub pruning</li>
                        <li>Landscaping touch-up (arrangement, mulch, stones)</li>
                        <li>Waste disposal</li>
                    </ul>
                </div>
            </div>
        </div>

        <p class="materials-note">*Materials are provided by the client</p>
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