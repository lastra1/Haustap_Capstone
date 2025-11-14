<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HausTap Bookings</title>
  <link rel="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/booking.css">
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
  
  <!-- tabs -->
  <div class="mytabs">
    <input type="radio" id="tabpending" name="mytabs" checked="checked">
      <label for="tabpending">Pending</label>
      <div class="tab">
        
        <div class="booking_tables">
        <div class="booking-header">
          <div>
            <h2>Home Cleaning</h2>
            <p>Bungalow - Basic Cleaning</p>
          </div>
          <div class="booking-status">
          <span>Booking ID</span>
          <span class="status">|</span>
          <span class="status">PENDING</span>
          </div>
        </div>
        </div>
        <!-- Details -->
        <div class="booking-details">
          <div class="detail">
          <strong>Date</strong>
          <p>May 21, 2025</p>
          </div>
          <div class="detail">
          <strong>Time</strong>
          <p>11:00 AM - 2:00 PM</p>
          </div>
          <div class="detail address">
          <strong>Address</strong>
          <p>B1 L50 Mango st. Phase 1 Saint Joseph Village 10<br>
          Barangay Langgam, City of San Pedro, Laguna 4023</p>
          </div>
        </div>
        <div class="booking-details">
            <div class="detail full-width">
              <span>Total:</span>
              <span>₱2,500</span>
            </div>
        </div>

        <!-- booking-footer -->
        <div class="booking-footer">
          <div class="total">
            <strong></strong>
            <span></span>
          </div>
          <div class="actions">
            <button class="proceed">Proceed</button>
            <div class="dropdown">
              <button class="btn btn-outline-dark dropdown-toggle" type="more" data-bs-toggle="dropdown">More</button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Contact Seller</a></li>
                <li><a class="dropdown-item" href="#">Buy Again</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="after-bookings">
      <p>No more scheduled booking</p>
    </div>

      </div>
      

      <input type="radio" id="tabongoing" name="mytabs" checked="checked">
      <label for="tabongoing">Ongoing</label>
      <div class="tab">
        <div class="booking_tables">
        <div class="booking-header">
          <div>
            <h2>Home Cleaning</h2>
            <p>Bungalow - Basic Cleaning</p>
          </div>
          <div class="booking-status">
          <span>Booking ID</span>
          <span class="status">ONGOING</span>
          </div>
        </div>
        </div>
        <!-- Details -->
        <div class="booking-details">
          <div class="detail">
          <strong>Date</strong>
          <p>May 21, 2025</p>
          </div>
          <div class="detail">
          <strong>Time</strong>
          <p>11:00 AM - 2:00 PM</p>
          </div>
          <div class="detail address">
          <strong>Address</strong>
          <p>B1 L50 Mango st. Phase 1 Saint Joseph Village 10<br>
          Barangay Langgam, City of San Pedro, Laguna 4023</p>
          </div>
        </div>
          <div class="booking-details">
  <div class="detail full-width total-line">
    <span class="label">Total:</span>
    <span class="price">₱2,500</span>
  </div>
  <p class="payment-note">
    Full payment will be collected directly by the service provider upon completion of the service.
  </p>
</div>

        <!-- booking-footer -->
        <div class="booking-footer">
          <div class="service-provider">
            <div class="service-provider-top">
              <i class="fa fa-user account-icon"></i>
              <span class="name">Ana Santos</span>
              <i class="fa fa-comment message-icon"></i>
            </div>
            <div class="rating">
              ⭐ (4.9)
            </div>
          </div>
          <div class="actions">
            <div class="dropdown">
              <button class="btn btn-outline-dark dropdown-toggle" type="view_progress" data-bs-toggle="dropdown">View Progress</button>
              <ul class="dropdown-menu progress-menu">
                <li><a class="dropdown-item" href="#"><b>View Progress</b></a></li>
                <li><a class="dropdown-item" href="#">Timeline:</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa fa-check-square completed"></i> Worker confirmed</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa fa-check-square completed"></i> Worker arrived</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa fa-hourglass-half"></i> Service in progress</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa fa-empty"></i> Service completed</a></li>
              </ul>
            </div>
            <div class="dropdown">
              <button class="btn btn-outline-dark dropdown-toggle" type="more" data-bs-toggle="dropdown">More</button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Contact Seller</a></li>
                <li><a class="dropdown-item" href="#">Buy Again</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      

      <input type="radio" id="tabcompleted" name="mytabs" checked="checked">
      <label for="tabcompleted">Completed</label>
      <div class="tab">
        <div class="booking_tables">
        <div class="booking-header">
          <div>
            <h2>Home Cleaning</h2>
            <p>Bungalow - Basic Cleaning</p>
          </div>
          <div class="booking-status">
          <span>Booking ID</span>
          <span class="status">COMPLETED</span>
          </div>
        </div>
        </div>
        <!-- Details -->
        <div class="booking-details">
          <div class="detail">
          <strong>Date</strong>
          <p>May 21, 2025</p>
          </div>
          <div class="detail">
          <strong>Time</strong>
          <p>11:00 AM - 2:00 PM</p>
          </div>
          <div class="detail address">
          <strong>Address</strong>
          <p>B1 L50 Mango st. Phase 1 Saint Joseph Village 10<br>
          Barangay Langgam, City of San Pedro, Laguna 4023</p>
          </div>
        </div>
        <div class="booking-details">
            <div class="detail full-width">
              <span>Total:</span>
              <span>₱2,500</span>
            </div>
        </div>

        <!-- booking-footer -->
        <div class="booking-footer">
          <div class="service-provider">
            <div class="service-provider-top">
              <i class="fa fa-user account-icon"></i>
              <span class="name">Ana Santos</span>
              <i class="fa fa-comment message-icon"></i>
            </div>
            <div class="rating">
              ⭐ (4.9)
            </div>
          </div>
          <div class="actions">
            <button class="rate">Rate</button>
            <div class="dropdown">
              <button class="btn btn-outline-dark" type="button" data-bs-toggle="dropdown">
                Request for Return
              </button>
            <div class="dropdown-menu request-return p-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="mb-0">Service Issue. How Can We Help?</h6>
              <button type="button" class="btn-close" data-bs-dismiss="dropdown" aria-label="Close"></button>
              </div>
<!-- Option 1 -->
              <div class="form-check border p-2 mb-2 rounded">
                <input class="form-check-input" type="checkbox" id="issue1" checked>
                <label class="form-check-label fw-bold" for="issue1">
                The service was completed, but I have issues
                </label>
                <small class="text-muted d-block">
                I received service that is incomplete, defective, or not as agreed.
                </small>
              </div>

<!-- Option 2 -->
              <div class="form-check border p-2 rounded">
                <input class="form-check-input" type="checkbox" id="issue2">
                <label class="form-check-label fw-bold" for="issue2">
                The service was not fully completed
                </label>
                <small class="text-muted d-block">
                 Missing work, incomplete tasks, or service provider left early.
                </small>
              </div>
            </div>
            <div class="dropdown">
              <button class="btn btn-outline-dark" type="more" data-bs-toggle="dropdown">More</button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Contact Seller</a></li>
            <li><a class="dropdown-item" href="#">Buy Again</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <p class="return-reminder">
  Reminder: You may request a return for free within 24 hours after the service. <br>
  After 24 hours, a ₱300 return fee will be charged.
</p>
      </div>

      <input type="radio" id="tabcancelled" name="mytabs" checked="checked">
      <label for="tabcancelled">Cancelled</label>
      <div class="tab">
        <div class="booking_tables">
        <div class="booking-header">
          <div>
            <h2>Home Cleaning</h2>
            <p>Bungalow - Basic Cleaning</p>
          </div>
          <div class="booking-status">
          <span>Booking ID</span>
          <span class="status">CANCELLED</span>
          </div>
        </div>
        </div>
        <!-- Details -->
        <div class="booking-details">
          <div class="detail">
          <strong>Date</strong>
          <p>May 21, 2025</p>
          </div>
          <div class="detail">
          <strong>Time</strong>
          <p>11:00 AM - 2:00 PM</p>
          </div>
          <div class="detail address">
          <strong>Address</strong>
          <p>B1 L50 Mango st. Phase 1 Saint Joseph Village 10<br>
          Barangay Langgam, City of San Pedro, Laguna 4023</p>
          </div>
        </div>
        <div class="booking-details">
            <div class="detail full-width">
              <span>Total:</span>
              <span>₱2,500</span>
            </div>
        </div>

        <!-- booking-footer -->
        <div class="booking-footer">
          <div class="service-provider">
            <div class="service-provider-top">
              <i class="fa fa-user account-icon"></i>
              <span class="name">Ana Santos</span>
              <i class="fa fa-comment message-icon"></i>
            </div>
            <div class="rating">
              ⭐ (4.9)
            </div>
          </div>
          <div class="actions">
            <div class="dropdown">
              <button class="btn btn-outline-dark dropdown-toggle" type="more" data-bs-toggle="dropdown">View Cancellation Details</button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">View Full Cancellation Details</a></li>
                <li><a class="dropdown-item" href="#">Book Again</a></li>
                <li><a class="dropdown-item" href="#">Contact Support</a></li>
              </ul>
            </div>
          </div>
        </div>
          <p class="cancellation_details">View Cancellation Policy</p>
      </div>
    </div>

  
  
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