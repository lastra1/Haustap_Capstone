<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css" />
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
          <li class="active">Dashboard Overview</li>
          <li>Manage Applicants</li>
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
      <header class="topbar">
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button class="user-btn" id="userDropdownBtn">
              Mj Punzalan ▼
            </button>
            <div class="dropdown" id="userDropdown">
              <a href="#">View Profile</a>
              <a href="#">Change Password</a>
              <a href="#">Activity Logs</a>
              <a href="#" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <!-- Summary Cards -->
      <section class="cards">
        <div class="card">
          <h3>420</h3>
          <p>Total Bookings</p>
        </div>
        <div class="card">
          <h3>800</h3>
          <p>Pending Jobs</p>
        </div>
        <div class="card">
          <h3>1,000</h3>
          <p>Verified Service Providers</p>
        </div>
        <div class="card">
          <h3>1250</h3>
          <p>Total Clients</p>
        </div>
      </section>

      <!-- Applicants List -->
      <section class="applicants">
        <h2>List of Applicants</h2>
        <table>
          <tr>
            <th>Name</th>
            <th>Date Applied</th>
            <th></th>
          </tr>
          <tr>
            <td>Juan Dela Cruz</td>
            <td>January 7, 2025</td>
            <td><a href="#">View Documents</a></td>
          </tr>
          <tr>
            <td>Ramon Ang</td>
            <td>January 24, 2025</td>
            <td><a href="#">View Documents</a></td>
          </tr>
        </table>
      </section>

      <!-- System Alert -->
      <section class="system-alert">
        <h2>System Alert</h2>
        <div class="alert">
          ⚠️ 3 new booking request pending
        </div>
        <div class="alert">
          ⚠️ Provider approval required for 2 new applicants
        </div>
      </section>
    </main>
  </div>

  <script>
    // Dropdown toggle
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", () => {
      dropdown.classList.toggle("show");
    });

    // Close dropdown when clicking outside
    window.addEventListener("click", (e) => {
      if (!dropdownBtn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.remove("show");
      }
    });
  </script>
</body>
</html>
