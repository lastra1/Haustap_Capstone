<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Bookings - Return</title>
  <link rel="stylesheet" href="css/manage_booking_return.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="js/lazy-images.js" defer></script></head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'bookings'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Manage of Bookings</h3>
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button id="userDropdownBtn" class="user-dropdown-btn">Mj Punzalan ▼</button>
            <div class="user-dropdown" id="userDropdown">
              <a href="admin_profile.php">View Profile</a>
              <a href="/admin_haustap/admin_haustap/change_password.php">Change Password</a>
              <a href="/admin_haustap/admin_haustap/activity_logs.php">Activity Logs</a>
              <a href="logout.php" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <section class="content">
        <!-- Tabs -->
        <div class="tabs">
          <button>All</button>
          <button>Pending</button>
          <button>Ongoing</button>
          <button>Completed</button>
          <button>Cancelled</button>
          <button class="active">Return</button>
        </div>

        <!-- Search and Filter -->
<div class="search-filter">
  <input type="text" placeholder="Search">

  <div class="filter-dropdown">
<button class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</button>
    <div class="dropdown-content">
            <p class="filter-title">Filter by Status</p>
            <div class="checkbox-group">
              <label><input type="checkbox" value="pending" checked> Approved</label>
              <label><input type="checkbox" value="ongoing" checked> Pending</label>
              <label><input type="checkbox" value="complete" checked> Declined</label>
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
                <th>Client</th>
                <th>Provider</th>
                <th>Service</th>
                <th>Date & Time</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Juan Dela Cruz</td>
                <td>Ramon Ang</td>
                <td>Home Cleaning</td>
                <td>2025-06-07 14:30</td>
                <td><span class="status approved">Approved</span></td>
                <td>&gt;</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Ramon Ang</td>
                <td>Juan Dela Cruz</td>
                <td>Home Cleaning</td>
                <td>2025-06-07 14:30</td>
                <td><span class="status pending">Pending</span></td>
                <td>&gt;</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Cj Pogi</td>
                <td>Juan Dela Cruz</td>
                <td>Home Cleaning</td>
                <td>2025-06-07 14:30</td>
                <td><span class="status declined">Declined</span></td>
                <td>&gt;</td>
              </tr>
            </tbody>
          </table>

          <div class="pagination">
            <span>[◄ Prev]</span>
            <span>Showing 2–10 of 120 Clients</span>
            <span>[Next ►]</span>
          </div>
        </div>
      </section>
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
    
    // Date filter: show rows within selected date range (use dataset flags so it composes with other filters)
    (function(){
      const fromInput = document.getElementById('from-date');
      const toInput = document.getElementById('to-date');
      const applyBtn = document.querySelector('.apply-btn');

      function parseRowDate(text){
        if (!text) return null;
        const m = text.match(/(\d{4})\s*-\s*(\d{2})\s*-\s*(\d{2})/);
        if (!m) return null;
        const iso = `${m[1]}-${m[2]}-${m[3]}`;
        const d = new Date(iso);
        return isNaN(d.getTime()) ? null : d;
      }

      function updateRowVisibility(){
        const rows = document.querySelectorAll('.table-container tbody tr');
        rows.forEach(row => {
          const fHidden = row.dataset.filterHidden === 'true';
          const sHidden = row.dataset.searchHidden === 'true';
          row.style.display = (fHidden || sHidden) ? 'none' : '';
        });
      }

      function applyDateFilter(){
        const fromVal = fromInput ? fromInput.value : '';
        const toVal = toInput ? toInput.value : '';
        const fromDate = fromVal ? new Date(fromVal) : null;
        const toDateRaw = toVal ? new Date(toVal) : null;
        const toDate = toDateRaw ? new Date(toDateRaw.setHours(23,59,59,999)) : null;

        const rows = document.querySelectorAll('.table-container tbody tr');
        rows.forEach(row => {
          const dateCell = row.querySelector('td:nth-child(5)');
          const rowDate = parseRowDate(dateCell ? dateCell.textContent.trim() : '');
          if (!rowDate) { row.dataset.filterHidden = ''; return; }
          const within = (!fromDate || rowDate >= fromDate) && (!toDate || rowDate <= toDate);
          row.dataset.filterHidden = within ? '' : 'true';
        });
        updateRowVisibility();
      }

      if (applyBtn) applyBtn.addEventListener('click', (e) => { e.preventDefault(); applyDateFilter(); if (dropdownContent) dropdownContent.classList.remove('show'); });
      updateRowVisibility();
    })();
  </script>
</body>
</html>


