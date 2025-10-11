<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Cleaning Services | Homi</title>
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
    <h1 class="main-title">Cleaning Services</h1>
    <button class="subcategory-btn">SUBCATEGORY</button>
    <div class="centered-section">
        <div class="breadcrumbs">
      <a href="#">Home cleaning</a>
      <span> | </span>
      <a href="#">AC cleaning</a>
    </div>
      <div class="section-title">Type of House</div>
      <section class="house-group">
        <h2>Bungalow</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="bungalow">
            <label for="bungalow" class="radio-label"></label>
            <div class="house-title">Bungalow</div>
            <div class="house-desc">80-120 sqm<br>Single-story with wider living spaces, ideal for families.</div>
          </div>
        </div>
        <h2>Condominium</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="condo-studio">
            <label for="condo-studio" class="radio-label"></label>
            <div class="house-title">Condominium Studio / 1BR</div>
            <div class="house-desc">20-50 sqm<br>For singles, couples, or small families.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="condo-2br">
            <label for="condo-2br" class="radio-label"></label>
            <div class="house-title">Condominium 2BR</div>
            <div class="house-desc">60-100 sqm<br>2-bedroom units for small families, can add maid's room.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="condo-penthouse">
            <label for="condo-penthouse" class="radio-label"></label>
            <div class="house-title">Condominium Penthouse</div>
            <div class="house-desc">&gt;150 sqm<br>Luxury units at the top floor with variable, roomy unit sizes.</div>
          </div>
        </div>
        <h2>Duplex</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="duplex-sm">
            <label for="duplex-sm" class="radio-label"></label>
            <div class="house-title">Duplex</div>
            <div class="house-desc">Elevated 60-100 sqm<br>Shared wall, two separate entrances under one roof.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="duplex-lg">
            <label for="duplex-lg" class="radio-label"></label>
            <div class="house-title">Duplex</div>
            <div class="house-desc">Larger 120-200 sqm<br>2-storey duplex units with more functional areas.</div>
          </div>
        </div>
        <h2>Hotel</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="hotel-sm">
            <label for="hotel-sm" class="radio-label"></label>
            <div class="house-title">Hotel</div>
            <div class="house-desc">Suite (15-50 sqm)<br>Hotel rooms or suites with all guest areas.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="hotel-lg">
            <label for="hotel-lg" class="radio-label"></label>
            <div class="house-title">Hotel</div>
            <div class="house-desc">Suite (50-150 sqm)<br>Hotel suites with more entertaining and guest areas.</div>
          </div>
        </div>
        <h2>Motel</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="motel-sm">
            <label for="motel-sm" class="radio-label"></label>
            <div class="house-title">Motel</div>
            <div class="house-desc">Standard Room (15-30 sqm)<br>Basic lodging. Usually single room and bath.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="motel-lg">
            <label for="motel-lg" class="radio-label"></label>
            <div class="house-title">Motel</div>
            <div class="house-desc">Larger Room (30-60 sqm)<br>A lodging larger room with more unit amenities.</div>
          </div>
        </div>
        <h2>Container House</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="container-sm">
            <label for="container-sm" class="radio-label"></label>
            <div class="house-title">Container House</div>
            <div class="house-desc">Single (20-40 sqm)<br>Single modular prefab, suitable urban starter type.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="container-lg">
            <label for="container-lg" class="radio-label"></label>
            <div class="house-title">Container House</div>
            <div class="house-desc">Multiple (40-120 sqm)<br>Modular designs for combined families with more amenities.</div>
          </div>
        </div>
        <h2>Stilt House</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="stilt-sm">
            <label for="stilt-sm" class="radio-label"></label>
            <div class="house-title">Stilt House</div>
            <div class="house-desc">Small (30-60 sqm)<br>Raised structure, usually for shore or coastal areas.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="stilt-lg">
            <label for="stilt-lg" class="radio-label"></label>
            <div class="house-title">Stilt House</div>
            <div class="house-desc">Large (100-200 sqm)<br>Houses with more living and bathing areas.</div>
          </div>
        </div>
        <h2>Mansion</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="mansion-sm">
            <label for="mansion-sm" class="radio-label"></label>
            <div class="house-title">Mansion</div>
            <div class="house-desc">Small (150-300 sqm)<br>Luxury house usually with luxury features and staff rooms.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="mansion-lg">
            <label for="mansion-lg" class="radio-label"></label>
            <div class="house-title">Mansion</div>
            <div class="house-desc">Larger (300-1000 sqm)<br>Luxury mansion with more entertaining, staff and bath areas.</div>
          </div>
        </div>
        <h2>Villa</h2>
        <div class="house-cards">
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="villa-sm">
            <label for="villa-sm" class="radio-label"></label>
            <div class="house-title">Villa</div>
            <div class="house-desc">Villa (100-250 sqm)<br>Standalone house with wider garden or garden + pool.</div>
          </div>
          <div class="house-card">
            <input type="radio" name="house" class="house-radio" id="villa-lg">
            <label for="villa-lg" class="radio-label"></label>
            <div class="house-title">Villa</div>
            <div class="house-desc">Larger (250-1000 sqm)<br>Luxury villa with more entertaining, bath and staff rooms.</div>
          </div>
        </div>
      </section>
    </div>
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