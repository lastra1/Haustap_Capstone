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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Manage Clients</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/manage_client_booking.css">
  <style>
    /* Modal styles for job details popup */
    .job-modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,0.45);display:none;align-items:center;justify-content:center;z-index:1200}
    .job-modal{background:#fff;border-radius:8px;max-width:760px;width:92%;box-shadow:0 8px 30px rgba(0,0,0,0.2);overflow:hidden;font-family:inherit}
    .job-modal header{padding:18px 20px;color:#fff}
    .job-modal .body{padding:18px 20px}
    .job-modal .footer{padding:12px 20px;text-align:right;border-top:1px solid #eee}
    .job-modal .row{display:flex;gap:12px;align-items:center}
    .job-modal .col{flex:1}
    .job-modal .meta{font-size:14px;color:#444;margin-bottom:8px}
    .job-modal .status-badge{display:inline-block;padding:6px 10px;border-radius:14px;color:#fff;font-weight:600}
    .job-modal .status-completed{background:#2ecc71}
    .job-modal .status-ongoing{background:#3498db}
    .job-modal .status-pending{background:#95a5a6}
    .job-modal .status-cancelled{background:#e74c3c}
    .job-modal .status-return{background:#f1c40f;color:#111}
    .open-job-details{background:none;border:0;font-size:20px;cursor:pointer;padding:6px 10px}
    .job-modal .actions button{margin-left:8px;padding:8px 12px;border-radius:6px;border:0;cursor:pointer}
    .btn-primary{background:#2ecc71;color:#fff}
    .btn-danger{background:#e74c3c;color:#fff}
    .btn-default{background:#f0f0f0;color:#111}
  </style>
  <script src="js/lazy-images.js" defer></script>
</head>
<body>
  <div class="dashboard-container">
  <!-- Sidebar -->
  <?php $active = 'providers_jobs'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Manage of Provider &gt; <?php echo htmlspecialchars($provider['name']); ?></h3>
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
        <button class="active" data-target="manage_provider_jobs.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Jobs</button>
        <button data-target="manage_provider_activity.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Activity</button>
        <button data-target="manage_provider_voucher.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Voucher</button>
        <button data-target="manage_provider_subscription.php?id=<?php echo $pid; ?>&status=<?php echo $pstatus; ?>">Subscription</button>
      </div>

      <!-- Search and Filter -->
      <div class="search-filter">
        <input id="serviceSearch" type="text" placeholder="Search Services">

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
              <th>Client name</th>
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
              <td>
                <button class="open-job-details" 
                        data-booking="1" 
                        data-client="Ana Santos" 
                        data-service="Home Cleaning" 
                        data-datetime="2025 - 06 - 07 1:30" 
                        data-total="1,000" 
                        data-status="completed">›</button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Ana Santos</td>
              <td>Plumbing</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status cancelled">Cancelled</span></td>
              <td>
                <button class="open-job-details" 
                        data-booking="2" 
                        data-client="Ana Santos" 
                        data-service="Plumbing" 
                        data-datetime="2025 - 06 - 07 1:30" 
                        data-total="1,000" 
                        data-status="cancelled">›</button>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Ana Santos</td>
              <td>Plumbing</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status pending">Pending</span></td>
              <td>
                <button class="open-job-details" 
                        data-booking="3" 
                        data-client="Ana Santos" 
                        data-service="Plumbing" 
                        data-datetime="2025 - 06 - 07 1:30" 
                        data-total="1,000" 
                        data-status="pending">›</button>
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>Ana Santos</td>
              <td>Plumbing</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status ongoing">Ongoing</span></td>
              <td>
                <button class="open-job-details" 
                        data-booking="4" 
                        data-client="Ana Santos" 
                        data-service="Plumbing" 
                        data-datetime="2025 - 06 - 07 1:30" 
                        data-total="1,000" 
                        data-status="ongoing">›</button>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>Ana Santos</td>
              <td>Plumbing</td>
              <td>2025 - 06 - 07 1:30</td>
              <td>1,000</td>
              <td><span class="status return">Return</span></td>
              <td>
                <button class="open-job-details" 
                        data-booking="5" 
                        data-client="Ana Santos" 
                        data-service="Plumbing" 
                        data-datetime="2025 - 06 - 07 1:30" 
                        data-total="1,000" 
                        data-status="return">›</button>
              </td>
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

    <script>
    // User dropdown - defensive: only attach handlers if elements exist
    (function(){
      const dropdownBtn = document.getElementById("userDropdownBtn");
      const dropdown = document.getElementById("userDropdown");
      if (!dropdownBtn || !dropdown) return;
      dropdownBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        dropdown.classList.toggle("show");
      });
      window.addEventListener("click", (e) => {
        if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
      });
    })();

    // Filter dropdown toggle
    (function(){
      const filterBtn = document.querySelector('.filter-btn');
      const dropdownContent = document.querySelector('.dropdown-content');
      if (!filterBtn || !dropdownContent) return;
      filterBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownContent.classList.toggle('show');
      });
      window.addEventListener('click', () => {
        dropdownContent.classList.remove('show');
      });
    })();

    // Status filter + Search integration: use dataset flags and a shared visibility updater
    (function(){
      const dropdownContent = document.querySelector('.dropdown-content');
      if (!dropdownContent) return;
      const checkboxes = dropdownContent.querySelectorAll('input[type="checkbox"]');
      const applyBtn = dropdownContent.querySelector('.apply-btn');
      const searchInput = document.getElementById('serviceSearch');

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

      // Centralized visibility updater: respects both filter and search flags
      function updateRowVisibility(){
        const rows = document.querySelectorAll('.table-container tbody tr');
        rows.forEach(row => {
          const fHidden = row.dataset.filterHidden === 'true';
          const sHidden = row.dataset.searchHidden === 'true';
          row.style.display = (fHidden || sHidden) ? 'none' : '';
        });
      }

      function applyFilter(){
        const selected = new Set(Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value));
        const rows = document.querySelectorAll('.table-container tbody tr');
        rows.forEach(row => {
          const badge = row.querySelector('.status');
          const s = rowStatus(badge);
          row.dataset.filterHidden = (selected.size !== 0 && !selected.has(s)) ? 'true' : '';
        });
        updateRowVisibility();
      }

      checkboxes.forEach(cb => cb.addEventListener('change', () => { /* do not auto-apply; wait for Apply */ }));
      if (applyBtn) applyBtn.addEventListener('click', (e) => { e.preventDefault(); applyFilter(); dropdownContent.classList.remove('show'); });

      // Debounced search that filters the Services column (3rd cell)
      function debounce(fn, wait){ let t; return (...args) => { clearTimeout(t); t = setTimeout(()=>fn(...args), wait); }; }

      function applySearch(query){
        const q = (query||'').trim().toLowerCase();
        const rows = document.querySelectorAll('.table-container tbody tr');
        rows.forEach(row => {
          const serviceTd = row.querySelector('td:nth-child(3)');
          const text = (serviceTd && serviceTd.textContent || '').toLowerCase();
          row.dataset.searchHidden = (q !== '' && !text.includes(q)) ? 'true' : '';
        });
        updateRowVisibility();
      }

      if (searchInput){
        const debounced = debounce((e) => applySearch(e.target.value), 250);
        searchInput.addEventListener('input', debounced);
      }

      // Initialize visibility (no filters/search applied)
      updateRowVisibility();
    })();

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
  </script>

  <!-- Job details modal -->
  <div class="job-modal-backdrop" id="jobModalBackdrop">
    <div class="job-modal" role="dialog" aria-modal="true" aria-labelledby="jobModalTitle">
      <header id="jobModalHeader">
        <div style="display:flex;justify-content:space-between;align-items:center">
          <h3 id="jobModalTitle" style="margin:0;font-size:18px;color:inherit">Booking Details</h3>
          <div style="display:flex;gap:8px;align-items:center">
            <span id="jobStatusBadge" class="status-badge">Status</span>
            <button id="jobModalClose" aria-label="Close" style="background:transparent;border:0;color:#fff;font-size:18px;cursor:pointer">✕</button>
          </div>
        </div>
      </header>
      <div class="body">
        <div class="meta-row">
          <p class="meta"><strong>Booking ID:</strong> <span id="mdBookingId"></span></p>
          <p class="meta"><strong>Client:</strong> <span id="mdClient"></span></p>
          <p class="meta"><strong>Service:</strong> <span id="mdService"></span></p>
          <p class="meta"><strong>Date &amp; Time:</strong> <span id="mdDatetime"></span></p>
          <p class="meta"><strong>Total:</strong> ₱<span id="mdTotal"></span></p>
        </div>

        <div id="mdUploadedPhotos" style="margin-top:12px;display:none">
          <p style="margin:6px 0;font-weight:600">Uploaded Photo</p>
          <div style="display:flex;gap:8px"><div style="width:120px;height:80px;background:#f5f5f5;border:1px solid #ddd;display:flex;align-items:center;justify-content:center;color:#888">image.png</div></div>
        </div>

        <div id="mdCancellationDetails" style="margin-top:12px;display:none">
          <p style="margin:6px 0;font-weight:600">Cancellation Details</p>
          <p id="mdCancelDate">Date: </p>
          <p id="mdCancelReason">Reason: </p>
          <p id="mdCancelDesc">Description: </p>
        </div>

        <div id="mdReturnReason" style="margin-top:12px;display:none">
          <p style="margin:6px 0;font-weight:600">Return Reason</p>
          <p id="mdReturnDate">Date: </p>
          <p id="mdReturnReasonText">Reason: </p>
          <p id="mdReturnDesc">Description: </p>
        </div>
      </div>
      <div class="footer">
        <div class="actions">
          <button id="mdRejectBtn" class="btn-default">Reject Return</button>
          <button id="mdApproveBtn" class="btn-primary">Approve Return</button>
          <button id="mdCloseBtn" class="btn-default">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function(){
      const buttons = document.querySelectorAll('.open-job-details');
      const backdrop = document.getElementById('jobModalBackdrop');
      const header = document.getElementById('jobModalHeader');
      const title = document.getElementById('jobModalTitle');
      const badge = document.getElementById('jobStatusBadge');
      const closeBtn = document.getElementById('jobModalClose');
      const mdClose = document.getElementById('mdCloseBtn');
      const mdApprove = document.getElementById('mdApproveBtn');
      const mdReject = document.getElementById('mdRejectBtn');

      function resetSections(){
        document.getElementById('mdUploadedPhotos').style.display='none';
        document.getElementById('mdCancellationDetails').style.display='none';
        document.getElementById('mdReturnReason').style.display='none';
        mdApprove.style.display = '';
        mdReject.style.display = '';
      }

      function openModalFromData(el){
        const booking = el.getAttribute('data-booking');
        const client = el.getAttribute('data-client');
        const service = el.getAttribute('data-service');
        const datetime = el.getAttribute('data-datetime');
        const total = el.getAttribute('data-total');
        const status = (el.getAttribute('data-status')||'').toLowerCase();

        document.getElementById('mdBookingId').textContent = booking;
        document.getElementById('mdClient').textContent = client;
        document.getElementById('mdService').textContent = service;
        document.getElementById('mdDatetime').textContent = datetime;
        document.getElementById('mdTotal').textContent = total;

        // Reset all dynamic sections
        resetSections();

        // Style header & badge by status
        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        badge.className = 'status-badge';
        header.style.background = '#95a5a6';
        if (status === 'completed') { header.style.background = '#2ecc71'; badge.classList.add('status-completed'); document.getElementById('mdUploadedPhotos').style.display='block'; mdApprove.style.display='none'; mdReject.style.display='none'; }
        else if (status === 'ongoing') { header.style.background = '#3498db'; badge.classList.add('status-ongoing'); mdApprove.style.display='none'; mdReject.style.display='none'; }
        else if (status === 'pending') { header.style.background = '#95a5a6'; badge.classList.add('status-pending'); mdApprove.style.display='none'; mdReject.style.display='none'; }
        else if (status === 'cancelled') { header.style.background = '#e74c3c'; badge.classList.add('status-cancelled'); document.getElementById('mdCancellationDetails').style.display='block'; mdApprove.style.display='none'; mdReject.style.display='none'; 
          document.getElementById('mdCancelDate').textContent = 'Date: 2025-06-07 10:00';
          document.getElementById('mdCancelReason').textContent = 'Reason: Change of schedule';
          document.getElementById('mdCancelDesc').textContent = 'Description: sorry po, cannot do schedule';
        }
        else if (status === 'return') { header.style.background = '#f1c40f'; badge.classList.add('status-return'); document.getElementById('mdReturnReason').style.display='block'; mdApprove.style.display='inline-block'; mdReject.style.display='inline-block'; 
          document.getElementById('mdReturnDate').textContent = 'Date: 2025-06-07 10:00';
          document.getElementById('mdReturnReasonText').textContent = 'Reason: Unsatisfactory Service';
          document.getElementById('mdReturnDesc').textContent = 'Description: The quality of the service did not meet the expected standards or description.';
        }

        backdrop.style.display = 'flex';
      }

      buttons.forEach(btn => btn.addEventListener('click', (e)=>{ e.stopPropagation(); openModalFromData(btn); }));

      function closeModal(){ backdrop.style.display = 'none'; }
      closeBtn.addEventListener('click', closeModal);
      mdClose.addEventListener('click', closeModal);
      backdrop.addEventListener('click', function(e){ if (e.target === backdrop) closeModal(); });
      window.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeModal(); });

      // Example handlers for approve/reject - replace with real actions
      mdApprove.addEventListener('click', function(){ alert('Approve action (replace with real handler)'); closeModal(); });
      mdReject.addEventListener('click', function(){ alert('Reject action (replace with real handler)'); closeModal(); });
    })();
  </script>

</body>
</html>



