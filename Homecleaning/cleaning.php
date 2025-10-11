<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cleaning Services - Homi</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/cleaning.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="/" class="logo">
            <img src="image/logo.png" alt="HausTap" class="logo-img">
        </a>
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

    <!-- Main Content -->
    <main class="cleaning-container">
        <section class="type-selector">
            <h2>Type of Cleaning</h2>
            <select>
                <option value="bungalow">Bungalow</option>
                <option value="condo">Condominium</option>
                <option value="duplex">Duplex</option>
                <option value="hotel">Hotel</option>
                <option value="Motel">Motel</option>
                <option value="Container House">Container House</option>
                <option value="Stilt">Stilt House</option>
                <option value="Mansion">Mansion</option>
                <option value="Villa">Villa</option>
            </select>
        </section>

        <!-- Cleaning Packages -->
        <section class="cleaning-packages">
            <!-- Basic Cleaning -->
            <div class="cleaning-package">
                <div class="package-header">
                    <h3>
                        <span class="package-title">Basic Cleaning - 1 Cleaner</span>
                        <input type="radio" name="cleaning-package" value="basic" class="package-radio">
                    </h3>
                    <span class="price">₱1,000</span>
                </div>
                <div class="package-details">
                    <p>Inclusions:</p>
                    <ul>
                        <li>Living Room: walls, mop, dusting furniture, trash removal</li>
                        <li>Bedroom: bed making, sweeping, dusting, trash removal</li>
                        <li>Hallways: mop & sweep, remove cobwebs</li>
                        <li>Windows & Mirrors: quick wipe</li>
                    </ul>
                </div>
            </div>

            <!-- Standard Cleaning -->
            <div class="cleaning-package">
                <div class="package-header">
                    <h3>
                        <span class="package-title">Standard Cleaning - 2 Cleaners</span>
                        <input type="radio" name="cleaning-package" value="standard" class="package-radio">
                    </h3>
                    <span class="price">₱2,000</span>
                </div>
                <div class="package-details">
                    <p>Inclusions:</p>
                    <ul>
                        <li>All Basic Cleaning tasks plus:</li>
                        <li>Kitchen: wipe countertops, sink cleaning, stove top degrease, trash removal</li>
                        <li>Bathroom: cleaning all surfaces, shower, floor disinfecting</li>
                        <li>Furniture: dusting under/behind furniture</li>
                        <li>Windows & Mirrors: full wipe & polish</li>
                    </ul>
                </div>
            </div>

            <!-- Deep Cleaning -->
            <div class="cleaning-package">
                <div class="package-header">
                    <h3>
                        <span class="package-title">Deep Cleaning - 3 Cleaners</span>
                        <input type="radio" name="cleaning-package" value="deep" class="package-radio">
                    </h3>
                    <span class="price">₱3,000</span>
                </div>
                <div class="package-details">
                    <p>Inclusions:</p>
                    <ul>
                        <li>All Standard Cleaning tasks plus:</li>
                        <li>Flooring: scrubbing stains/grout, polishing if applicable</li>
                        <li>Appliances: defrost refrigerator, oven, washing machine</li>
                        <li>Cabinet tops: dusting and cleaning</li>
                        <li>Disinfection: doorknobs, switches, high-touch surfaces</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Pagination -->
        <div class="pagination">
            <button>&lt;</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button>4</button>
            <button>5</button>
            <button>&gt;</button>
        </div>

        <p class="cleaning-note">Cleaning materials are provided by the client</p>
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