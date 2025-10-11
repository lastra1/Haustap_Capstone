<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Haustap Chat</title>
  <link rel="stylesheet" href="css/contact-client.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- HEADER -->
  <header class="navbar">
    <div class="logo">
      <img src="images/logo.png" alt="logo">
    </div>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Bookings</a></li>
        <li><a href="#">About</a></li>
        <li class="active"><a href="#">Contact</a></li>
      </ul>
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

  <!-- CHAT SECTION -->
  <section class="chat-container">
    <div class="chat-header">Chats</div>

    <div class="chat-box">
      <!-- Sidebar -->
      <div class="chat-sidebar">
        <div class="search-bar">
          <input type="text" placeholder="Search Name">
          <select>
            <option>All</option>
          </select>
        </div>

        <div class="chat-list">
          <div class="chat-user">
            <i class="fa fa-user"></i>
            <div class="user-info">
              <p class="name">Name</p>
              <small>+639000000000</small>
            </div>
            <span class="time">Now</span>
          </div>

          <div class="chat-user">
            <i class="fa fa-user"></i>
            <div class="user-info">
              <p class="name">Name</p>
              <small>+639111111111</small>
            </div>
            <span class="time">Yesterday</span>
          </div>

          <div class="chat-user">
            <i class="fa fa-user"></i>
            <div class="user-info">
              <p class="name">Name</p>
              <small>+639222222222</small>
            </div>
            <span class="time">Monday</span>
          </div>

          <div class="chat-user">
            <i class="fa fa-user"></i>
            <div class="user-info">
              <p class="name">Name</p>
              <small>+639333333333</small>
            </div>
            <span class="time">Now</span>
          </div>
        </div>
      </div>

      <!-- Chat main -->
      <div class="chat-main">
        <div class="chat-top">Ana Santos</div>

        <div class="chat-messages">
          <div class="message left">
            <i class="fa fa-user"></i>
            <div class="bubble"></div>
          </div>

          <div class="message right">
            <div class="bubble"></div>
            <i class="fa fa-user"></i>
          </div>
        </div>

        <div class="chat-input">
          <input type="text" placeholder="Input message">
          <div class="icons">
            <i class="fa fa-paperclip"></i>
            <i class="fa fa-image"></i>
            <i class="fa fa-smile"></i>
          </div>
          <button><i class="fa fa-paper-plane"></i></button>
        </div>
      </div>
    </div>
  </section>

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
        <img src="C:\Users\user\Pictures\thesis\images\logo.png" alt="HausTap Logo" />
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
