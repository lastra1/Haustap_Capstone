<?php require_once __DIR__ . '/includes/auth.php'; ?>
<?php
// Load client data by id
$client = null;
$clientId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$storePath = realpath(__DIR__ . '/../../storage/data/clients.json');
if ($storePath && is_file($storePath)) {
  $raw = @file_get_contents($storePath);
  $items = json_decode($raw ?: '[]', true);
  if (is_array($items)) {
    foreach ($items as $it) { if (isset($it['id']) && (int)$it['id'] === $clientId) { $client = $it; break; } }
  }
}
if (!$client) { $client = [ 'id' => $clientId ?: 0, 'name' => 'Unknown', 'status' => isset($_GET['status']) ? $_GET['status'] : 'active' ]; }
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Activity</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/manage_client_activity.css">
<script src="js/lazy-images.js" defer></script>
</head>
<body>
  <div class="dashboard-container">
  <!-- Sidebar -->
  <?php $active = 'clients_activity'; include 'includes/sidebar.php'; ?>

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
              <a href="admin_profile.php">View Profile</a>
              <a href="/admin_haustap/admin_haustap/change_password.php">Change Password</a>
              <a href="/admin_haustap/admin_haustap/activity_logs.php">Activity Logs</a>
              <a href="logout.php" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <!-- Tabs -->
      <div class="tabs">
        <?php $cid = (int)($client['id'] ?? 0); $cstatus = urlencode($client['status'] ?? ''); ?>
        <button data-target="manage_client_profile.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Profile</button>
        <button data-target="manage_client_booking.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Bookings</button>
        <button class="active" data-target="manage_client_activity.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Activity</button>
        <button data-target="manage_client_voucher.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Voucher</button>
      </div>

     <!-- Search and Filter -->
<div class="search-filter">
  <input id="activitySearch" type="text" placeholder="Search Activity" aria-label="Search activity">

  <div class="filter-dropdown">
<button class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter ▼</button>
    <div class="dropdown-content">
      
      <!-- Filter by Date -->
      <div class="filter-date">
        <p class="filter-title">Filter by Date</p>
        <div class="date-row">
          <label for="from-date">From:</label>
          <input type="date" id="from-date" value="2025-10-01">
        </div>
        <div class="date-row">
          <label for="to-date">Return:</label>
          <input type="date" id="to-date" value="2025-10-31">
        </div>
      </div>

      <button class="apply-btn">Apply</button>
    </div>
  </div>
</div>


      <!-- Activity Table -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Date &amp; Time</th>
              <th>Activity Type</th>
              <th>Details</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>2025 - 06 - 07 14:25</td>
              <td>Booking</td>
              <td>Booked Bungalow–Deep Cleaning with Ana Santos</td>
              <td><span class="status completed">Completed</span></td>
            </tr>
            <tr>
              <td>2025 - 06 - 07 13:25</td>
              <td>Cancellation Booking</td>
              <td>Booked Bungalow–Deep Cleaning with Ana Santos</td>
              <td><span class="status approved">Approved</span></td>
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

  <!-- JavaScript -->
  <script>
      (function(){
        // User Dropdown (defensive)
        const dropdownBtn = document.getElementById("userDropdownBtn");
        const dropdown = document.getElementById("userDropdown");
        if (dropdownBtn && dropdown) {
          dropdownBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            dropdown.classList.toggle("show");
          });
          window.addEventListener("click", (e) => {
            if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
          });
        }

        // Filter Dropdown (defensive)
        const filterBtn = document.querySelector('.filter-btn');
        const dropdownContent = document.querySelector('.dropdown-content');
        if (filterBtn && dropdownContent) {
          filterBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownContent.classList.toggle('show');
            filterBtn.innerHTML = dropdownContent.classList.contains('show')
              ? '<i class="fa-solid fa-sliders"></i> Filter ▲'
              : '<i class="fa-solid fa-sliders"></i> Filter ▼';
          });
          window.addEventListener('click', () => {
            dropdownContent.classList.remove('show');
            filterBtn.innerHTML = '<i class="fa-solid fa-sliders"></i> Filter ▼';
          });
        }

        // Tabs navigation
        (function(){
          const tabs = document.querySelector('.tabs');
          if (!tabs) return;
          const btns = Array.from(tabs.querySelectorAll('button'));
          btns.forEach(btn => btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-target');
            if (target) { try { window.location.href = target; } catch(e){ console.error(e); } }
            else { btns.forEach(b=>b.classList.remove('active')); btn.classList.add('active'); }
          }));
        })();

        // Search: live filter activity rows
        (function(){
          const input = document.getElementById('activitySearch');
          const tbody = document.querySelector('.table-container tbody');
          if (!input || !tbody) return;
          const rows = Array.from(tbody.querySelectorAll('tr'));
          function norm(s){ return (s||'').toString().replace(/\s+/g,' ').trim().toLowerCase(); }

          function applySearch(q){
            const qn = norm(q);
            rows.forEach(row => {
              // search across Date & Time, Activity Type, Details, and Status
              const date = norm(row.querySelector('td:nth-child(1)')?.textContent);
              const type = norm(row.querySelector('td:nth-child(2)')?.textContent);
              const details = norm(row.querySelector('td:nth-child(3)')?.textContent);
              const status = norm(row.querySelector('.status')?.textContent);
              const combined = [date,type,details,status].join(' ');
              row.dataset.searchHidden = qn && combined.indexOf(qn) === -1 ? 'true' : '';
              // combine with any existing filter-hidden flag if present
              const filterHidden = row.dataset.filterHidden === 'true';
              row.style.display = (row.dataset.searchHidden === 'true' || filterHidden) ? 'none' : '';
            });
          }

          let t = null;
          input.addEventListener('input', function(e){ clearTimeout(t); t = setTimeout(() => applySearch(e.target.value), 160); });
          input.addEventListener('keydown', function(e){ if (e.key === 'Escape'){ input.value = ''; applySearch(''); } });
        })();
      })();
  </script>
</body>
</html>


