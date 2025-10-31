<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback & Reviews | Admin Dashboard</title>
  <link rel="stylesheet" href="css/feedback_reviews.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="images/logo.png" alt="logo">
        <span>Admin Dashboard</span>
      </div>
      <nav>
        <ul>
          <li>Dashboard Overview</li>
          <li>Manage Applicants</li>
          <li>Manage Clients</li>
          <li>Manage Providers</li>
          <li>Manage Bookings</li>
          <li>Job Status Monitor</li>
          <li>Analytics & Report</li>
          <li>Subscription Management</li>
          <li class="active">Feedback & Reviews</li>
          <li>System Settings</li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="topbar">
        <h3>Feedback & Reviews</h3>
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button id="userDropdownBtn" class="user-dropdown-btn">Mj Punzalan ▼</button>
            <div class="user-dropdown" id="userDropdown">
              <a href="#">View Profile</a>
              <a href="#">Change Password</a>
              <a href="#">Activity Logs</a>
              <a href="#" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <!-- Tabs -->
      <div class="tabs">
        <button class="tab active">Service Provider</button>
        <button class="tab">Client</button>
      </div>

      <!-- Search and Filter -->
<div class="search-filter">
  <input type="text" placeholder="Search">

  <div class="filter-dropdown">
    <button class="filter-btn"><i class="fa fa-sliders"></i> Filter ▼</button>
    <div class="dropdown-content">
      
      <!-- Filter by Date -->
      <div class="filter-date">
        <p class="filter-title">Filter by Date</p>
        <div class="date-row">
          <label for="from-date">From:</label>
          <input type="date" id="from-date" value="2025-10-01">
        </div>
        <div class="date-row">
          <label for="to-date">Return:</label>
          <input type="date" id="to-date" value="2025-10-31">
        </div>
      </div>

      <button class="apply-btn">Apply</button>
    </div>
  </div>
</div>

      <!-- Reviews Table -->
      <div class="table-container">
        <table class="reviews-table">
          <thead>
            <tr>
              <th>Id</th>
              <th>Provider</th>
              <th>Service</th>
              <th>Rating</th>
              <th>Date</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Juan Dela Cruz</td>
              <td>Plumbing</td>
              <td class="stars">★★★★★</td>
              <td>2025-06-07</td>
              <td><span class="status reviewed">Reviewed</span></td>
              <td>></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Ramon Ang</td>
              <td>Cleaning</td>
              <td class="stars">★★★★★</td>
              <td>2025-06-07</td>
              <td><span class="status pending">Pending</span></td>
              <td>></td>
            </tr>
            <tr class="mark-row">
              <td>3</td>
              <td>Juana Ramos</td>
              <td>Gardening</td>
              <td class="stars">★★★★★</td>
              <td>2025-06-07</td>
              <td><span class="status mark">Mark as reviewed</span></td>
              <td><span class="open-popup">></span></td>
            </tr>
          </tbody>
        </table>

        <div class="pagination">
            <span>[ ◀ Prev ]</span>
            <p>Showing 10–10 of 120 Clients</p>
            <span>[ Next ▶ ]</span>
          </div>

      <!-- Summary Cards -->
      <div class="summary-section">
        <div class="summary-card">
          <h4>Average Rating</h4>
          <p class="highlight">4.8 / 5</p>
        </div>
        <div class="summary-card">
          <h4>Total Reviews</h4>
          <p class="highlight">92</p>
        </div>
        <div class="summary-card">
          <h4>Recent Feedback</h4>
          <p class="highlight">Oct 27, 2025</p>
        </div>
      </div>
    </main>
  </div>

  <!-- Feedback Popup -->
  <div id="feedbackModal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h3>Feedback Details</h3>
      <p><strong>Client:</strong> Jenn Bornilla</p>
      <p><strong>Service:</strong> Plumbing</p>
      <p><strong>Rating:</strong> <span class="stars">★★★★★</span></p>
      <p><strong>Feedback reason:</strong> Service Not Rendered</p>
      <p><strong>Feedback Description:</strong> ano ba yan!</p>
      <p><strong>Date:</strong> 10-31-2025</p>
      <div class="modal-actions">
        <button class="btn green">Mark as reviewed</button>
        <button class="btn red">Send Warning</button>
      </div>
    </div>
  </div>

 <script>
    // User Dropdown
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    // Close user dropdown when clicking outside
    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });

    // Filter Dropdown
    const filterBtn = document.querySelector('.filter-btn');
    const dropdownContent = document.querySelector('.dropdown-content');

    filterBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      dropdownContent.classList.toggle('show');
      filterBtn.innerHTML = dropdownContent.classList.contains('show')
        ? '<i class="fa fa-sliders"></i> Filter ▲'
        : '<i class="fa fa-sliders"></i> Filter ▼';
    });

    window.addEventListener('click', () => {
      dropdownContent.classList.remove('show');
      filterBtn.innerHTML = '<i class="fa fa-sliders"></i> Filter ▼';
    });
  </script>

</body>
</html>
