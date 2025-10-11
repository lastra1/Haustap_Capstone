<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Booking Schedule</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/booking_schedule.css" />
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

<main class="booking-schedule">
    <h1 class="page-title">Booking Schedule</h1>
    <button class="subcategory-btn"><b>Bungalow</b></button>

    <section class="schedule-box">
      <h2 class="section-title">DATE</h2>

      <div class="date-grid">
        <!-- Example static list for UI only -->
        <label class="date-box">
          <input type="radio" name="date" />
          <div class="date-text"><strong>Oct 6, 2025</strong><br>Monday</div>
        </label>

        <label class="date-box today">
          <input type="radio" name="date" />
          <div class="date-text"><strong>Oct 7, 2025</strong><br>Tuesday - Today</div>
        </label>

        <label class="date-box">
          <input type="radio" name="date" />
          <div class="date-text"><strong>Oct 8, 2025</strong><br>Wednesday</div>
        </label>

        <label class="date-box">
          <input type="radio" name="date" />
          <div class="date-text"><strong>Oct 9, 2025</strong><br>Thursday</div>
        </label>

        <label class="date-box">
          <input type="radio" name="date" />
          <div class="date-text"><strong>Oct 10, 2025</strong><br>Friday</div>
        </label>

        <label class="date-box">
          <input type="radio" name="date" />
          <div class="date-text"><strong>Oct 11, 2025</strong><br>Saturday</div>
        </label>

        <label class="date-box">
          <input type="radio" name="date" />
          <div class="date-text"><strong>Oct 12, 2025</strong><br>Sunday</div>
        </label>
      </div>

      <h2 class="section-title">TIME</h2>
      <select class="time-select">
        <option selected disabled>Select Time</option>
        <option>8:00 AM</option>
        <option>9:00 AM</option>
        <option>10:00 AM</option>
        <option>11:00 AM</option>
        <option>12:00 PM</option>
        <option>1:00 PM</option>
        <option>2:00 PM</option>
        <option>3:00 PM</option>
        <option>4:00 PM</option>
      </select>
    </section>

    <div class="pagination">
      <button>&lt;</button>
      <button class="active">1</button>
      <button class="active">2</button>
      <button class="active">3</button>
      <button class="active">4</button>
      <button>5</button>
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
