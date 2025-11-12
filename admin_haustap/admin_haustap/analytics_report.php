<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - Analytics & Report</title>
  <link rel="stylesheet" href="css/analytics_report.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/lazy-images.js" defer></script>
  <style>
    /* Top-Rated Providers small-card styles */
    .top-providers { margin-top:12px; }
    .top-providers h4 { margin:0 0 8px; font-size:14px; color:#0b7a72; }
    .top-providers ul { list-style:none; padding:0; margin:6px 0 0; }
    .top-providers li { display:flex; align-items:center; justify-content:space-between; padding:8px 6px; border-radius:8px; transition:background .12s; }
    .top-providers li + li { margin-top:8px; }
    .top-providers li:hover { background:#f6fbfb; }
    .top-providers .left { display:flex; align-items:center; gap:10px; }
    .top-providers .badge { width:36px; height:36px; border-radius:50%; background:#e0f7f9; color:#007b8f; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; }
    .top-providers .name { font-weight:600; color:#223; font-size:13px; }
    .top-providers .jobs { font-size:12px; color:#7a8a8c; }
    .top-providers .rating { font-weight:700; color:#0b7a72; font-size:13px; min-width:44px; text-align:right; }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'analytics'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Job Status Monitor</h3>
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button id="userDropdownBtn" class="user-dropdown-btn">Mj Punzalan ▼</button>
            <div class="user-dropdown" id="userDropdown">
              <a href="admin_profile.php">View Profile</a>
              <a href="/admin_haustap/admin_haustap/change_password.php">Change Password</a>
              <a href="activity_logs.php">Activity Logs</a>
              <a href="logout.php" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

     <!-- Summary Cards -->
  <section class="summary-section">
    <div class="summary-card">
      <div class="card-header">
        <button class="time-btn active">DAY</button>
        <button class="time-btn">WEEK</button>
        <button class="time-btn">MONTH</button>
      </div>
      <div class="card-body">
        <h2>890</h2>
        <p>Total Applicants</p>
      </div>
    </div>

    <div class="summary-card">
      <div class="card-header">
        <button class="time-btn active">DAY</button>
        <button class="time-btn">WEEK</button>
        <button class="time-btn">MONTH</button>
      </div>
      <div class="card-body">
        <h2>890</h2>
        <p>Total Providers</p>
      </div>
    </div>

    <div class="summary-card">
      <div class="card-header">
        <button class="time-btn active">DAY</button>
        <button class="time-btn">WEEK</button>
        <button class="time-btn">MONTH</button>
      </div>
      <div class="card-body">
        <h2>890</h2>
        <p>Total Clients</p>
      </div>
    </div>

    <div class="summary-card">
      <div class="card-header">
        <button class="time-btn active">DAY</button>
        <button class="time-btn">WEEK</button>
        <button class="time-btn">MONTH</button>
      </div>
      <div class="card-body">
        <h2>890</h2>
        <p>Total Bookings</p>
      </div>
    </div>
  </section>

  <!-- Charts Row -->
 <section class="chart-row">
  <div class="chart-card">
    <h3>User Activity Trend</h3>
    <canvas id="userActivityChart"></canvas>

    <!-- NEW BOOKING CHART -->
    <div class="booking-chart">
      <h3>Booking & Job Statistics</h3>
      <canvas id="bookingChart"></canvas>
    </div>
  </div>

  <div class="chart-card">
    <h3>Provider Performance</h3>
    <canvas id="providerPerformanceChart"></canvas>
    <div class="top-providers">
      <h4>Top-Rated Providers</h4>
      <ul>
        <li><span class="badge">AS</span> Ana Santes — <strong>4.9</strong></li>
        <li><span class="badge">MD</span> Mark Dela Cruz — <strong>4.8</strong></li>
        <li><span class="badge">LR</span> Leo Ramirez — <strong>4.8</strong></li>
        <li><span class="badge">CN</span> Cindy Navarro — <strong>4.7</strong></li>
      </ul>
    </div>
  </div>
</section>


 <!-- SERVICE DEMAND SECTION -->
<section class="service-demand">
  <h3>Service Demand</h3>
  <p class="section-subtitle">Top Booked Services</p>

  <div class="service-grid">
    <!-- Cleaning Services -->
    <div class="service-card">
      <h4>Cleaning Services</h4>
      <ul>
        <li><span>Home Cleaning</span><div class="bar"><div style="width:80%"></div></div></li>
        <li><span>AC Cleaning</span><div class="bar"><div style="width:60%"></div></div></li>
        <li><span>AC Deep Cleaning (Chemical Cleaning)</span><div class="bar"><div style="width:90%"></div></div></li>
      </ul>
    </div>

    <!-- Indoor Services -->
    <div class="service-card">
      <h4>Indoor Services</h4>
      <ul>
        <li><span>Handyman</span><div class="bar"><div style="width:75%"></div></div></li>
        <li><span>Plumbing</span><div class="bar"><div style="width:65%"></div></div></li>
        <li><span>Electrical</span><div class="bar"><div style="width:55%"></div></div></li>
        <li><span>Appliance Repair</span><div class="bar"><div style="width:70%"></div></div></li>
        <li><span>Pest Control</span><div class="bar"><div style="width:50%"></div></div></li>
      </ul>
    </div>

    <!-- Beauty Services -->
    <div class="service-card">
      <h4>Beauty Services</h4>
      <ul>
        <li><span>Hair Services</span><div class="bar"><div style="width:80%"></div></div></li>
        <li><span>Nail Care</span><div class="bar"><div style="width:60%"></div></div></li>
        <li><span>Make-up</span><div class="bar"><div style="width:70%"></div></div></li>
        <li><span>Lashes</span><div class="bar"><div style="width:85%"></div></div></li>
        <li><span>Packages</span><div class="bar"><div style="width:75%"></div></div></li>
      </ul>
    </div>

    <!-- Outdoor Services -->
    <div class="service-card">
      <h4>Outdoor Services</h4>
      <ul>
        <li><span>Gardening & Landscaping</span><div class="bar"><div style="width:80%"></div></div></li>
        <li><span>Pest Control</span><div class="bar"><div style="width:60%"></div></div></li>
      </ul>
    </div>

    <!-- Tech & Gadget Services -->
    <div class="service-card">
      <h4>Tech & Gadget Services</h4>
      <ul>
        <li><span>Mobile Phone</span><div class="bar"><div style="width:70%"></div></div></li>
        <li><span>Laptop & Desktop</span><div class="bar"><div style="width:60%"></div></div></li>
        <li><span>PC</span><div class="bar"><div style="width:50%"></div></div></li>
        <li><span>Tablet & iPad</span><div class="bar"><div style="width:65%"></div></div></li>
        <li><span>Game & Console</span><div class="bar"><div style="width:80%"></div></div></li>
      </ul>
    </div>

    <!-- Wellness Services -->
    <div class="service-card">
      <h4>Wellness Services</h4>
      <ul>
        <li><span>Massage</span><div class="bar"><div style="width:85%"></div></div></li>
        <li><span>Packages</span><div class="bar"><div style="width:70%"></div></div></li>
      </ul>
    </div>
  </div>
</section>
</main>
  </div>

  <script>
    // Dropdown
    (function(){
      const dropdownBtn = document.getElementById("userDropdownBtn");
      const dropdown = document.getElementById("userDropdown");
      if (dropdownBtn && dropdown) {
        dropdownBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          dropdown.classList.toggle("show");
        });
        window.addEventListener("click", (e) => {
          if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
        });
      }
    })();

    // Charts setup
(function(){
  if (typeof Chart === 'undefined') return;

  const ctx1 = document.getElementById('userActivityChart');
  new Chart(ctx1, {
    type: 'line',
    data: {
      labels: ['Aug 1','Aug 3','Aug 5','Aug 9','Aug 11','Aug 13','Aug 15'],
      datasets: [
        { label: 'Clients', data: [100,200,350,300,320,400,520], borderColor: '#00bcd4', fill: false },
        { label: 'Service Providers', data: [50,100,150,180,200,220,260], borderColor: '#03a9f4', fill: false }
      ]
    },
    options: { responsive: true, plugins:{ legend:{ position:'bottom' } } }
  });

  const ctx2 = document.getElementById('providerPerformanceChart');
  new Chart(ctx2, {
    type: 'line',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug'],
      datasets: [{ label: 'Performance', data: [4.2,4.4,4.6,4.8,4.7,4.9,4.8,4.9], borderColor:'#2196f3', backgroundColor:'rgba(33,150,243,0.1)', fill:true }]
    },
    options: { responsive: true, plugins:{ legend:{ display:false } } }
  });

  // Booking & Job Statistics Chart
  const bookingCtx = document.getElementById('bookingChart');
  new Chart(bookingCtx, {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug'],
      datasets: [{
        label: 'Bookings',
        data: [300, 350, 400, 450, 500, 600, 650, 720],
        backgroundColor: 'rgba(0, 102, 255, 0.3)',
        borderColor: '#0066ff',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          max: 800
        }
      },
      plugins: {
        legend: { display: false }
      }
    }
  });
})();

  </script>
</body>
</html>
