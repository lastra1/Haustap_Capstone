<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>System Settings</title>
  <link rel="stylesheet" href="css/admin_settings.css" />
</head>
<body>
    <!-- Sidebar -->
    <div class="container">
    <div class="sidebar">
    <div class="logo">
      <img src="images/logo.png" alt="Haustap Logo" />
    </div>
    <ul class="menu">
      <li>DashBoard Overview</li>
      <li>Manage Users</li>
      <li>Manage Providers</li>
      <li>View All Bookings</li>
      <li>Job Status Monitor</li>
      <li >Analytics & Report</li>
      <li class="active">System Settings</li>
    </ul>
  </div>

    <!-- Main Content -->
    <main class="main-content">
      <header class="topbar">
        <h2>System Settings</h2>
        <div class="header-buttons">
          <button class="btn admin">Admin</button>
          <button class="btn logout">Logout</button>
        </div>
      </header>

      <section class="settings-section">
        <div class="settings-card">
          <div class="category">
            <h3>🔒 Security Settings</h3>
            <div class="buttons">
              <button>Password Policy</button>
              <button>Two-Factor Authentication</button>
              <button>IP Restrictions</button>
            </div>
          </div>

          <div class="category">
            <h3>💳 Payment Settings</h3>
            <div class="buttons">
              <button>GCash API Key</button>
              <button>Reference Number Configuration</button>
            </div>
          </div>

          <div class="category">
            <h3>🔔 Notification</h3>
            <div class="buttons">
              <button>Default Alert</button>
              <button>User/Provider Notification</button>
            </div>
          </div>

          <div class="category">
            <h3>👤 Admin Management</h3>
            <div class="buttons">
              <button>Admin Account</button>
              <button>Permission Levels</button>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
