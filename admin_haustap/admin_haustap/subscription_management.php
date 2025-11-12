<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Subscription Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/subscription_management.css" />
<script src="js/lazy-images.js" defer></script>
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'subscription'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Job Status Monitor</h3>
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button id="userDropdownBtn" class="user-dropdown-btn">Mj Punzalan ▼</button>
            <div class="user-dropdown" id="userDropdown">
              <a href="admin_profile.php">View Profile</a>
              <a href="/admin_haustap/admin_haustap/change_password.php">Change Password</a>
              <a href="activity_logs.php">Activity Logs</a>
              <a href="logout.php" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <!-- Search and Filter -->
      <div class="search-filter">
        <input type="text" placeholder="Search Provider">
        <div class="filter-dropdown">
<div class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</div>
          <div class="dropdown-content">
            <p class="filter-title">Filter by Status</p>
            <label><input type="checkbox" value="active"> Active</label>
            <label><input type="checkbox" value="expired"> Expired</label>
            <label><input type="checkbox" value="inactive"> Inactive</label>
            <button class="apply-btn">Apply</button>
          </div>
        </div>
      </div>

      <!-- Subscription Table -->
      <table class="subscription-table">
        <thead>
          <tr>
            <th>Provider Name</th>
            <th>Plan Name</th>
            <th>Start Date</th>
            <th>Expiration Date</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Ana Santos</td>
            <td>Haustap Standard Access</td>
            <td>2025-10-01</td>
            <td>2025-10-31</td>
            <td class="status active">Active</td>
            <td>></td>
          </tr>
          <tr>
            <td>Juan Dela Cruz</td>
            <td>Haustap Standard Access</td>
            <td>2025-09-01</td>
            <td>2025-09-30</td>
            <td class="status expired">Expired</td>
            <td>></td>
          </tr>
          <tr>
            <td>Liza Ramos</td>
            <td>Haustap Partner Plan</td>
            <td>—</td>
            <td>—</td>
            <td class="status inactive">Inactive</td>
            <td>></td>
          </tr>
        </tbody>
      </table>

      <div class="pagination">
        <button class="prev">◀ Prev</button>
        <span>Showing 3–10 of 120</span>
        <button class="next">Next ▶</button>
      </div>
    </main>
  </div>

  <!-- Active Subscription Modal -->
  <div id="subscriptionModal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>

      <section class="modal-section">
        <h4>Subscription Details</h4>
        <p><strong>Subscription ID:</strong> 0123</p>
        <p><strong>Plan Name:</strong> Haustap Partner Plan</p>
        <p><strong>Plan Price:</strong> ₱499</p>
        <p><strong>Duration:</strong> 30 Days</p>
        <p><strong>Start Date:</strong> October 1, 2025</p>
        <p><strong>Expiration Date:</strong> October 31, 2025</p>
        <p><strong>Status:</strong> <span class="status active">Active</span></p>
      </section>

      <section class="modal-section">
        <h4>Payment Information</h4>
        <p><strong>Payment Method:</strong> GCash</p>
        <p><strong>GCash Reference No.:</strong> 100294837650</p>
        <p><strong>Date of Payment:</strong> October 1, 2025 – 10:42 AM</p>
        <p><strong>Payment Status:</strong> <span class="paid">Paid & Verified</span></p>
      </section>

      <section class="modal-section">
        <h4>Billing Summary</h4>
        <p><strong>Plan Price:</strong> ₱499</p>
        <p><strong>Voucher Applied:</strong> ₱50</p>
        <p><strong>Next Payment Amount:</strong> ₱449</p>
        <p class="note">Voucher Note: Your ₱50 voucher was successfully applied to this subscription.</p>
      </section>

      <section class="modal-section">
        <h4>Subscriber Information</h4>
        <p><strong>Service Provider Name:</strong> Juan Dela Cruz</p>
        <p><strong>Email:</strong> juan@haustap.com</p>
        <p><strong>Service Category:</strong> Plumbing</p>
        <p><strong>Account Status:</strong> Verified</p>
      </section>
    </div>
  </div>

  <!-- Expired Subscription Modal -->
  <div id="expiredModal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>

      <section class="modal-section">
        <h4>Subscription Details</h4>
        <p><strong>Subscription ID:</strong> 0123</p>
        <p><strong>Plan Name:</strong> Haustap Partner Plan</p>
        <p><strong>Plan Price:</strong> ₱499</p>
        <p><strong>Duration:</strong> 30 Days</p>
        <p><strong>Start Date:</strong> October 1, 2025</p>
        <p><strong>Expiration Date:</strong> October 31, 2025</p>
        <p><strong>Status:</strong> <span class="status expired">Expired</span></p>
      </section>

      <section class="modal-section">
        <h4>Payment Information</h4>
        <p><strong>Payment Method:</strong> GCash</p>
        <p><strong>GCash Reference No.:</strong> 100294837650</p>
        <p><strong>Date of Payment:</strong> October 1, 2025 – 10:42 AM</p>
        <p><strong>Payment Status:</strong> <span class="completed">Completed</span></p>
      </section>

      <section class="modal-section">
        <h4>Billing Summary</h4>
        <p><strong>Plan Price:</strong> ₱499</p>
        <p><strong>Voucher Applied:</strong> ₱50</p>
        <p><strong>Next Payment Amount:</strong> ₱449</p>
      </section>
    </div>
  </div>

  <!-- Inactive Subscription Modal -->
  <div id="inactiveModal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>

      <section class="modal-section">
        <h4>Subscription Details</h4>
        <p><strong>Subscription ID:</strong> 0123</p>
        <p><strong>Plan Name:</strong> Haustap Partner Plan</p>
        <p><strong>Plan Price:</strong> ₱499</p>
        <p><strong>Duration:</strong> 30 Days</p>
        <p><strong>Start Date:</strong> —</p>
        <p><strong>Expiration Date:</strong> —</p>
        <p><strong>Status:</strong> <span class="status inactive">Inactive</span></p>
      </section>

      <section class="modal-section">
        <h4>Payment Information</h4>
        <p><strong>Payment Method:</strong> —</p>
        <p><strong>GCash Reference No.:</strong> —</p>
        <p><strong>Date of Payment:</strong> —</p>
        <p><strong>Payment Status:</strong> —</p>
      </section>
    </div>
  </div>

  <!-- JS -->
  <script>
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");
    if (dropdownBtn && dropdown) {
      dropdownBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        dropdown.classList.toggle("show");
      });
      window.addEventListener("click", (e) => {
        if (!dropdown.contains(e.target) && e.target !== dropdownBtn) {
          dropdown.classList.remove("show");
        }
      });
    }

    // Filter dropdown toggle (scoped + accessible)
    (function(){
      const filterBtn = document.querySelector('.filter-btn');
      if (!filterBtn) return;
      // ensure role/button and keyboard focus
      filterBtn.setAttribute('role','button');
      filterBtn.setAttribute('tabindex','0');
      // find dropdown content scoped to this filter button
      const dropdownContent = filterBtn.parentElement && filterBtn.parentElement.querySelector('.dropdown-content') || document.querySelector('.dropdown-content');
      if (!dropdownContent) return;
      // initialise aria state
      filterBtn.setAttribute('aria-expanded','false');
      function closeDropdown(){ dropdownContent.classList.remove('show'); filterBtn.setAttribute('aria-expanded','false'); filterBtn.innerHTML = '<i class="fa-solid fa-sliders"></i> Filter ▼'; }
      function openDropdown(){ dropdownContent.classList.add('show'); filterBtn.setAttribute('aria-expanded','true'); filterBtn.innerHTML = '<i class="fa-solid fa-sliders"></i> Filter ▲'; }

      filterBtn.addEventListener('click', (e) => { e.stopPropagation(); dropdownContent.classList.toggle('show'); const expanded = dropdownContent.classList.contains('show'); filterBtn.setAttribute('aria-expanded', expanded ? 'true' : 'false'); filterBtn.innerHTML = expanded ? '<i class="fa-solid fa-sliders"></i> Filter ▲' : '<i class="fa-solid fa-sliders"></i> Filter ▼'; });

      // keyboard support (Enter/Space)
      filterBtn.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); filterBtn.click(); } });

      window.addEventListener('click', (e) => { if (!dropdownContent.contains(e.target) && !filterBtn.contains(e.target)) { closeDropdown(); } });
    })();

    // Status filter: apply via Apply button (supports multi-select)
    (function(){
      const filterBtn = document.querySelector('.filter-btn');
      const dropdownContent = filterBtn && (filterBtn.parentElement && filterBtn.parentElement.querySelector('.dropdown-content')) || document.querySelector('.dropdown-content');
      if (!dropdownContent) return;
      const checkboxes = dropdownContent.querySelectorAll('input[type="checkbox"]');
      const applyBtn = dropdownContent.querySelector('.apply-btn');

      function rowStatus(badge){
        if (!badge) return '';
        const cls = badge.classList;
        if (cls.contains('active')) return 'active';
        if (cls.contains('expired')) return 'expired';
        if (cls.contains('inactive')) return 'inactive';
        return '';
      }

      function applyFilter(){
        const selected = new Set(Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value));
        const rows = document.querySelectorAll('.subscription-table tbody tr');
        let matched = 0;
        rows.forEach(row => {
          const badge = row.querySelector('.status');
          const s = rowStatus(badge);
            const show = (selected.size === 0 || selected.has(s));
            row.dataset.statusHidden = show ? '' : 'true';
            if (show) matched++;
        });
        console.debug('subscription applyFilter', { selected: Array.from(selected), matched, total: rows.length });
        // after applying, disable apply until next change
        if (applyBtn) applyBtn.disabled = true;
      }

      // Track changes and enable Apply (do not auto-apply)
      checkboxes.forEach(cb => cb.addEventListener('change', () => {
        if (applyBtn) applyBtn.disabled = false;
      }));

      if (applyBtn) {
        applyBtn.addEventListener('click', (e) => { 
          e.preventDefault();
          applyFilter();
          // close dropdown and reset aria/label
          if (dropdownContent) dropdownContent.classList.remove('show');
          if (filterBtn) { filterBtn.innerHTML = '<i class="fa-solid fa-sliders"></i> Filter ▼'; filterBtn.setAttribute('aria-expanded','false'); }
        });
      }

      // initialize: disable apply button until user changes selection
      if (applyBtn) applyBtn.disabled = true;
      // run initial filter based on default checked boxes
      applyFilter();
      // helper: compose status + search visibility
      // expose visibility composer globally so other modules (search) can call it
      window.updateSubscriptionRowVisibility = function(row){
        try {
          const statusHidden = row.dataset.statusHidden === 'true';
          const searchHidden = row.dataset.searchHidden === 'true';
          row.style.display = (statusHidden || searchHidden) ? 'none' : '';
        } catch (err) { row.style.display = ''; }
      }
      // initialize visibility for all rows
      document.querySelectorAll('.subscription-table tbody tr').forEach(r => updateSubscriptionRowVisibility(r));
    })();

    // Search: filter by provider name (first column). Debounced.
    (function(){
      const input = document.querySelector('.search-filter input[type="text"]');
      if (!input) return;
      const rows = Array.from(document.querySelectorAll('.subscription-table tbody tr'));
      const norm = s => (s||'').toString().replace(/\s+/g,' ').trim().toLowerCase();
      let timer = null;
      function applySearch(q){
        const text = norm(q);
        rows.forEach(row => {
          const provider = norm(row.querySelector('td:first-child')?.textContent);
          const matches = !text || provider.indexOf(text) !== -1;
          row.dataset.searchHidden = matches ? '' : 'true';
          updateSubscriptionRowVisibility(row);
        });
      }
      input.addEventListener('input', (e) => { clearTimeout(timer); timer = setTimeout(() => applySearch(e.target.value), 180); });
      input.addEventListener('keydown', (e) => { 
        if (e.key === 'Escape'){ input.value = ''; applySearch(''); }
        if (e.key === 'Enter') { // immediate apply on Enter
          e.preventDefault(); clearTimeout(timer); applySearch(input.value);
        }
      });
      // wire search button (immediate apply)
      const searchBtn = document.querySelector('.search-filter .search-btn');
      if (searchBtn) searchBtn.addEventListener('click', (ev) => { ev.preventDefault(); clearTimeout(timer); applySearch(input.value); });
      // init
      applySearch(input.value || '');
    })();

    // Modals
    const activeModal = document.getElementById("subscriptionModal");
    const expiredModal = document.getElementById("expiredModal");
    const inactiveModal = document.getElementById("inactiveModal");

    document.querySelectorAll(".subscription-table tbody tr").forEach((row) => {
      const statusCell = row.querySelector(".status");
      const arrowCell = row.querySelector("td:last-child");

      if (statusCell && arrowCell) {
        arrowCell.addEventListener("click", () => {
          const statusText = statusCell.textContent.trim();
          if (statusText === "Active") {
            activeModal.style.display = "flex";
          } else if (statusText === "Expired") {
            expiredModal.style.display = "flex";
          } else if (statusText === "Inactive") {
            inactiveModal.style.display = "flex";
          }
        });
      }
    });

    document.querySelectorAll(".modal .close-btn").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.target.closest(".modal").style.display = "none";
      });
    });

    window.addEventListener("click", (e) => {
      if (e.target.classList.contains("modal")) {
        e.target.style.display = "none";
      }
    });
  </script>
</body>
</html>



