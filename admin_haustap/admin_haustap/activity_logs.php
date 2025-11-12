<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin | Activity Logs</title>
  <link rel="stylesheet" href="css/activity_logs.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="js/lazy-images.js" defer></script>
  <script src="js/activity_logs.js" defer></script>
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'dashboard'; include 'includes/sidebar.php'; ?>

    <!-- Main content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
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

      <!-- Page title -->
      <div class="page-header">
        <h3>Admin &gt; Activity Logs</h3>
      </div>

      <!-- Table Container -->
      <div class="table-container">
        <div class="table-header">
          <input type="text" placeholder="Search (date, admin, action...)" class="search-bar" aria-label="Search logs" />
          <div class="filter-icons">
            <i class="fa-solid fa-magnifying-glass search-icon" aria-hidden="true"></i>
            <button class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</button>

            <!-- Filter Dropdown -->
            <div class="filter-dropdown" id="filterDropdown">
              <h4>Filter by Date</h4>
              <label>From:</label>
              <input type="date" id="fromDate" value="2025-10-01" />
              <label>Return:</label>
              <input type="date" id="toDate" value="2025-10-31" />
              <button class="apply-btn">Apply</button>
            </div>
          </div>
        </div>

        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Date & Time</th>
              <th>Admin</th>
              <th>Action</th>
              <th>Target / Details</th>
              <th>Result</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>001</td>
              <td>2025-10-24 10:42</td>
              <td>Jenn Bonilla</td>
              <td>Edited Provider</td>
              <td>Provider ID #024</td>
              <td>Success</td>
            </tr>
            <tr>
              <td>002</td>
              <td>2025-10-24 10:42</td>
              <td>Jenn Bonilla</td>
              <td>Edited Provider</td>
              <td>Provider ID #024</td>
              <td>Success</td>
            </tr>
            <tr>
              <td>003</td>
              <td>2025-10-24 10:42</td>
              <td>Jenn Bonilla</td>
              <td>Edited Provider</td>
              <td>Provider ID #024</td>
              <td>Success</td>
            </tr>
            <tr>
              <td>004</td>
              <td>2025-10-24 10:42</td>
              <td>Jenn Bonilla</td>
              <td>Edited Provider</td>
              <td>Provider ID #024</td>
              <td>Success</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <script>
    // User Dropdown
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });

    // Filter Dropdown
    const filterToggle = document.getElementById("filterToggle");
    const filterDropdown = document.getElementById("filterDropdown");

    filterToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      filterDropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!filterDropdown.contains(e.target) && e.target !== filterToggle) {
        filterDropdown.classList.remove("show");
      }
    });
  </script>
</body>
</html>


