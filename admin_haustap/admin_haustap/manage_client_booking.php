
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/manage_client_booking.css">
  <style>
    /* Modal Styles */
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow-y: auto;
    }
    .modal-content {
      background: white;
      border-radius: 12px;
      padding: 30px;
      max-width: 600px;
      width: 90%;
      max-height: 85vh;
      overflow-y: auto;
      position: relative;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    .modal-close {
      position: absolute;
      top: 15px;
      right: 15px;
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #999;
    }
    .modal-close:hover {
      color: #333;
    }
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #f0f0f0;
    }
    .modal-header h3 {
      margin: 0;
      font-size: 16px;
      color: #333;
    }
    .status-badge {
      padding: 6px 14px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 12px;
    }
    .status-badge.completed {
      background: #b2f2bb;
      color: #037a0a;
    }
    .status-badge.ongoing {
      background: #a3d9ff;
      color: #003d99;
    }
    .status-badge.pending {
      background: #ffe0b2;
      color: #e65100;
    }
    .status-badge.cancelled {
      background: #ff6b6b;
      color: white;
    }
    .status-badge.return {
      background: #ffeb3b;
      color: #333;
    }
    .modal-body {
      font-size: 13px;
      line-height: 1.6;
      color: #444;
    }
    .modal-body p {
      margin: 8px 0;
    }
    .modal-body hr {
      margin: 15px 0;
      border: none;
      border-top: 1px solid #eee;
    }
    .modal-body h4 {
      margin: 15px 0 10px 0;
      font-size: 14px;
      color: #333;
    }
    .modal-totals {
      text-align: right;
      font-size: 14px;
      font-weight: 600;
    }
    .modal-totals p {
      margin: 6px 0;
    }
  </style>
<script src="js/lazy-images.js" defer></script></head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'clients'; include 'includes/sidebar.php'; ?>

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
        <button class="active" data-target="manage_client_booking.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Bookings</button>
        <button data-target="manage_client_voucher.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Voucher</button>
      </div>

      <!-- Search and Filter -->
      <div class="search-filter">
        <input type="text" placeholder="Search Services">

        <div class="filter-dropdown">
<div class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</div>
          <div class="dropdown-content">
            <p class="filter-title">Filter by Status</p>
            <label><input type="checkbox"> Pending</label>
            <label><input type="checkbox"> Ongoing</label>
            <label><input type="checkbox"> Completed</label>
            <label><input type="checkbox"> Cancelled</label>
            <label><input type="checkbox"> Return</label>
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
              <th>Provider name</th>
              <th>Services</th>
              <th>Date &amp; Time</th>
              <th>Total</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr data-booking-id="1" data-provider="Ana Santos" data-service="Home Cleaning" data-date="2025-06-07 1:30" data-total="1000" data-status="completed">
              <td>1</td><td>Ana Santos</td><td>Home Cleaning</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status completed">Completed</span></td><td class="row-action">›</td>
            </tr>
            <tr data-booking-id="2" data-provider="Ana Santos" data-service="Plumbing" data-date="2025-06-07 1:30" data-total="1000" data-status="cancelled">
              <td>2</td><td>Ana Santos</td><td>Plumbing</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status cancelled">Cancelled</span></td><td class="row-action">›</td>
            </tr>
            <tr data-booking-id="3" data-provider="Ana Santos" data-service="Plumbing" data-date="2025-06-07 1:30" data-total="1000" data-status="pending">
              <td>3</td><td>Ana Santos</td><td>Plumbing</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status pending">Pending</span></td><td class="row-action">›</td>
            </tr>
            <tr data-booking-id="4" data-provider="Ana Santos" data-service="Plumbing" data-date="2025-06-07 1:30" data-total="1000" data-status="ongoing">
              <td>4</td><td>Ana Santos</td><td>Plumbing</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status ongoing">Ongoing</span></td><td class="row-action">›</td>
            </tr>
            <tr data-booking-id="5" data-provider="Ana Santos" data-service="Plumbing" data-date="2025-06-07 1:30" data-total="1000" data-status="return">
              <td>5</td><td>Ana Santos</td><td>Plumbing</td><td>2025 - 06 - 07 1:30</td><td>1,000</td><td><span class="status return">Return</span></td><td class="row-action">›</td>
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

  <!-- Booking Details Modal -->
  <div id="bookingModal" class="modal" style="display:none;">
    <div class="modal-content">
      <button class="modal-close">✕</button>
      
      <!-- Completed Status -->
      <div id="modal-completed" class="modal-view" style="display:none;">
        <div class="modal-header">
          <h3>Service Provider: <span id="completed-provider"></span></h3>
          <span id="completed-status-badge" class="status-badge completed">Completed</span>
        </div>
        <div class="modal-body">
          <p><strong>Client:</strong> <span id="completed-client">John Bonillo</span></p>
          <p><strong>Service:</strong> <span id="completed-service"></span> - <span id="completed-service-desc">Bungalow - Basic Cleaning</span></p>
          <p><strong>Date:</strong> <span id="completed-date"></span></p>
          <p><strong>Time:</strong> 8:00 AM</p>
          <hr>
          <p><strong>Address:</strong> <span id="completed-address">B1 L50 Marigio II Phase 1 Sat Joseph Village 10 Barangay Languna, City of San Pedro, Laguna 4023</span></p>
          <hr>
          <h4>Service Details</h4>
          <p><strong>Bungalow: 80-150 sqm</strong></p>
          <p>Basic Cleaning - 1 Cleaner</p>
          <p><strong>Inclusives:</strong> Living Room walls, mop, dusting furniture, trash removal, Bedrooms: bed making, sweeping, dusting, trash removal, Hallways: mop & sweep, remove cobwebs, Windows & Mirrors: quick wipe</p>
          <hr>
          <p><strong>Notes:</strong></p>
          <textarea readonly style="width:100%;height:60px;"></textarea>
          <hr>
          <p><strong>⊕ No voucher added</strong></p>
          <hr>
          <div class="modal-totals">
            <p>Sub Total: <strong>₱1,000.00</strong></p>
            <p>Voucher Discount: <strong>₱0</strong></p>
            <p>Transportation Fee: <strong>₱50.00</strong></p>
            <p><strong>TOTAL: ₱1,050.00</strong></p>
          </div>
        </div>
      </div>

      <!-- Ongoing Status -->
      <div id="modal-ongoing" class="modal-view" style="display:none;">
        <div class="modal-header">
          <h3>Service Provider: <span id="ongoing-provider"></span></h3>
          <span id="ongoing-status-badge" class="status-badge ongoing">Ongoing</span>
        </div>
        <div class="modal-body">
          <p><strong>Client:</strong> <span id="ongoing-client">John Bonillo</span></p>
          <p><strong>Service:</strong> <span id="ongoing-service"></span> - <span id="ongoing-service-desc">Bungalow - Basic Cleaning</span></p>
          <p><strong>Date:</strong> <span id="ongoing-date"></span></p>
          <p><strong>Time:</strong> 8:00 AM</p>
          <hr>
          <p><strong>Address:</strong> <span id="ongoing-address">B1 L50 Marigio II Phase 1 Sat Joseph Village 10 Barangay Languna, City of San Pedro, Laguna 4023</span></p>
          <hr>
          <h4>Service Details</h4>
          <p><strong>Bungalow: 80-150 sqm</strong></p>
          <p>Basic Cleaning - 1 Cleaner</p>
          <p><strong>Inclusives:</strong> Living Room walls, mop, dusting furniture, trash removal, Bedrooms: bed making, sweeping, dusting, trash removal, Hallways: mop & sweep, remove cobwebs, Windows & Mirrors: quick wipe</p>
          <hr>
          <p><strong>Notes:</strong></p>
          <p><strong>⊕ No voucher added</strong></p>
          <hr>
          <div class="modal-totals">
            <p>Sub Total: <strong>₱1,000.00</strong></p>
            <p>Voucher Discount: <strong>₱0</strong></p>
            <p>Transportation Fee: <strong>₱50.00</strong></p>
            <p><strong>TOTAL: ₱1,050.00</strong></p>
          </div>
        </div>
      </div>

      <!-- Pending Status -->
      <div id="modal-pending" class="modal-view" style="display:none;">
        <div class="modal-header">
          <h3>Service Provider: <span id="pending-provider"></span></h3>
          <span id="pending-status-badge" class="status-badge pending">Pending</span>
        </div>
        <div class="modal-body">
          <p><strong>Client:</strong> <span id="pending-client">John Bonillo</span></p>
          <p><strong>Service:</strong> <span id="pending-service"></span> - <span id="pending-service-desc">Bungalow - Basic Cleaning</span></p>
          <p><strong>Date:</strong> <span id="pending-date"></span></p>
          <p><strong>Time:</strong> 8:00 AM</p>
          <hr>
          <p><strong>Address:</strong> <span id="pending-address">B1 L50 Marigio II Phase 1 Sat Joseph Village 10 Barangay Languna, City of San Pedro, Laguna 4023</span></p>
          <hr>
          <h4>Service Details</h4>
          <p><strong>Bungalow: 80-150 sqm</strong></p>
          <p>Basic Cleaning - 1 Cleaner</p>
          <p><strong>Inclusives:</strong> Living Room walls, mop, dusting furniture, trash removal, Bedrooms: bed making, sweeping, dusting, trash removal, Hallways: mop & sweep, remove cobwebs, Windows & Mirrors: quick wipe</p>
          <hr>
          <p><strong>Notes:</strong></p>
          <p><strong>⊕ No voucher added</strong></p>
          <hr>
          <div class="modal-totals">
            <p>Sub Total: <strong>₱1,000.00</strong></p>
            <p>Voucher Discount: <strong>₱0</strong></p>
            <p>Transportation Fee: <strong>₱50.00</strong></p>
            <p><strong>TOTAL: ₱1,050.00</strong></p>
          </div>
        </div>
      </div>

      <!-- Cancelled Status -->
      <div id="modal-cancelled" class="modal-view" style="display:none;">
        <div class="modal-header">
          <h3>Service Provider: <span id="cancelled-provider"></span></h3>
          <span id="cancelled-status-badge" class="status-badge cancelled">Cancelled</span>
        </div>
        <div class="modal-body">
          <p><strong>Client:</strong> <span id="cancelled-client">John Bonillo</span></p>
          <p><strong>Service:</strong> <span id="cancelled-service"></span> - <span id="cancelled-service-desc">Bungalow - Basic Cleaning</span></p>
          <p><strong>Date:</strong> <span id="cancelled-date"></span></p>
          <p><strong>Time:</strong> 8:00 AM</p>
          <hr>
          <p><strong>Address:</strong> <span id="cancelled-address">B1 L50 Marigio II Phase 1 Sat Joseph Village 10 Barangay Languna, City of San Pedro, Laguna 4023</span></p>
          <hr>
          <h4>Cancellation Details</h4>
          <p><strong>Date:</strong> <span id="cancelled-cancel-date">May 22, 2025</span></p>
          <p><strong>Time:</strong> 8:00 AM</p>
          <p><strong>Reason:</strong> <span id="cancelled-reason">Change of Schedule</span></p>
          <p><strong>Description:</strong> <span id="cancelled-description">sorry po, ramali ako ng schedule</span></p>
          <hr>
          <div class="modal-totals">
            <p>Sub Total: <strong>₱1,000.00</strong></p>
            <p>Voucher Discount: <strong>₱0</strong></p>
            <p>Transportation Fee: <strong>₱50.00</strong></p>
            <p><strong>TOTAL: ₱1,050.00</strong></p>
          </div>
        </div>
      </div>

      <!-- Return Status -->
      <div id="modal-return" class="modal-view" style="display:none;">
        <div class="modal-header">
          <h3>Service Provider: <span id="return-provider"></span></h3>
          <span id="return-status-badge" class="status-badge return">Return</span>
        </div>
        <div class="modal-body">
          <p><strong>Client:</strong> <span id="return-client">John Bonillo</span></p>
          <p><strong>Service:</strong> <span id="return-service"></span> - <span id="return-service-desc">Bungalow - Basic Cleaning</span></p>
          <p><strong>Date:</strong> <span id="return-date"></span></p>
          <p><strong>Time:</strong> 8:00 AM</p>
          <hr>
          <p><strong>Address:</strong> <span id="return-address">B1 L50 Marigio II Phase 1 Sat Joseph Village 10 Barangay Languna, City of San Pedro, Laguna 4023</span></p>
          <hr>
          <h4>Return Reason</h4>
          <p><strong>Date:</strong> <span id="return-return-date">May 22, 2025</span></p>
          <p><strong>Reason:</strong> <span id="return-reason">Unsatisfactory Service</span></p>
          <p><strong>Description:</strong> <span id="return-description">The quality of the service did not meet the expected standards or description.</span></p>
          <hr>
          <h4>Upload Photo</h4>
          <div style="border:2px dashed #ccc; padding:20px; text-align:center; border-radius:8px;">
            <button style="background:#f0f0f0; border:1px solid #ccc; padding:10px 15px; border-radius:4px; cursor:pointer;">⬇ Upload</button>
          </div>
          <hr>
          <div class="modal-totals">
            <p>Sub Total: <strong>₱1,000.00</strong></p>
            <p>Voucher Discount: <strong>₱0</strong></p>
            <p>Transportation Fee: <strong>₱50.00</strong></p>
            <p><strong>TOTAL: ₱1,050.00</strong></p>
          </div>
        </div>
      </div>

    </div>
  </div>

    <script>
    // Modal Management
    (function() {
      const modal = document.getElementById('bookingModal');
      const modalClose = document.querySelector('.modal-close');
      const rowActions = document.querySelectorAll('.row-action');

      // Open modal on row action button click
      rowActions.forEach(action => {
        action.addEventListener('click', function() {
          const row = this.closest('tr');
          const bookingData = {
            id: row.getAttribute('data-booking-id'),
            provider: row.getAttribute('data-provider'),
            service: row.getAttribute('data-service'),
            date: row.getAttribute('data-date'),
            total: row.getAttribute('data-total'),
            status: row.getAttribute('data-status')
          };
          
          openModal(bookingData);
        });
      });

      // Close modal on X button click
      if (modalClose) {
        modalClose.addEventListener('click', function() {
          modal.style.display = 'none';
        });
      }

      // Close modal on outside click
      modal.addEventListener('click', function(e) {
        if (e.target === modal) {
          modal.style.display = 'none';
        }
      });

      function openModal(data) {
        // Hide all modal views
        document.querySelectorAll('.modal-view').forEach(view => view.style.display = 'none');

        const status = data.status.toLowerCase();
        const viewId = `modal-${status}`;
        const view = document.getElementById(viewId);

        if (!view) {
          console.error('Modal view not found for status:', status);
          return;
        }

        // Populate status-specific data
        populateModalData(data, status);

        // Show the appropriate view
        view.style.display = 'block';
        modal.style.display = 'flex';
      }

      function populateModalData(data, status) {
        // Update provider name
        document.getElementById(`${status}-provider`).textContent = data.provider;
        
        // Update service
        document.getElementById(`${status}-service`).textContent = data.service;
        
        // Update date
        const dateDisplay = data.date.replace('-', ' - ').split(' ').slice(0, 3).join(' ');
        document.getElementById(`${status}-date`).textContent = dateDisplay;

        // For cancelled, also update cancel date
        if (status === 'cancelled') {
          document.getElementById('cancelled-cancel-date').textContent = dateDisplay;
        }

        // For return, also update return date
        if (status === 'return') {
          document.getElementById('return-return-date').textContent = dateDisplay;
        }
      }
    })();

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

    // Filter dropdown toggle + tabs with debug
    (function(){
      const filterBtn = document.querySelector('.filter-btn');
      const dropdownContent = document.querySelector('.dropdown-content');
      if (!filterBtn || !dropdownContent) return;

      function debugLog(msg){
        try{ console.log(msg); }catch(e){}
        const el = document.getElementById('debug-log');
        if (el) {
          const row = document.createElement('div');
          row.textContent = (new Date().toLocaleTimeString()) + ' — ' + msg;
          el.appendChild(row);
          el.scrollTop = el.scrollHeight;
        }
      }

      filterBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownContent.classList.toggle('show');
        debugLog('filterBtn clicked — dropdown ' + (dropdownContent.classList.contains('show') ? 'opened' : 'closed'));
      });
      window.addEventListener('click', () => {
        dropdownContent.classList.remove('show');
      });

      // Tabs navigation: navigate to pages specified in data-target
      (function(){
        const tabsContainer = document.querySelector('.tabs');
        if (!tabsContainer) return;
        const btns = Array.from(tabsContainer.querySelectorAll('button'));
        btns.forEach(btn => {
          btn.addEventListener('click', function(e){
            const target = btn.getAttribute('data-target');
            debugLog('tab clicked — target=' + (target || '(none)'));
            if (target) { try { window.location.href = target; } catch(err) { console.error('Navigation failed', err); debugLog('Navigation failed: '+err.message); } return; }
            btns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
          });
        });
      })();
    })();

    // Status filter: show rows matching selected statuses
    (function(){
      const dropdownContent = document.querySelector('.dropdown-content');
      if (!dropdownContent) return;
      const checkboxes = dropdownContent.querySelectorAll('input[type="checkbox"]');
      const applyBtn = dropdownContent.querySelector('.apply-btn');

      function rowStatus(badge){
        if (!badge) return '';
        const cls = badge.classList;
        if (cls.contains('completed')) { return 'completed'; }
        if (cls.contains('complete')) { return 'complete'; }
        if (cls.contains('ongoing')) { return 'ongoing'; }
        if (cls.contains('pending')) { return 'pending'; }
        if (cls.contains('cancelled')) { return 'cancelled'; }
        if (cls.contains('return')) { return 'return'; }
        return '';
      }

      function applyFilter(){
        const selected = new Set(Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value));
        const rows = document.querySelectorAll('.table-container tbody tr');
        rows.forEach(row => {
          const badge = row.querySelector('.status');
          const s = rowStatus(badge);
          const show = (selected.size === 0 || selected.has(s));
          row.style.display = show ? '' : 'none';
        });
      }

      checkboxes.forEach(cb => cb.addEventListener('change', applyFilter));
      if (applyBtn) applyBtn.addEventListener('click', (e) => { e.preventDefault(); applyFilter(); });
    })();
>>>>>>> Stashed changes
  </script>

</body>
</html>


