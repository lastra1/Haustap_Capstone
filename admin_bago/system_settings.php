<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Settings | Admin Dashboard</title>
  <link rel="stylesheet" href="css/system_settings.css">
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
          <li>Feedback & Reviews</li>
          <li class="active">System Settings</li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="topbar">
        <h3>System Settings</h3>
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

      <!-- Settings Sections -->
      <div class="settings-container">

        <!-- General Settings -->
        <section class="settings-card">
          <h4>General Settings</h4>
          <div class="form-group">
            <label>System Name:</label>
            <input type="text" value="Ana Santos">
          </div>

          <div class="form-group">
            <label>System Logo:</label>
            <button class="upload-btn"><i class="fa fa-upload"></i></button>
          </div>

          <div class="form-group">
            <label>Contact Email:</label>
            <input type="email" value="haustap@gmail.com">
          </div>

          <div class="form-group">
            <label>Default Language:</label>
            <div class="radio-group">
              <label><input type="radio" name="language" checked> English</label>
              <label><input type="radio" name="language"> Tagalog</label>
            </div>
          </div>

          <button class="save-btn">Save</button>
        </section>

        <!-- Subscription Settings -->
        <section class="settings-card">
          <h4>Subscription Settings</h4>
          <div class="form-group">
            <label>Plan Type:</label>
            <input type="text" value="Haustap Standard Access">
          </div>

          <div class="toggle-group">
            <label>Renewal Cycle</label>
            <label class="switch">
              <input type="checkbox">
              <span class="slider"></span>
            </label>
          </div>

          <div class="toggle-group">
            <label>Voucher Deduction</label>
            <label class="switch">
              <input type="checkbox">
              <span class="slider"></span>
            </label>
          </div>

          <button class="save-btn">Save</button>
        </section>

        <!-- Notification Settings -->
        <section class="settings-card">
          <h4>Notification Settings</h4>
          <div class="toggle-group">
            <label>Send Email Notifications</label>
            <label class="switch">
              <input type="checkbox">
              <span class="slider"></span>
            </label>
          </div>

          <div class="toggle-group">
            <label>In-App Alerts</label>
            <label class="switch">
              <input type="checkbox" checked>
              <span class="slider"></span>
            </label>
          </div>

          <button class="save-btn">Save</button>
        </section>

        <!-- System Info -->
        <section class="settings-card system-info">
          <h4>System Info</h4>
          <div class="info-row">
            <p><strong>Version:</strong> Version 1.0</p>
          </div>
          <div class="info-row">
            <p><strong>Last Update:</strong> October 2025</p>
          </div>
        </section>

      </div>
    </main>
  </div>

  <!-- Confirm Admin Access Popup -->
  <div id="adminPopup" class="popup-overlay">
    <div class="popup-box">
      <h3>Confirm Admin Access</h3>
      <p>For security purposes, please re-enter your admin password to access System Settings</p>

      <div class="form-group">
        <label>Password:</label>
        <input type="password" id="adminPassword" placeholder="Enter admin password">
      </div>

      <div class="popup-buttons">
        <button id="cancelPopup" class="cancel-btn">Cancel</button>
        <button id="verifyPopup" class="verify-btn">Verify Access</button>
      </div>
    </div>
  </div>

  <script>
    // User dropdown menu
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });

    // Admin password popup logic
    const popup = document.getElementById("adminPopup");
    const cancelPopup = document.getElementById("cancelPopup");
    const verifyPopup = document.getElementById("verifyPopup");
    const saveButtons = document.querySelectorAll(".save-btn");

    // Show popup when Save is clicked
    saveButtons.forEach(btn => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        popup.style.display = "flex";
      });
    });

    // Close popup
    cancelPopup.addEventListener("click", () => {
      popup.style.display = "none";
    });

    // Verify password (dummy logic)
    verifyPopup.addEventListener("click", () => {
      const password = document.getElementById("adminPassword").value;
      if (password === "admin123") {
        alert("Access Verified!");
        popup.style.display = "none";
      } else {
        alert("Incorrect password!");
      }
    });
  </script>
</body>
</html>
