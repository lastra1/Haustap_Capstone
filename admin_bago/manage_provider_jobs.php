<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Manage Clients</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/manage_client_booking.css">
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="images/logo.png" alt="logo" />
        <span>Admin Dashboard</span>
      </div>
      <nav>
        <ul>
          <li>Dashboard Overview</li>
          <li>Manage Applicants</li>
          <li>Manage Clients</li>
          <li class="active">Manage Providers</li>
          <li>Manage Bookings</li>
          <li>Job Status Monitor</li>
          <li>Analytics & Report</li>
          <li>Subscription Management</li>
          <li>Feedback & Reviews</li>
          <li>System Settings</li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Manage of Clients</h3>
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
        <button>Profile</button>
        <button class="active">Jobs</button>
        <button>Activity</button>
        <button>Voucher</button>
        <button>Subscription</button>
      </div>

      <!-- Search and Filter -->
      <div class="search-filter">
        <input type="text" placeholder="Search Services">

        <div class="filter-dropdown">
          <div class="filter-btn"><i class="fa fa-sliders"></i> Filter</div>
          <div class="dropdown-content">
            <p class="filter-title">Filter by Status</p>
            <label><input type="checkbox"> Pending</label>
            <label><input type="checkbox"> Ongoing</label>
            <label><input type="checkbox"> Completed</label>
            <label><input type="checkbox"> Cancelled</label>
            <label><input type="checkbox"> Return</label>
            <button class="apply-btn">Apply</button>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Booking Id</th>
              <th>Client name</th>
              <th>Services</th>
              <th>Date &amp; Time</th>
              <th>Total</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td><td>Ana Santos</td><td>Home Cleaning</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status completed">Completed</span></td><td>›</td>
            </tr>
            <tr>
              <td>2</td><td>Ana Santos</td><td>Plumbing</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status cancelled">Cancelled</span></td><td>›</td>
            </tr>
            <tr>
              <td>3</td><td>Ana Santos</td><td>Plumbing</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status pending">Pending</span></td><td>›</td>
            </tr>
            <tr>
              <td>4</td><td>Ana Santos</td><td>Plumbing</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status ongoing">Ongoing</span></td><td>›</td>
            </tr>
            <tr>
              <td>5</td><td>Ana Santos</td><td>Plumbing</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status return">Return</span></td><td>›</td>
            </tr>
          </tbody>
        </table>

        <div class="pagination">
          <button class="prev">◀ Prev</button>
          <p>Showing 1–10 of 120</p>
          <button class="next">Next ▶</button>
        </div>
      </div>
    </main>
  </div>

    <script>
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });
  </script>

</body>
</html>
