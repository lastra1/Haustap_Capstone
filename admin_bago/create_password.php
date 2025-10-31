<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Change Password</title>
  <link rel="stylesheet" href="css/create_password.css">
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
      <!-- Top Bar -->
      <header class="topbar">
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button class="user-btn" id="userDropdownBtn">Mj Punzalan ▼</button>
            <div class="dropdown" id="userDropdown">
              <a href="#">View Profile</a>
              <a href="#">Change Password</a>
              <a href="#">Activity Logs</a>
              <a href="#" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Header -->
      <section class="page-header">
        <h3>Admin &gt; Change Password</h3>
      </section>

      <!-- Change Password Form -->
      <section class="password-section">
        <div class="password-card">
          <form>
            <div class="form-group">
              <label for="current-password">Current Password</label>
              <input type="password" id="current-password" placeholder="Enter Current Password">
            </div>

            <div class="form-group">
              <label for="new-password">New Password</label>
              <div class="input-wrapper">
                <input type="password" id="new-password" placeholder="Enter New Password">
                <span class="toggle-password" onclick="togglePassword('new-password')"></span>
              </div>
            </div>

            <div class="form-group">
              <label for="confirm-password">Confirm Password</label>
              <div class="input-wrapper">
                <input type="password" id="confirm-password" placeholder="Re-Enter New Password">
                <span class="toggle-password" onclick="togglePassword('confirm-password')"></span>
              </div>
            </div>

            <button type="submit" class="save-btn">Save</button>
          </form>
        </div>
      </section>
    </main>
  </div>

  <script>
    // Toggle password visibility
    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === "password" ? "text" : "password";
    }

    // Dropdown toggle
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");
    dropdownBtn.addEventListener("click", () => dropdown.classList.toggle("show"));
    window.addEventListener("click", (e) => {
      if (!dropdownBtn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.remove("show");
      }
    });
  </script>
</body>
</html>
