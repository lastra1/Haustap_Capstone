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
        <h3>Manage Bookings</h3>
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button id="userDropdownBtn" class="user-dropdown-btn">Mj Punzalan ▼</button>
            <div class="user-dropdown" id="userDropdown">
              <a href="admin_profile.php">View Profile</a>
              <a href="/admin_haustap/admin_haustap/change_password.php">Change Password</a>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
              <a href="/admin_haustap/admin_haustap/activity_logs.php">Activity Logs</a>
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
            <p class="filter-title">Filter by Status</p>
            <label><input type="checkbox"> Pending</label>
            <label><input type="checkbox"> Ongoing</label>
            <label><input type="checkbox"> Completed</label>
            <label><input type="checkbox"> Cancelled</label>
            <label><input type="checkbox"> Return</label>
            <button class="apply-btn">Apply</button>
          </div>
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
      <!-- Filter by Date -->
      <div class="filter-date">
        <p class="filter-title">Filter by Date</p>
        <div class="date-row">
          <label for="from-date">From:</label>
          <input type="date" id="from-date" value="2025-06-01">
        </div>
        <div class="date-row">
          <label for="to-date">To:</label>
          <input type="date" id="to-date" value="2025-06-30">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
        </div>
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

      <!-- Booking Details Modal -->
      <div id="bookingModal" class="modal-backdrop" aria-hidden="true">
        <div class="modal-card" role="dialog" aria-labelledby="bookingModalTitle">
          <button class="modal-close" id="bookingModalClose" aria-label="Close">&times;</button>
          <div class="modal-inner">
            <div class="modal-top">
              <div class="modal-top-left">
                <div class="meta-line"><strong>Service Provider:</strong> <span id="md_provider">—</span></div>
                <div class="meta-line"><strong>Client:</strong> <span id="md_client">—</span></div>
                <div class="meta-line"><strong>Service:</strong> <span id="md_service">—</span></div>
              </div>
              <div class="modal-top-right" id="md_status_badge">
                <!-- status pill inserted here -->
              </div>
            </div>

            <div class="modal-section">
              <div class="two-cols">
                <div>
                  <div class="small-label">Home Cleaning - Bungalow - Basic Cleaning</div>
                  <div class="info-row"><div class="info-label">Date</div><div class="info-val" id="md_date">—</div></div>
                  <div class="info-row"><div class="info-label">Time</div><div class="info-val" id="md_time">—</div></div>
                  <hr>
                  <div class="info-row"><div class="info-label">Address</div><div class="info-val" id="md_address">—</div></div>
                </div>
                <div>
                  <div class="info-row"><div class="info-label">Selected</div><div class="info-val" id="md_selected">—</div></div>
                  <div class="info-row"><div class="info-label">Inclusions</div><div class="info-val" id="md_inclusions">—</div></div>
                  <div class="notes-row"><label>Notes:</label><textarea id="md_notes" rows="2" readonly></textarea></div>
                </div>
              </div>
            </div>

            <div class="modal-section totals-section">
              <div class="voucher-box">No voucher added</div>
              <div class="totals-grid">
                <div class="tot-row"><div>Sub Total</div><div id="md_subtotal" class="tot-val">₱1,000.00</div></div>
                <div class="tot-row"><div>Voucher Discount</div><div id="md_voucher_discount" class="tot-val">₱0.00</div></div>
                <div class="tot-row"><div>Transportation Fee</div><div id="md_transport_fee" class="tot-val">₱0.00</div></div>
                <div class="tot-row total"><div>Total</div><div id="md_total" class="tot-val">₱1,000.00</div></div>
              </div>
            </div>

            <div class="modal-section photos-section">
              <div class="photos-grid">
                <div class="photo-col">
                  <div class="photo-label">Before</div>
                  <div class="photo-box"><input type="text" readonly value="images.png"></div>
                </div>
                <div class="photo-col">
                  <div class="photo-label">After</div>
                  <div class="photo-box"><input type="text" readonly value="images.png"></div>
                </div>
              </div>
            </div>

            <div id="md_cancel_details" class="cancel-details" style="display:none; margin-top:12px">
              <div class="cancel-title">Cancellation Details</div>
              <div class="cancel-row"><div class="cancel-label">Date:</div><div id="cd_date">—</div></div>
              <div class="cancel-row"><div class="cancel-label">Time:</div><div id="cd_time">—</div></div>
              <div class="cancel-row"><div class="cancel-label">Reason:</div><div id="cd_reason">—</div></div>
              <div class="cancel-row"><div class="cancel-label">Description:</div><div id="cd_description">—</div></div>
            </div>

            <!-- Return details (shown when status === 'return') -->
            <div id="md_return_details" class="cancel-details" style="display:none; margin-top:12px">
              <div class="cancel-title">Return Reason</div>
              <div class="cancel-row"><div class="cancel-label">Date:</div><div id="rr_date">—</div></div>
              <div class="cancel-row"><div class="cancel-label">Time:</div><div id="rr_time">—</div></div>
              <div class="cancel-row"><div class="cancel-label">Reason:</div><div id="rr_reason">—</div></div>
              <div class="cancel-row"><div class="cancel-label">Description:</div><div id="rr_description">—</div></div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

    <script>
      document.addEventListener('DOMContentLoaded', function(){
        try{
          console.debug('manage_booking script start (DOM ready)');
          const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });
<<<<<<< Updated upstream
=======

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

    // Booking row action: open modal and populate details based on status
    (function(){
      console.debug('init booking modal handlers');
      function parseDateTime(text){
        // attempt to separate date and time if possible
        if(!text) return {date: '', time: ''};
        const m = text.match(/(\d{4}-\d{2}-\d{2})\s*(\d{1,2}:\d{2})?/);
        if(m) return {date: m[1] || text, time: m[2] || ''};
        return {date: text, time: ''};
      }

      const modal = document.getElementById('bookingModal');
      const closeBtn = document.getElementById('bookingModalClose');

      function openBookingModal(row){
        // populate fields from row cells
        const id = row.cells[0].textContent.trim();
        const client = row.cells[1].textContent.trim();
        const provider = row.cells[2].textContent.trim();
        const service = row.cells[3].textContent.trim();
        const dt = row.cells[4].textContent.trim();
        const stCell = row.querySelector('.status');
        const statusClasses = stCell ? Array.from(stCell.classList) : [];
        let status = 'pending';
        if(statusClasses.includes('complete') || statusClasses.includes('completed')) status = 'complete';
        else if(statusClasses.includes('ongoing')) status = 'ongoing';
        else if(statusClasses.includes('cancelled')) status = 'cancelled';

        document.getElementById('md_provider').textContent = provider;
        document.getElementById('md_client').textContent = client;
        document.getElementById('md_service').textContent = service;
        const parsed = parseDateTime(dt);
        document.getElementById('md_date').textContent = parsed.date;
        document.getElementById('md_time').textContent = parsed.time;
        document.getElementById('md_address').textContent = 'B1 L50 Mango st. Phase 1 Saint Joseph Village 10 Barangay Langgam, City of San Pedro, Laguna 4023';
        document.getElementById('md_selected').textContent = 'Bungalow 80–150 sqm — Basic Cleaning – 1 Cleaner';
        document.getElementById('md_inclusions').textContent = 'Living Room: walls, mop, dusting furniture, trash removal; Bedrooms: bed making, sweeping; Hallways: mop & sweep, remove cobwebs; Windows & Mirrors: quick wipe';
        // notes
        const notesEl = document.getElementById('md_notes'); if(notesEl) notesEl.value = '—';
        // totals (demo values) — compute numeric total from displayed rows
        (function updateTotalsDisplay(){
          function parseCurrency(text){
            if(!text) return 0;
            // remove currency symbol and thousands separators
            const cleaned = text.replace(/[^0-9.\-]/g,'');
            const n = parseFloat(cleaned);
            return isNaN(n) ? 0 : n;
          }
          function formatCurrency(n){
            return '₱' + n.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2});
          }

          const subEl = document.getElementById('md_subtotal');
          const voucherEl = document.getElementById('md_voucher_discount');
          const transportEl = document.getElementById('md_transport_fee');
          const totalEl = document.getElementById('md_total');

          const subtotal = subEl ? parseCurrency(subEl.textContent) : 0;
          const voucher = voucherEl ? parseCurrency(voucherEl.textContent) : 0;
          const transport = transportEl ? parseCurrency(transportEl.textContent) : 0;

          const computed = subtotal - voucher + transport;
          if(totalEl) totalEl.textContent = formatCurrency(computed);
        })();
        // uploaded photos (demo)
        const photoInputs = modal.querySelectorAll('.photo-box input');
        if(photoInputs && photoInputs.length >= 2){ photoInputs[0].value = 'images.png'; photoInputs[1].value = 'images.png'; }

        // status-specific UI
        const badgeBox = document.getElementById('md_status_badge');
        badgeBox.innerHTML = '';
        document.getElementById('md_cancel_details').style.display = 'none';
        // ensure return details hidden by default
        const returnDetailsEl = document.getElementById('md_return_details');
        if (returnDetailsEl) returnDetailsEl.style.display = 'none';
        if(status === 'complete'){
          badgeBox.innerHTML = '<span class="status-pill status-complete">Completed</span>';
        } else if(status === 'ongoing'){
          badgeBox.innerHTML = '<span class="status-pill status-ongoing">Ongoing</span>';
        } else if(status === 'cancelled'){
          badgeBox.innerHTML = '<span class="status-pill status-cancelled">Cancelled</span>';
          // show cancellation details area (demo values)
          document.getElementById('md_cancel_details').style.display = 'block';
          document.getElementById('cd_date').textContent = 'Date: 2025-05-22';
          document.getElementById('cd_time').textContent = 'Time: 8:00 AM';
          document.getElementById('cd_reason').textContent = 'Reason: Change of Schedule';
          document.getElementById('cd_description').textContent = 'Description: sorry po, mamali ako schedule';
        } else if (status === 'return') {
          badgeBox.innerHTML = '<span class="status-pill status-cancelled">Return</span>';
          // show return details area (demo values)
          const ret = document.getElementById('md_return_details');
          if (ret) ret.style.display = 'block';
          const rr_date = document.getElementById('rr_date'); if (rr_date) rr_date.textContent = 'May 22, 2025';
          const rr_time = document.getElementById('rr_time'); if (rr_time) rr_time.textContent = '8:00 AM';
          const rr_reason = document.getElementById('rr_reason'); if (rr_reason) rr_reason.textContent = 'Unsatisfactory Service';
          const rr_description = document.getElementById('rr_description'); if (rr_description) rr_description.textContent = 'The quality of the service did not meet the expected standards or description.';
        } else {
          badgeBox.innerHTML = '<span class="status-pill status-pending">Pending</span>';
        }

        modal.classList.add('show'); modal.setAttribute('aria-hidden','false');
        modal._targetRow = row;
      }

      function closeBookingModal(){ modal.classList.remove('show'); modal.setAttribute('aria-hidden','true'); modal._targetRow = null; }

      // attach click to arrow cells using event delegation (more robust)
      try{
        const tbody = document.querySelector('.table-container tbody');
        if(tbody){
          tbody.addEventListener('click', function(e){
            try {
              // Defensive handling: clicks may land on text nodes, which don't have .closest
              let el = e.target;
              if (el && el.nodeType === 3) el = el.parentElement; // TEXT_NODE -> use parent Element
              const arrow = el && el.closest ? el.closest('.arrow') : null;
              console.debug('tbody click', { target: e.target, arrow });
              if(!arrow) return;
              const tr = arrow.closest('tr'); if(!tr) return;
              console.debug('opening modal for row', tr);
              openBookingModal(tr);
            } catch(err) {
              console.error('Error in tbody click handler', err);
            }
          });
          // make arrows show pointer when hovered
          tbody.querySelectorAll('.arrow').forEach(a=>a.style.cursor='pointer');
        } else {
          console.warn('manage_booking: tbody not found for delegation');
        }
      } catch(err){ console.error('Error initializing booking modal handlers', err); }

      // modal close handlers
      if(closeBtn) closeBtn.addEventListener('click', closeBookingModal);
      if(modal) modal.addEventListener('click', function(e){ if(e.target === this) closeBookingModal(); });
    })();

    // Date filter: encapsulated initializer for date range filtering
    (function initDateFilter(){
      const filterBtn = document.querySelector('.filter-btn');
      const dropdownContent = filterBtn && (filterBtn.parentElement && filterBtn.parentElement.querySelector('.dropdown-content')) || document.querySelector('.dropdown-content');
      if (!dropdownContent) return;
      
      const fromInput = dropdownContent.querySelector('#from-date');
      const toInput = dropdownContent.querySelector('#to-date');
      const applyBtn = dropdownContent.querySelector('.apply-btn');

      function parseRowDate(text){
        if (!text) return null;
        const m = text.match(/(\d{4})\D(\d{2})\D(\d{2})(?:[^\d]*(\d{2}):?(\d{2}))?/);
        if (m) {
          const y = m[1], mo = m[2], d = m[3];
          const hh = m[4] || '00', mm = m[5] || '00';
          const iso = `${y}-${mo}-${d}T${hh}:${mm}:00`;
          const dt = new Date(iso);
          if (!isNaN(dt.getTime())) return dt;
        }
        const p = Date.parse(text);
        if (!isNaN(p)) return new Date(p);
        return null;
      }

      function applyDateFilter(){
        const fromVal = fromInput ? fromInput.value : '';
        const toVal = toInput ? toInput.value : '';
        const fromDate = fromVal ? new Date(fromVal) : null;
        const toDateRaw = toVal ? new Date(toVal) : null;
        const toDate = toDateRaw ? new Date(toDateRaw.getTime() + 86399999) : null;

        const rows = document.querySelectorAll('.table-container tbody tr');
        let matched = 0;
        rows.forEach(row => {
          const dateCell = row.querySelector('td:nth-child(5)');
          const rowDate = parseRowDate(dateCell ? dateCell.textContent.trim() : '');
          if (!rowDate) { row.dataset.filterHidden = ''; return; }
          const within = (!fromDate || rowDate >= fromDate) && (!toDate || rowDate <= toDate);
          row.dataset.filterHidden = within ? '' : 'true';
          if (within) matched++;
          if (typeof window.updateBookingRowVisibility === 'function') window.updateBookingRowVisibility(row);
        });
        console.debug('applyDateFilter', { fromVal, toVal, matched, total: rows.length });
      }

      if (applyBtn && fromInput && toInput) {
        applyBtn.addEventListener('click', (e) => {
          e.preventDefault();
          applyDateFilter();
          if (dropdownContent) dropdownContent.classList.remove('show');
          if (filterBtn) { filterBtn.innerHTML = '<i class="fa-solid fa-sliders"></i> Filter ▼'; filterBtn.setAttribute('aria-expanded','false'); }
        });
        fromInput.addEventListener('change', applyDateFilter);
        toInput.addEventListener('change', applyDateFilter);
      }

      // Initialize
      applyDateFilter();
    })();

    // Helper: combine tab, filter and search hidden flags to set final visibility
    window.updateBookingRowVisibility = function(row){
      try {
        const tabHidden = row.dataset.tabHidden === 'true';
        const filterHidden = row.dataset.filterHidden === 'true';
        const searchHidden = row.dataset.searchHidden === 'true';
        row.style.display = (tabHidden || filterHidden || searchHidden) ? 'none' : '';
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

    }
    catch(err){ console.error('manage_booking top-level error', err); }
    });
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
  </script>
</body>
</html>



