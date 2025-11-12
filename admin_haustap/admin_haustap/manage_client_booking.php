<?php require_once __DIR__ . '/includes/auth.php'; ?>
<?php
// Load client data from storage by id
$client = null;
$clientId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$storePath = realpath(__DIR__ . '/../../storage/data/clients.json');
if ($storePath && is_file($storePath)) {
  $raw = @file_get_contents($storePath);
  $items = json_decode($raw ?: '[]', true);
  if (is_array($items)) {
    foreach ($items as $it) {
      if (isset($it['id']) && (int)$it['id'] === $clientId) { $client = $it; break; }
    }
  }
}
if (!$client) {
  $client = [ 'id' => $clientId ?: 0, 'name' => 'Unknown', 'status' => isset($_GET['status']) ? $_GET['status'] : 'active' ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Manage Clients</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/manage_client_booking.css">
<script src="js/lazy-images.js" defer></script></head>
<body>
  <div class="dashboard-container">
  <!-- Sidebar -->
  <?php $active = 'clients_booking'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Manage of Client &gt; <?php echo htmlspecialchars($client['name']); ?></h3>
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
        <button class="active" data-target="manage_client_booking.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Bookings</button>
        <button data-target="manage_client_activity.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Activity</button>
        <button data-target="manage_client_voucher.php?id=<?php echo $cid; ?>&status=<?php echo $cstatus; ?>">Voucher</button>
      </div>

      <!-- Search and Filter -->
      <div class="search-filter">
        <input id="serviceSearch" type="text" placeholder="Search Services" aria-label="Search services">

        <div class="filter-dropdown">
<div class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</div>
          <div class="dropdown-content">
            <p class="filter-title">Filter by Status</p>
            <label><input type="checkbox" value="pending"> Pending</label>
            <label><input type="checkbox" value="ongoing"> Ongoing</label>
            <label><input type="checkbox" value="completed"> Completed</label>
            <label><input type="checkbox" value="cancelled"> Cancelled</label>
            <label><input type="checkbox" value="return"> Return</label>
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
            <tr>
              <td>1</td>
              <td>Ana Santos</td>
              <td>Home Cleaning</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status completed">Completed</span></td>
              <td><button class="open-details" data-id="1" aria-label="Open booking details">›</button></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Ana Santos</td>
              <td>Plumbing</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status cancelled">Cancelled</span></td>
              <td><button class="open-details" data-id="2" aria-label="Open booking details">›</button></td>
            </tr>
            <tr>
              <td>3</td>
              <td>Ana Santos</td>
              <td>Plumbing</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status pending">Pending</span></td>
              <td><button class="open-details" data-id="3" aria-label="Open booking details">›</button></td>
            </tr>
            <tr>
              <td>4</td>
              <td>Ana Santos</td>
              <td>Plumbing</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status ongoing">Ongoing</span></td>
              <td><button class="open-details" data-id="4" aria-label="Open booking details">›</button></td>
            </tr>
            <tr>
              <td>5</td>
              <td>Ana Santos</td>
              <td>Plumbing</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status return">Return</span></td>
              <td><button class="open-details" data-id="5" aria-label="Open booking details">›</button></td>
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

  <!-- Booking details modal -->
  <div id="bookingModal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="bookingModalTitle">
    <div class="modal-dialog">
  <button class="modal-close" aria-label="Close details">Close</button>
      <div class="modal-header">
        <span class="modal-status" aria-hidden="true"></span>
        <h2 id="bookingModalTitle" class="modal-title">Booking Details</h2>
      </div>
      <div class="modal-body">
        <div class="modal-row"><strong>Booking ID:</strong> <span class="modal-booking-id"></span></div>
        <div class="modal-row"><strong>Service Provider:</strong> <span class="modal-provider"></span></div>
        <div class="modal-row"><strong>Service:</strong> <span class="modal-service"></span></div>
        <div class="modal-row"><strong>Date & Time:</strong> <span class="modal-datetime"></span></div>
        <div class="modal-row"><strong>Total:</strong> ₱<span class="modal-total"></span></div>
        <div class="modal-row"><strong>Status:</strong> <span class="modal-status-text"></span></div>
        <div class="modal-row notes"><strong>Notes:</strong>
          <div class="modal-notes">No notes available.</div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- Footer kept for spacing; primary close is the header button -->
      </div>
    </div>
    <div class="modal-backdrop"></div>
  </div>

  <style>
    /* Modal styles (scoped minimal) */
    .modal { display:none; position:fixed; inset:0; z-index:1200; align-items:center; justify-content:center; }
    .modal.show { display:flex; }
    .modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,0.35); }
    .modal-dialog { position:relative; background:#fff; border-radius:6px; padding:20px; width:720px; max-width:95%; box-shadow:0 10px 30px rgba(0,0,0,0.2); z-index:1; }
  .modal-close { position:absolute; right:12px; top:8px; background:transparent; border:0; font-size:14px; cursor:pointer; color:#333; padding:6px 8px; }
    .modal-header { display:flex; gap:12px; align-items:center; margin-bottom:8px; }
    .modal-status { display:inline-block; padding:6px 10px; border-radius:18px; font-weight:600; font-size:13px; }
    .modal-status.completed { background:#e6ffef; color:#0b7a3d; border:1px solid #b7f0cf; }
    .modal-status.ongoing { background:#f0f7ff; color:#0b63ff; border:1px solid #bcd9ff; }
    .modal-status.pending { background:#fff7e6; color:#b36b00; border:1px solid #ffe2a8; }
    .modal-status.cancelled { background:#fff0f0; color:#b30000; border:1px solid #ffc1c1; }
    .modal-status.return { background:#fffaf0; color:#b36b00; border:1px solid #ffeccf; }
    .modal-title { margin:0; font-size:18px; }
    .modal-body { margin-top:8px; max-height:60vh; overflow:auto; }
    .modal-row { margin:8px 0; }
    .modal-notes { margin-top:6px; padding:8px; background:#f8f8f8; border-radius:4px; }
    .modal-footer { display:flex; justify-content:flex-end; gap:8px; margin-top:12px; }
    .btn { padding:8px 12px; border-radius:4px; border:1px solid #ccc; background:#fff; cursor:pointer; }
    .btn.btn-secondary { background:#f3f3f3; }
    .open-details { background:transparent; border:0; font-size:20px; cursor:pointer; padding:6px 10px; }
  </style>

  <script>
    (function(){
      // User dropdown (defensive)
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

      // Filter dropdown toggle (defensive)
      const filterBtn = document.querySelector('.filter-btn');
      const dropdownContent = document.querySelector('.dropdown-content');
      if (filterBtn && dropdownContent) {
        filterBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          dropdownContent.classList.toggle('show');
        });
        // Close dropdown when clicking outside of it (but not when interacting with its controls)
        window.addEventListener('click', (ev) => {
          if (!dropdownContent.contains(ev.target) && !filterBtn.contains(ev.target)) {
            dropdownContent.classList.remove('show');
          }
        });
      }

      // Status filter: show rows matching selected statuses
      if (dropdownContent) {
        const checkboxes = dropdownContent.querySelectorAll('input[type="checkbox"]');
        const applyBtn = dropdownContent.querySelector('.apply-btn');

        function rowStatus(badge){
          if (!badge) return '';
          const cls = badge.classList;
          if (cls.contains('completed')) return 'completed';
          if (cls.contains('complete')) return 'complete';
          if (cls.contains('ongoing')) return 'ongoing';
          if (cls.contains('pending')) return 'pending';
          if (cls.contains('cancelled')) return 'cancelled';
          if (cls.contains('return')) return 'return';
          return '';
        }

        function updateRowVisibility(row){
          try{
            const filterHidden = row.dataset.filterHidden === 'true';
            const searchHidden = row.dataset.searchHidden === 'true';
            row.style.display = (filterHidden || searchHidden) ? 'none' : '';
          } catch(err) { row.style.display = ''; }
        }

        function applyFilter(){
          const selected = new Set(Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value));
          const rows = document.querySelectorAll('.table-container tbody tr');
          rows.forEach(row => {
            const badge = row.querySelector('.status');
            const s = rowStatus(badge);
            const visibleByFilter = (selected.size === 0 || selected.has(s));
            row.dataset.filterHidden = visibleByFilter ? '' : 'true';
            updateRowVisibility(row);
          });
        }

        // Do not auto-apply on checkbox change; wait for user to click Apply
        checkboxes.forEach(cb => cb.addEventListener('change', () => { /* noop until Apply is clicked */ }));
        if (applyBtn) applyBtn.addEventListener('click', (e) => {
          e.preventDefault();
          applyFilter();
          // close dropdown after applying
          dropdownContent.classList.remove('show');
        });
      }

      // Tabs navigation (defensive)
      (function(){
        const tabs = document.querySelector('.tabs');
        if (!tabs) return;
        const btns = Array.from(tabs.querySelectorAll('button'));
        btns.forEach(btn => btn.addEventListener('click', () => {
          const target = btn.getAttribute('data-target');
          if (target) { try { window.location.href = target; } catch(e) { console.error('Navigation failed', e); } }
          else { btns.forEach(b=>b.classList.remove('active')); btn.classList.add('active'); }
        }));
      })();

      // Service-only search (filters Services column only)
      (function(){
        const input = document.getElementById('serviceSearch');
        const tbody = document.querySelector('.table-container tbody');
        if (!input || !tbody) return;
        const rows = Array.from(tbody.querySelectorAll('tr'));
        function normalize(s){ return (s||'').toString().replace(/\s+/g,' ').trim().toLowerCase(); }

        function applyServiceSearch(q){
          const text = normalize(q);
          rows.forEach(r => {
            const cell = r.querySelector('td:nth-child(3)');
            const val = normalize(cell ? cell.textContent : '');
            r.dataset.searchHidden = (!text || val.indexOf(text) !== -1) ? '' : 'true';
            // combine with filter-hidden flag if present
            const filterHidden = r.dataset.filterHidden === 'true';
            r.style.display = (r.dataset.searchHidden === 'true' || filterHidden) ? 'none' : '';
          });
        }

        let timer = null;
        input.addEventListener('input', function(e){ clearTimeout(timer); timer = setTimeout(() => applyServiceSearch(e.target.value), 150); });
        input.addEventListener('keydown', function(e){ if (e.key === 'Escape'){ input.value = ''; applyServiceSearch(''); } });
      })();

      // Booking details modal wiring
      const modal = document.getElementById('bookingModal');
      const modalDialog = modal && modal.querySelector('.modal-dialog');
      const modalBackdrop = modal && modal.querySelector('.modal-backdrop');
      const modalCloseBtns = modal && modal.querySelectorAll('.modal-close');
      const modalFields = {
        id: modal && modal.querySelector('.modal-booking-id'),
        provider: modal && modal.querySelector('.modal-provider'),
        service: modal && modal.querySelector('.modal-service'),
        datetime: modal && modal.querySelector('.modal-datetime'),
        total: modal && modal.querySelector('.modal-total'),
        statusBadge: modal && modal.querySelector('.modal-status'),
        statusText: modal && modal.querySelector('.modal-status-text'),
        notes: modal && modal.querySelector('.modal-notes')
      };

      function showModal() { if (!modal) return; modal.setAttribute('aria-hidden', 'false'); modal.classList.add('show'); document.body.style.overflow = 'hidden'; }
      function hideModal() { if (!modal) return; modal.setAttribute('aria-hidden', 'true'); modal.classList.remove('show'); document.body.style.overflow = ''; }

      // Attach to buttons
      const detailBtns = Array.from(document.querySelectorAll('.open-details'));
      detailBtns.forEach(btn => btn.addEventListener('click', function(e){
        e.preventDefault();
        const row = btn.closest('tr'); if (!row) return;
        const cells = row.querySelectorAll('td');
        const bookingId = (cells[0] && cells[0].textContent || '').trim();
        const provider = (cells[1] && cells[1].textContent || '').trim();
        const service = (cells[2] && cells[2].textContent || '').trim();
        const datetime = (cells[3] && cells[3].textContent || '').trim();
        const total = (cells[4] && cells[4].textContent || '').trim();
        const statusEl = row.querySelector('.status');
        const statusText = statusEl ? statusEl.textContent.trim() : '';

        if (modalFields.id) modalFields.id.textContent = bookingId;
        if (modalFields.provider) modalFields.provider.textContent = provider;
        if (modalFields.service) modalFields.service.textContent = service;
        if (modalFields.datetime) modalFields.datetime.textContent = datetime;
        if (modalFields.total) modalFields.total.textContent = total.replace(/[^0-9.]/g, '');
        if (modalFields.statusText) modalFields.statusText.textContent = statusText;

        // status badge class
        if (modalFields.statusBadge) {
          modalFields.statusBadge.className = 'modal-status';
          const s = (statusText || '').toLowerCase();
          if (s.includes('complete')) modalFields.statusBadge.classList.add('completed');
          else if (s.includes('ongoing')) modalFields.statusBadge.classList.add('ongoing');
          else if (s.includes('pending')) modalFields.statusBadge.classList.add('pending');
          else if (s.includes('cancel')) modalFields.statusBadge.classList.add('cancelled');
          else if (s.includes('return')) modalFields.statusBadge.classList.add('return');
          modalFields.statusBadge.textContent = statusText;
        }

        // try to read notes if present (data-notes attr or hidden td)
        const notes = row.getAttribute('data-notes') || '';
        if (modalFields.notes) modalFields.notes.textContent = notes || 'No notes available.';

        showModal();
      }));

      // close handlers
      if (modalBackdrop) modalBackdrop.addEventListener('click', hideModal);
      modalCloseBtns && modalCloseBtns.forEach(b => b.addEventListener('click', hideModal));
      window.addEventListener('keydown', (ev) => { if (ev.key === 'Escape') hideModal(); });
    })();
  </script>

</body>
</html>


