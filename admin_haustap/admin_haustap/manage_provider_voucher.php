<?php require_once __DIR__ . '/includes/auth.php';
$pid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pstatus = isset($_GET['status']) ? urlencode($_GET['status']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Manage Clients</title>
  <link rel="stylesheet" href="css/manage_provider_voucher.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="js/lazy-images.js" defer></script></head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'providers'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Manage Providers</h3>
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button id="userDropdownBtn" class="user-dropdown-btn">Mj Punzalan ▼</button>
            <div class="user-dropdown" id="userDropdown">
              <a href="#">View Profile</a>
              <a href="#">Change Password</a>
              <a href="#" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>
        <!-- Tabs -->
      <div class="tabs">
        <button data-target="manage_provider_profile.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Profile</button>
        <button data-target="manage_provider_jobs.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Jobs</button>
        <button class="active" data-target="manage_provider_voucher.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Voucher</button>
        <button data-target="manage_provider_subscription.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Subscription</button>
      </div>

      <!-- Search and Filter -->
<div class="search-filter">
  <input id="searchInput" type="text" placeholder="Search">

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

        <!-- Table -->
        <div class="voucher-table">
          <table>
            <thead>
              <tr>
                <th>Code</th>
                <th>Discount</th>
                <th>Expiry Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>WELCOME VOUCHER</td>
                <td>₱50 OFF</td>
                <td>2025-10-01</td>
                <td><span class="status active">Active</span></td>
              </tr>
              <tr>
                <td>LOYALTY BONUS</td>
                <td>₱50 OFF</td>
                <td>2025-10-01</td>
                <td><span class="status expired">Expired</span></td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="pagination">
            <button class="prev">◀ Prev</button>
            <p>Showing 2–10 of 120</p>
            <button class="next">Next ▶</button>
          </div>
        </div>
      </section>

    </main>
  </div>

  <script>
    // User Dropdown
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    // Close user dropdown when clicking outside
    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });

    // Filter Dropdown
    const filterBtn = document.querySelector('.filter-btn');
    const dropdownContent = document.querySelector('.dropdown-content');

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

    // Tabs navigation handler: navigate to data-target when present
    (function(){
      const tabsContainer = document.querySelector('.tabs');
      if (!tabsContainer) return;
      const buttons = Array.from(tabsContainer.querySelectorAll('button'));
      buttons.forEach(btn => {
        btn.addEventListener('click', function(e){
          const target = btn.getAttribute('data-target');
          if (target) { window.location.href = target; return; }
          buttons.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
        });
      });
    })();
<<<<<<< Updated upstream
=======
    
    // Search + date filter for vouchers
    (function(){
      const input = document.getElementById('searchInput') || document.querySelector('.search-filter input[type="text"]');
      const dropdownContent = document.querySelector('.dropdown-content');
      const applyBtn = dropdownContent ? dropdownContent.querySelector('.apply-btn') : null;
      const fromInput = document.getElementById('from-date');
      const toInput = document.getElementById('to-date');

      function parseRowDate(text){
        if (!text) return null;
        const d = new Date(text + 'T00:00:00');
        return isNaN(d.getTime()) ? null : d;
      }

      function applyFilters(){
        const q = (input && input.value || '').trim().toLowerCase();
        const fromVal = fromInput ? fromInput.value : '';
        const toVal = toInput ? toInput.value : '';
        let fromDate = fromVal ? new Date(fromVal + 'T00:00:00') : null;
        let toDate = toVal ? new Date(toVal + 'T23:59:59') : null;
        if (fromDate && toDate && fromDate > toDate){ const t = fromDate; fromDate = toDate; toDate = t; }

        const rows = document.querySelectorAll('.voucher-table tbody tr');
        rows.forEach(row => {
          const code = (row.cells[0] && row.cells[0].textContent || '').toLowerCase();
          const discount = (row.cells[1] && row.cells[1].textContent || '').toLowerCase();
          const expiryText = (row.cells[2] && row.cells[2].textContent || '').trim();
          const status = (row.querySelector('.status') && row.querySelector('.status').textContent || '').toLowerCase();

          const hay = `${code} ${discount} ${expiryText} ${status}`.toLowerCase();
          const textMatch = q === '' || hay.indexOf(q) !== -1;

          let dateMatch = true;
          if ((fromDate || toDate) && expiryText) {
            const rowDate = parseRowDate(expiryText);
            if (!rowDate) dateMatch = false;
            else {
              if (fromDate && rowDate < fromDate) dateMatch = false;
              if (toDate && rowDate > toDate) dateMatch = false;
            }
          }

          row.style.display = (textMatch && dateMatch) ? '' : 'none';
        });
      }

      if (input) input.addEventListener('input', applyFilters);
      if (applyBtn) applyBtn.addEventListener('click', (e) => { e.preventDefault(); applyFilters(); });

      // initial run
      applyFilters();
    })();
>>>>>>> Stashed changes
  </script>
</body>
</html>


