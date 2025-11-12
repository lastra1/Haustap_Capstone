<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Bookings</title>
  <link rel="stylesheet" href="css/manage_booking.css">
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
        <!-- Tabs -->
      <div class="tabs">
        <button class="tab active" data-status="all" data-target="manage_booking.php">All</button>
        <button class="tab" data-status="pending" data-target="manage_booking_pending.php">Pending</button>
        <button class="tab" data-status="ongoing" data-target="manage_booking_ongoing.php">Ongoing</button>
        <button class="tab" data-status="complete" data-target="manage_booking_completed.php">Completed</button>
        <button class="tab" data-status="cancelled" data-target="manage_booking_cancelled.php">Cancelled</button>
        <button class="tab" data-status="return" data-target="manage_booking_return.php">Return</button>
      </div>

       <!-- Search and Filter -->
<div class="search-filter">
  <input type="text" class="search-input" placeholder="Search bookings (id, client, provider, service, date, status)" aria-label="Search bookings">

  <div class="filter-dropdown">
<button class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</button>
    <div class="dropdown-content">
            <p class="filter-title">Filter by Status</p>
            <div class="checkbox-group">
              <label><input type="checkbox" value="pending" checked> Pending</label>
              <label><input type="checkbox" value="ongoing" checked> Ongoing</label>
              <label><input type="checkbox" value="complete" checked> Completed</label>
              <label><input type="checkbox" value="cancelled" checked> Cancelled</label>
              <label><input type="checkbox" value="return" checked> Return</label>
            </div>
            <button class="apply-btn">Apply</button>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Booking ID</th>
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
              <td>Juan Ewan Dela Cruz</td>
              <td>Ramon Ang</td>
              <td>Home Cleaning</td>
              <td>2025-06-07 14:30</td>
              <td><span class="status complete">Complete</span></td>
              <td class="arrow">›</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Ramon Ang</td>
              <td>Juan Dela Cruz</td>
              <td>Home Cleaning</td>
              <td>2025-06-07 14:30</td>
              <td><span class="status cancelled">Cancelled</span></td>
              <td class="arrow">›</td>
            </tr>
          </tbody>
        </table>
       <div class="pagination">
          <span>[ ◀ Prev ]</span>
          <span>Showing 2–10 of 120 Clients</span>
          <span>[ Next ▶ ]</span>
        </div>
      </div>
      </div>
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

    // Global helper: show rows matching a given booking status (or all)
    function showRowsForStatus(status){
      // Tab-based filtering sets data-tab-hidden so it composes with other filters (status/search)
      const rows = document.querySelectorAll('.table-container tbody tr');
      rows.forEach(row => {
        const badge = row.querySelector('.status');
        let s = '';
        if (badge) {
          const c = badge.classList;
          if (c.contains('complete') || c.contains('completed')) s = 'complete';
          else if (c.contains('ongoing')) s = 'ongoing';
          else if (c.contains('pending')) s = 'pending';
          else if (c.contains('cancelled')) s = 'cancelled';
          else if (c.contains('return')) s = 'return';
        }
        // set per-row tab-hidden flag instead of directly changing style so search + status filters combine
        if (!status || status === 'all') row.dataset.tabHidden = '';
        else row.dataset.tabHidden = (s === status) ? '' : 'true';
        if (typeof window.updateBookingRowVisibility === 'function') window.updateBookingRowVisibility(row);
      });
    }

    // Filter dropdown toggle (scoped to this filter button)
    (function(){
      const filterBtn = document.querySelector('.filter-btn');
      if (!filterBtn) return;
      // prefer the dropdown located inside the same parent as the button
      const dropdownContent = filterBtn.parentElement && filterBtn.parentElement.querySelector('.dropdown-content') || document.querySelector('.dropdown-content');
      if (!dropdownContent) return;
      filterBtn.setAttribute('aria-expanded', 'false');
      filterBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownContent.classList.toggle('show');
        const expanded = dropdownContent.classList.contains('show');
        filterBtn.innerHTML = expanded ? '<i class="fa-solid fa-sliders"></i> Filter ▲' : '<i class="fa-solid fa-sliders"></i> Filter ▼';
        filterBtn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
      });
      window.addEventListener('click', (e) => {
        if (!dropdownContent.contains(e.target) && !filterBtn.contains(e.target)) {
          dropdownContent.classList.remove('show');
          filterBtn.innerHTML = '<i class="fa-solid fa-sliders"></i> Filter ▼';
          filterBtn.setAttribute('aria-expanded','false');
        }
      });
    })();

    // Status filter: encapsulated initializer so tabs and other filters don't interfere
    (function initStatusFilter(){
      const filterBtn = document.querySelector('.filter-btn');
      const dropdownContent = filterBtn && (filterBtn.parentElement && filterBtn.parentElement.querySelector('.dropdown-content')) || document.querySelector('.dropdown-content');
      if (!dropdownContent) return;
      const applyBtn = dropdownContent.querySelector('.apply-btn');
      const checkboxes = dropdownContent.querySelectorAll('input[type="checkbox"]');

      function getRowStatus(row){
        const badge = row.querySelector('.status');
        let s = '';
        if (badge) {
          const c = badge.classList;
          if (c.contains('complete') || c.contains('completed')) s = 'complete';
          else if (c.contains('ongoing')) s = 'ongoing';
          else if (c.contains('pending')) s = 'pending';
          else if (c.contains('cancelled')) s = 'cancelled';
          else if (c.contains('return')) s = 'return';
        }
        return s;
      }

      function applyStatusFilter(){
        const selected = new Set(Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value));
        const rows = document.querySelectorAll('.table-container tbody tr');
        let matched = 0;
        rows.forEach(row => {
          const s = getRowStatus(row);
          if (selected.size === 0) {
            row.dataset.statusHidden = '';
          } else {
            const show = selected.has(s);
            row.dataset.statusHidden = show ? '' : 'true';
            if (show) matched++;
          }
          if (typeof window.updateBookingRowVisibility === 'function') window.updateBookingRowVisibility(row);
        });
        console.debug('applyStatusFilter', { selected: Array.from(selected), matched, total: rows.length });
      }

      if (applyBtn) applyBtn.addEventListener('click', (e) => {
        e.preventDefault();
        applyStatusFilter();
        if (dropdownContent) dropdownContent.classList.remove('show');
        if (filterBtn) { filterBtn.innerHTML = '<i class="fa-solid fa-sliders"></i> Filter ▼'; filterBtn.setAttribute('aria-expanded','false'); }
        console.debug('status apply clicked');
      });

      // Apply when a checkbox changes for a more responsive UI
      checkboxes.forEach(cb => cb.addEventListener('change', () => applyStatusFilter()));

      // initialize (ensure rows reflect default checked boxes)
      applyStatusFilter();
    })();

    // Helper: combine tab, status and search hidden flags to set final visibility
    window.updateBookingRowVisibility = function(row){
      try {
        const tabHidden = row.dataset.tabHidden === 'true';
        const statusHidden = row.dataset.statusHidden === 'true';
        const searchHidden = row.dataset.searchHidden === 'true';
        row.style.display = (tabHidden || statusHidden || searchHidden) ? 'none' : '';
      } catch(err) {
        row.style.display = '';
      }
    };

    // Tabs navigation: navigate to specific manage_booking_* pages
    (function(){
      const tabs = document.querySelectorAll('.tabs .tab');
      if (!tabs || tabs.length === 0) return;
      tabs.forEach(t => {
        t.addEventListener('click', (e) => {
          // If the tab has a data-status attribute, filter in-place instead of navigating.
          const status = t.getAttribute('data-status');
          if (status !== null) {
            e.preventDefault();
            // set active class
            tabs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            // show matching rows
            if (typeof showRowsForStatus === 'function') showRowsForStatus(status);
            return;
          }

          // Fallback: navigate using data-target (legacy behaviour)
          const target = t.getAttribute('data-target');
          if (!target) return;
          try {
            const targetUrl = new URL(target, window.location.href).href;
            if (e.ctrlKey || e.metaKey || e.button === 1) {
              window.open(targetUrl, '_blank');
              return;
            }
            window.location.assign(targetUrl);
          } catch (err) {
            console.warn('Tab navigation failed for target:', target, err);
          }
        });
      });
    })();

    // Auto-set active tab based on current filename (so direct visits highlight correct tab)
    (function(){
      try {
        const path = (window.location.pathname || '').split('/').pop() || '';
        const filename = path || 'manage_booking.php';
        const tabs = document.querySelectorAll('.tabs .tab');
        if (!tabs || tabs.length === 0) return;
        let matched = false;
        tabs.forEach(t => {
          const dt = (t.getAttribute('data-target') || '').toLowerCase();
          if (!dt) return;
          if (dt === filename.toLowerCase()) {
            tabs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            matched = true;
          }
        });
        // If no explicit match, keep 'All' active for manage_booking.php or default pages
        if (!matched) {
          // try matching by status name in filename (e.g. manage_booking_pending.php -> data-status="pending")
          const lower = filename.toLowerCase();
          const byStatus = Array.from(tabs).find(t => {
            const st = (t.getAttribute('data-status') || '').toLowerCase();
            return st && lower.indexOf(st) !== -1;
          });
          if (byStatus) {
            tabs.forEach(x => x.classList.remove('active'));
            byStatus.classList.add('active');
            // apply initial filter for this status
            if (typeof showRowsForStatus === 'function') showRowsForStatus(byStatus.getAttribute('data-status'));
            matched = true;
          } else {
            const all = Array.from(tabs).find(t => (t.getAttribute('data-target')||'').toLowerCase().endsWith('manage_booking.php'));
            if (all) {
              tabs.forEach(x => x.classList.remove('active'));
              all.classList.add('active');
              if (typeof showRowsForStatus === 'function') showRowsForStatus('all');
            }
          }
        }
      } catch (err) { /* non-fatal */ }
    })();

    // ----------------------
    // Search input: live filter for bookings
    // ----------------------
    (function(){
      const input = document.querySelector('.search-input');
      const tbody = document.querySelector('.table-container tbody');
      if (!input || !tbody) return;

      const rows = Array.from(tbody.querySelectorAll('tr'));
      const norm = s => (s||'').toString().replace(/\s+/g,' ').trim().toLowerCase();

      function applySearch(q){
        const text = norm(q);
        rows.forEach(row => {
          const id = norm(row.querySelector('td:first-child')?.textContent);
          const client = norm(row.querySelector('td:nth-child(2)')?.textContent);
          const provider = norm(row.querySelector('td:nth-child(3)')?.textContent);
          const service = norm(row.querySelector('td:nth-child(4)')?.textContent);
          const datetime = norm(row.querySelector('td:nth-child(5)')?.textContent);
          const status = norm(row.querySelector('.status')?.textContent);
          const combined = [id, client, provider, service, datetime, status].join(' ');

          if (!text) {
            row.dataset.searchHidden = '';
            if (typeof window.updateBookingRowVisibility === 'function') window.updateBookingRowVisibility(row);
            return;
          }

          const matches = combined.indexOf(text) !== -1;
          row.dataset.searchHidden = matches ? '' : 'true';
          if (typeof window.updateBookingRowVisibility === 'function') window.updateBookingRowVisibility(row);
        });
      }

      let timer = null;
      input.addEventListener('input', function(e){ clearTimeout(timer); timer = setTimeout(() => applySearch(e.target.value), 180); });
      input.addEventListener('keydown', function(e){ if (e.key === 'Escape'){ input.value = ''; applySearch(''); } });
    })();
  </script>
</body>
</html>



