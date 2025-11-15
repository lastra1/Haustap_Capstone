<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notifications</title>
  <link rel="stylesheet" href="css/dashboard.css" />
  <script src="js/lazy-images.js" defer></script>
  <script src="js/app.js" defer></script>
</head>
<body>
  <div class="dashboard-container">
    <?php $active = 'notifications'; include 'includes/sidebar.php'; ?>

    <main class="main-content">
      <header class="topbar">
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button class="user-btn" id="userDropdownBtn">Admin ▼</button>
            <div class="dropdown" id="userDropdown">
              <a href="admin_profile.php">View Profile</a>
              <a href="change_password.php">Change Password</a>
              <a href="activity_logs.php">Activity Logs</a>
              <a href="#" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <section class="cards">
        <div class="card">
          <h3>Notifications</h3>
          <p>Recent updates and alerts across bookings, providers, and system.</p>
        </div>
      </section>

      <section class="notifications" style="margin-top: 20px;">
        <h2>All Notifications</h2>
        <div style="background:#fff; border:1px solid #e5e7eb; border-radius:10px; overflow:hidden;">
          <div style="padding:10px 12px; background:#f7f9fa; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
            <strong>Recent</strong>
            <a href="system_settings.php" style="color:#3dbfc3; text-decoration:none; font-weight:500;">Notification Settings</a>
          </div>
          <ul style="list-style:none; margin:0; padding:0;">
            <li style="padding:10px 12px; border-bottom:1px solid #f0f2f4;">
              <p style="margin:0 0 4px;">New booking placed by a client</p>
              <small style="color:#64748b;">2m ago</small>
            </li>
            <li style="padding:10px 12px; border-bottom:1px solid #f0f2f4;">
              <p style="margin:0 0 4px;">Provider updated availability schedule</p>
              <small style="color:#64748b;">1h ago</small>
            </li>
            <li style="padding:10px 12px; border-bottom:1px solid #f0f2f4;">
              <p style="margin:0 0 4px;">Voucher redeemed in checkout</p>
              <small style="color:#64748b;">3h ago</small>
            </li>
            <li style="padding:10px 12px; border-bottom:1px solid #f0f2f4;">
              <p style="margin:0 0 4px;">Client cancelled a booking</p>
              <small style="color:#64748b;">5h ago</small>
            </li>
            <li style="padding:10px 12px; border-bottom:1px solid #f0f2f4;">
              <p style="margin:0 0 4px;">New feedback received</p>
              <small style="color:#64748b;">1d ago</small>
            </li>
            <li style="padding:10px 12px; border-bottom:1px solid #f0f2f4;">
              <p style="margin:0 0 4px;">System settings updated</p>
              <small style="color:#64748b;">1d ago</small>
            </li>
          </ul>
          <div style="padding:8px 12px; border-top:1px solid #e5e7eb; text-align:right;">
            <a href="activity_logs.php" style="color:#3dbfc3; text-decoration:none; font-weight:500;">View activity logs</a>
          </div>
        </div>
      </section>

      <script>
        // Dropdown toggle for user menu
        const dropdownBtn = document.getElementById("userDropdownBtn");
        const dropdown = document.getElementById("userDropdown");
        dropdownBtn.addEventListener("click", () => { dropdown.classList.toggle("show"); });
        window.addEventListener("click", (e) => {
          if (!dropdownBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove("show");
          }
        });
      </script>
    </main>
  </div>
</body>
</html>
