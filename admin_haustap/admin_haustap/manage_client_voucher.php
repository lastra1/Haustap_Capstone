<?php require_once __DIR__ . '/includes/auth.php'; ?>
<?php
$cid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$cstatus = isset($_GET['status']) ? urlencode($_GET['status']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Manage Clients</title>
  <link rel="stylesheet" href="css/manage_client_voucher.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="js/lazy-images.js" defer></script></head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'clients'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Manage Clients</h3>
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
        <button data-target="manage_client_profile.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Profile</button>
        <button data-target="manage_client_booking.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Bookings</button>
        <button class="active" data-target="manage_client_voucher.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Voucher</button>
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
    
    // Tabs navigation: navigate to pages specified in data-target
    (function(){
      const tabsContainer = document.querySelector('.tabs');
      if (!tabsContainer) return;
      const btns = Array.from(tabsContainer.querySelectorAll('button'));
      btns.forEach(btn => {
        btn.addEventListener('click', function(e){
          const target = btn.getAttribute('data-target');
          if (target) { try { window.location.href = target; } catch(err) { console.error('Navigation failed', err); } return; }
          btns.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
        });
      });
    })();
<<<<<<< Updated upstream
=======

    // Search input filtering for vouchers
    (function(){
      const input = document.getElementById('searchInput') || document.querySelector('.search-filter input[type="text"]');
      if (!input) return;

      function searchRows(){
        const q = (input.value || '').trim().toLowerCase();
        const rows = document.querySelectorAll('.voucher-table tbody tr');

        // Read date range inputs (if present)
        const fromInput = document.getElementById('from-date');
        const toInput = document.getElementById('to-date');
        const fromVal = fromInput ? fromInput.value : '';
        const toVal = toInput ? toInput.value : '';

        // Normalize date range
        let fromDate = null, toDate = null;
        if (fromVal) fromDate = new Date(fromVal + 'T00:00:00');
        if (toVal) toDate = new Date(toVal + 'T23:59:59');
        if (fromDate && toDate && fromDate > toDate) {
          // swap to make a valid range
          const tmp = fromDate; fromDate = toDate; toDate = tmp;
        }

        rows.forEach(row => {
          const code = (row.cells[0] && row.cells[0].textContent || '').toLowerCase();
          const discount = (row.cells[1] && row.cells[1].textContent || '').toLowerCase();
          const expiryText = (row.cells[2] && row.cells[2].textContent || '').trim();
          const expiry = expiryText.toLowerCase();
          const status = (row.querySelector('.status') && row.querySelector('.status').textContent || '').toLowerCase();

          const hay = `${code} ${discount} ${expiry} ${status}`;
          const textMatches = q === '' || hay.indexOf(q) !== -1;

          // Date range check
          let dateMatches = true;
          if ((fromDate || toDate) && expiryText) {
            const rowDate = new Date(expiryText + 'T00:00:00');
            if (isNaN(rowDate.getTime())) {
              dateMatches = false;
            } else {
              if (fromDate && rowDate < fromDate) dateMatches = false;
              if (toDate && rowDate > toDate) dateMatches = false;
            }
          }

          const matches = textMatches && dateMatches;
          row.style.display = matches ? '' : 'none';
        });
      }

      input.addEventListener('input', searchRows);

      // If filter dropdown has an apply button (date filters), re-run search after apply
      const dropdownContent = document.querySelector('.dropdown-content');
      if (dropdownContent) {
        const applyBtn = dropdownContent.querySelector('.apply-btn');
        if (applyBtn) applyBtn.addEventListener('click', (e) => { e.preventDefault(); searchRows(); });
      }
    })();
>>>>>>> Stashed changes
  </script>
</body>
</html>



