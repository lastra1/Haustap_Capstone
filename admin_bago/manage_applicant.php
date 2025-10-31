<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin | Manage Applicants</title>
  <link rel="stylesheet" href="css/manage_applicant.css" />
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
          <li class="active">Manage Applicants</li>
          <li>Manage Clients</li>
          <li>Manage Providers</li>
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

      <!-- Header -->
      <div class="page-header">
        <h3>Manage of Applicants</h3>
      </div>

      <!-- Applicant Tabs -->
      <div class="tabs">
        <button class="tab active">All</button>
        <button class="tab">Pending Review</button>
        <button class="tab">Scheduled</button>
        <button class="tab">Hired</button>
        <button class="tab">Rejected</button>
      </div>

      <!-- Table Section -->
      <div class="table-container">
        <div class="table-header">
          <input type="text" placeholder="Search Applicant" class="search-bar" />
          <span class="filter-icon">⚙️ Filter</span>
        </div>

        <table>
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Date Applied</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Juan Ewan Dela Cruz</td>
              <td>January 7, 2025</td>
              <td><span class="status hired">Hired</span></td>
              <td class="arrow">›</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Ramon Ang</td>
              <td>January 24, 2025</td>
              <td><span class="status pending">Pending Review</span></td>
              <td class="arrow">›</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Juan Ewan Dela Cruz</td>
              <td>January 7, 2025</td>
              <td><span class="status scheduled">Scheduled</span></td>
              <td class="arrow">›</td>
            </tr>
            <tr>
              <td>4</td>
              <td>Ramon Ang</td>
              <td>January 7, 2025</td>
              <td><span class="status rejected">Rejected</span></td>
              <td class="arrow">›</td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
          <span>◀ Prev</span>
          <span>Showing 4–10 of 120</span>
          <span>Next ▶</span>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Dropdown logic
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });

    // Tabs
    const tabs = document.querySelectorAll(".tab");
    tabs.forEach(tab => {
      tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");
      });
    });
  </script>
</body>
</html>
