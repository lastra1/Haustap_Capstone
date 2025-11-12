<?php require_once __DIR__ . '/includes/auth.php'; ?>
<?php
// Load provider data from storage by id
$provider = null;
$providerId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$storePath = realpath(__DIR__ . '/../../storage/data/providers.json');
if ($storePath && is_file($storePath)) {
  $raw = @file_get_contents($storePath);
  $items = json_decode($raw ?: '[]', true);
  if (is_array($items)) {
    foreach ($items as $it) {
      if (isset($it['id']) && (int)$it['id'] === $providerId) { $provider = $it; break; }
    }
  }
}
if (!$provider) {
  $provider = [
    'id' => $providerId ?: 0,
    'name' => 'Unknown',
    'status' => isset($_GET['status']) ? $_GET['status'] : 'active'
  ];
}
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Activity</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/manage_provider_activity.css">
<script src="js/lazy-images.js" defer></script>
</head>
<body>
  <div class="dashboard-container">
  <!-- Sidebar -->
  <?php $active = 'providers_activity'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Manage of Provider > Name </h3>
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
        <?php $pid = (int)($provider['id'] ?? 0); $pstatus = urlencode($provider['status'] ?? ''); ?>
        <button data-target="manage_provider_profile.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Profile</button>
        <button data-target="manage_provider_jobs.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Jobs</button>
        <button class="active" data-target="manage_provider_activity.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Activity</button>
        <button data-target="manage_provider_voucher.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Voucher</button>
        <button data-target="manage_provider_subscription.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Subscription</button>
      </div>

    <!-- Search and Filter -->
    <div class="search-filter">
      <input id="activitySearch" type="text" placeholder="Search Activity">

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
      // User Dropdown (defensive)
      (function(){
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

          // Activity search + date filter integration
          (function(){
            const searchInput = document.getElementById('activitySearch');
            const applyBtn = document.querySelector('.apply-btn');
            const fromDate = document.getElementById('from-date');
            const toDate = document.getElementById('to-date');

            function updateRowVisibility(){
              const rows = document.querySelectorAll('.table-container tbody tr');
              rows.forEach(row => {
                const fHidden = row.dataset.filterHidden === 'true';
                const sHidden = row.dataset.searchHidden === 'true';
                row.style.display = (fHidden || sHidden) ? 'none' : '';
              });
            }

            function parseDateFromCell(td){
              if (!td) return null;
              // Accepts formats like '2025 - 06 - 07 14:25' — normalize to YYYY-MM-DD
              const txt = td.textContent.trim().replace(/\s+/g,' ');
              const match = txt.match(/(\d{4})\s*-\s*(\d{2})\s*-\s*(\d{2})\s*(.*)/);
              if (!match) return null;
              const y = match[1], m = match[2], d = match[3];
              return new Date(`${y}-${m}-${d}`);
            }

            function applyDateFilter(){
              const f = fromDate && fromDate.value ? new Date(fromDate.value) : null;
              const t = toDate && toDate.value ? new Date(toDate.value) : null;
              const rows = document.querySelectorAll('.table-container tbody tr');
              rows.forEach(row => {
                const dateTd = row.querySelector('td:nth-child(1)');
                const d = parseDateFromCell(dateTd);
                let hide = false;
                if (d && f && d < f) hide = true;
                if (d && t) { t.setHours(23,59,59,999); if (d > t) hide = true; }
                row.dataset.filterHidden = hide ? 'true' : '';
              });
              updateRowVisibility();
            }

            function debounce(fn, wait){ let t; return (...args) => { clearTimeout(t); t = setTimeout(()=>fn(...args), wait); }; }

            function applySearch(q){
              const ql = (q||'').trim().toLowerCase();
              const rows = document.querySelectorAll('.table-container tbody tr');
              rows.forEach(row => {
                const dateText = (row.querySelector('td:nth-child(1)')||{textContent:''}).textContent.toLowerCase();
                const typeText = (row.querySelector('td:nth-child(2)')||{textContent:''}).textContent.toLowerCase();
                const detailsText = (row.querySelector('td:nth-child(3)')||{textContent:''}).textContent.toLowerCase();
                const statusText = (row.querySelector('td:nth-child(4)')||{textContent:''}).textContent.toLowerCase();
                const matches = ql === '' || dateText.includes(ql) || typeText.includes(ql) || detailsText.includes(ql) || statusText.includes(ql);
                row.dataset.searchHidden = matches ? '' : 'true';
              });
              updateRowVisibility();
            }

            if (searchInput) searchInput.addEventListener('input', debounce((e)=>applySearch(e.target.value), 200));
            if (applyBtn) applyBtn.addEventListener('click', (e)=>{ e.preventDefault(); applyDateFilter(); dropdownContent.classList.remove('show'); });
          })();
      })();

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
  </script>
</body>
</html>


