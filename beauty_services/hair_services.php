<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hair Services | Beauty Salon</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/hair_services.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
  <!-- HEADER -->
  <header class="header">
    <img src="images/logo.png" alt="HausTap" class="logo-img" />
    <nav class="nav">
      <a href="#">Home</a>
      <a href="#" class="active">Services</a>
      <a href="#">Bookings</a>
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

  <!-- MAIN CONTENT -->
  <main>
    <h1 class="main-title">Hair Services</h1>
    <button class="subcategory-btn">SUBCATEGORY</button>
    <nav class="subcategory-nav">
      <ul>
        <li class="active">Hair Services</li>
        <li>Nail Care</li>
        <li>Make-up</li>
        <li>Lashes</li>
        <li>Packages</li>
      </ul>
    </nav>

    <div class="services-container">
      <!-- HAIRCUTS -->
      <section class="service-section">
        <h2>Haircuts</h2>
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="haircut" checked />
            <div class="service-content">
              <h3>Basic Haircut (Men)</h3>
              <p class="price">Starts at ₱200</p>
              <p><strong>Inclusions:</strong><br>
                Professional haircut & basic styling<br />
                Shampoo & rinse (upon request)<br />
                Blow-dry finish
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="haircut" />
            <div class="service-content">
              <h3>Kiddie Haircut (Men)</h3>
              <p class="price">Starts at ₱100</p>
              <p><strong>Inclusions:</strong><br>
                Gentle haircut suitable for kids<br />
                Quick comb & styling<br />
                Free child-friendly handling
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="haircut" />
            <div class="service-content">
              <h3>Basic Haircut (Women)</h3>
              <p class="price">Starts at ₱300</p>
              <p><strong>Inclusions:</strong><br>
                Professional haircut & styling<br />
                Shampoo & conditioning wash<br />
                Blow-dry or light iron finish
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="haircut" />
            <div class="service-content">
              <h3>Kiddie Haircut (Women)</h3>
              <p class="price">Starts at ₱200</p>
              <p><strong>Inclusions:</strong><br>
                Gentle haircut suitable for kids<br />
                Simple styling (ponytail, braids, or blow-dry)<br />
                Free child-friendly handling
              </p>
            </div>
          </label>
        </div>
      </section>

      <!-- HAIR COLORING -->
      <section class="service-section">
        <h2>Hair Coloring</h2>
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="haircolor" />
            <div class="service-content">
              <h3>L’Oreal Full Hair Color (Short)</h3>
              <p class="price">Starts at ₱2,000–₱2,500</p>
              <p><strong>Inclusions:</strong><br>
                L’Oreal color application<br />
                Scalp & strand protection<br />
                Rinse and blow-dry<br />
                Basic styling
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="haircolor" />
            <div class="service-content">
              <h3>Highlights / Low Lights</h3>
              <p class="price">Starts at ₱2,500–₱3,200</p>
              <p><strong>Inclusions:</strong><br>
                Foil or balayage technique<br />
                Protective cream/treatment<br />
                Shampoo, rinse & blow-dry
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="haircolor" />
            <div class="service-content">
              <h3>L’Oreal Full Hair Color (Medium)</h3>
              <p class="price">Starts at ₱2,500–₱3,000</p>
              <p><strong>Inclusions:</strong><br>
                L’Oreal color application<br />
                Scalp & strand protection<br />
                Rinse & blow-dry<br />
                Basic styling
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="haircolor" />
            <div class="service-content">
              <h3>Balayage / Ombre</h3>
              <p class="price">Starts at ₱3,000–₱3,800</p>
              <p><strong>Inclusions:</strong><br>
                Professional balayage technique<br />
                Toner (if needed)<br />
                Protective treatment<br />
                Rinse & blow-dry
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="haircolor" />
            <div class="service-content">
              <h3>L’Oreal Full Hair Color (Long)</h3>
              <p class="price">Starts at ₱3,000–₱3,500</p>
              <p><strong>Inclusions:</strong><br>
                L’Oreal color application<br />
                Scalp & strand protection<br />
                Rinse and blow-dry<br />
                Basic styling
              </p>
            </div>
          </label>
        </div>
      </section>

      <!-- STRAIGHTENING -->
      <section class="service-section">
        <h2>Straightening</h2>
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="straightening" />
            <div class="service-content">
              <h3>L’Oreal Hair Straightening (Short)</h3>
              <p class="price">Starts at ₱2,000–₱3,000</p>
              <p><strong>Inclusions:</strong><br>
                Professional straightening<br />
                Heat protection serum<br />
                Blow-dry & ironing<br />
                Basic styling
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="straightening" />
            <div class="service-content">
              <h3>L’Oreal Hair Straightening (Medium)</h3>
              <p class="price">Starts at ₱3,000–₱4,000</p>
              <p><strong>Inclusions:</strong><br>
                Professional straightening<br />
                Heat protection serum<br />
                Blow-dry & ironing<br />
                Basic styling
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="straightening" />
            <div class="service-content">
              <h3>L’Oreal Hair Straightening (Long)</h3>
              <p class="price">Starts at ₱4,000–₱5,500</p>
              <p><strong>Inclusions:</strong><br>
                Professional straightening<br />
                Heat protection serum<br />
                Blow-dry & ironing<br />
                Basic styling
              </p>
            </div>
          </label>
        </div>
      </section>

      <!-- HAIR STYLING -->
      <section class="service-section">
        <h2>Hair Styling</h2>
        <div class="service-grid">
          <label class="service-card">
            <input type="radio" name="hairstyling" />
            <div class="service-content">
              <h3>Blow-Dry (Straight)</h3>
              <p class="price">₱300 per head</p>
              <p><strong>Inclusions:</strong><br>
                Shampoo wash (optional)<br />
                Blow-dry with brush styling
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="hairstyling" />
            <div class="service-content">
              <h3>Blow-Dry (Curls/Waves)</h3>
              <p class="price">₱400 per head</p>
              <p><strong>Inclusions:</strong><br>
                Shampoo wash (optional)<br />
                Blow-dry with curling/waving<br />
                Light hair spray finish
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="hairstyling" />
            <div class="service-content">
              <h3>Event Hairstyling</h3>
              <p class="price">₱500 per head</p>
              <p><strong>Inclusions:</strong><br />
                Updo, curls, or themed look<br />
                Use of heat tools<br />
                Setting with hairspray
              </p>
            </div>
          </label>

          <label class="service-card">
            <input type="radio" name="hairstyling" />
            <div class="service-content">
              <h3>Hair Accessories Styling</h3>
              <p class="price">₱400 per head</p>
              <p><strong>Inclusions:</strong><br />
                Styling with accessories<br />
                Secure fitting & adjustment<br />
                Final touch-ups
              </p>
            </div>
          </label>
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
