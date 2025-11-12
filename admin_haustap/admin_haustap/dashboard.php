<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css" />
<script src="js/lazy-images.js" defer></script>
<script src="js/app.js" defer></script>
  <style>
    /* clickable applicant rows */
    .clickable-row { cursor: pointer; }
    .clickable-row:hover { background: #f6fbfb; }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'dashboard'; include 'includes/sidebar.php'; ?>

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
              <a href="admin_profile.php">View Profile</a>
              <a href="change_password.php">Change Password</a>
              <a href="activity_logs.php">Activity Logs</a>
              <a href="logout.php" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>


      <!-- Summary Cards -->
      <section class="cards">
        <div class="card">
          <h3 id="totalBookings">—</h3>
          <p>Total Bookings</p>
        </div>
        <div class="card">
          <h3 id="pendingJobs">—</h3>
          <p>Pending Jobs</p>
        </div>
        <div class="card">
          <h3 id="verifiedProviders">—</h3>
          <p>Verified Service Providers</p>
        </div>
        <div class="card">
          <h3 id="totalClients">—</h3>
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
          <tr class="clickable-row" data-id="1">
            <td>Juan Dela Cruz</td>
            <td>January 7, 2025</td>
            <td></td>
          </tr>
          <tr class="clickable-row" data-id="2">
            <td>Ramon Ang</td>
            <td>January 24, 2025</td>
            <td></td>
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
    document.addEventListener('DOMContentLoaded', function(){
      // Make applicant rows navigate to manage_applicant.php?id={id} when clicked
      (function(){
        const table = document.querySelector('.applicants table');
        if (!table) return;
        table.addEventListener('click', function(e){
          const tr = e.target.closest('tr.clickable-row');
          if (!tr) return;
          const id = tr.dataset.id;
          if (!id) return;
          // Respect modifier keys to allow opening in new tab
          const url = 'manage_applicant.php?id=' + encodeURIComponent(id);
          if (e.ctrlKey || e.metaKey || e.button === 1) {
            window.open(url, '_blank');
            return;
          }
          window.location.href = url;
        });
      })();

      // Dropdown toggle (user menu)
      (function(){
        const dropdownBtn = document.getElementById('userDropdownBtn');
        const dropdown = document.getElementById('userDropdown');
        if (!dropdownBtn || !dropdown) return;
        dropdownBtn.addEventListener('click', function(e){
          e.stopPropagation();
          dropdown.classList.toggle('show');
        });
        // Close when clicking outside
        document.addEventListener('click', function(e){
          if (!dropdown.contains(e.target) && !dropdownBtn.contains(e.target)) dropdown.classList.remove('show');
        });
      })();
    });
  </script>

  
</body>
</html>


