<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin | Manage Applicants</title>
  <link rel="stylesheet" href="css/manage_applicant.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<script src="js/lazy-images.js" defer></script>
<script src="js/app.js" defer></script>
<style>
  /* Filter dropdown styles (embedded so dev server shows immediately) */
  .search-filter { display:flex; gap:12px; align-items:center; }
  .search-filter .search-bar { padding:8px 12px; border-radius:6px; border:1px solid #ddd; min-width:240px; }
  @media (max-width:640px) { .search-filter { flex-direction:column; align-items:flex-start; } }
</style>
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'applicants'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
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

      <!-- Header -->
      <div class="page-header">
        <h3>Manage of Applicants</h3>
      </div>

      <!-- Applicant Tabs -->
      <div class="tabs">
        <button class="tab active">All</button>
        <button class="tab">Pending Review</button>
        <button class="tab">Scheduled</button>
        <button class="tab">Hired</button>
        <button class="tab">Rejected</button>
      </div>

      <!-- Table Section -->
      <div class="table-container">
        <div class="table-header">
          <input id="searchInput" type="text" placeholder="Search Applicant" class="search-bar" />
        </div>

        <table>
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Date Applied</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="applicantTableBody">
            <!-- Rows injected by JS -->
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
          <span id="prevPage" style="cursor:pointer">◀ Prev</span>
          <span id="paginationInfo">&nbsp;</span>
          <span id="nextPage" style="cursor:pointer">Next ▶</span>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Dropdown logic
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });

    // Tabs (highlight only; data loading handled in app.js)
    const tabs = document.querySelectorAll(".tab");
    tabs.forEach(tab => {
      tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");
      });
    });

    // Status filter removed: filtering now handled by overall search or app.js if needed

    // === Applicant row popup (open details when clicking the arrow) ===
    (function(){
      const tableBody = document.getElementById('applicantTableBody');
      if (!tableBody) return;

      // Create modal HTML inserted into DOM
      const modalHtml = `
      <div id="applicantModal" class="modal" style="display:none; position:fixed; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.35); z-index:999; justify-content:center; align-items:center;">
        <div class="modal-content" style="background:#fff; padding:20px; border-radius:8px; width:720px; max-width:95%;">
          <button id="applicantModalClose" style="float:right; background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
          <h3>Application Form</h3>
          <div style="display:flex; gap:16px; margin-top:12px;">
            <div style="flex:1">
              <p><strong>Id:</strong> <span id="modalAppId"></span></p>
              <p><strong>Last Name:</strong> <span id="modalLastName"></span></p>
              <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
              <p><strong>Email:</strong> <span id="modalEmail"></span></p>
              <p><strong>Mobile:</strong> <span id="modalMobile"></span></p>
            </div>
            <div style="flex:1">
              <p><strong>Date Applied:</strong> <span id="modalApplied"></span></p>
              <p><strong>House & Street:</strong> <span id="modalHouse"></span></p>
              <p><strong>Barangay:</strong> <span id="modalBarangay"></span></p>
              <p><strong>Municipal:</strong> <span id="modalMunicipal"></span></p>
              <p><strong>Province:</strong> <span id="modalProvince"></span></p>
            </div>
          </div>
          <div style="margin-top:12px; display:flex; align-items:center; gap:12px; justify-content:flex-end;">
            <label for="modalStatus">Update Status:</label>
            <select id="modalStatus">
              <option value="pending_review">Pending Review</option>
              <option value="scheduled">Scheduled</option>
              <option value="hired">Hired</option>
              <option value="rejected">Rejected</option>
            </select>
            <button id="modalUpdateBtn" style="background:#06b6d4;border:0;padding:8px 12px;border-radius:6px;color:#fff;cursor:pointer;">Update Status</button>
          </div>
        </div>
      </div>`;

      document.body.insertAdjacentHTML('beforeend', modalHtml);
      const modal = document.getElementById('applicantModal');
      const modalClose = document.getElementById('applicantModalClose');
      const modalAppId = document.getElementById('modalAppId');
  const modalFirstName = document.getElementById('modalFirstName');
  const modalLastName = document.getElementById('modalLastName');
  const modalEmail = document.getElementById('modalEmail');
      const modalMobile = document.getElementById('modalMobile');
      const modalApplied = document.getElementById('modalApplied');
      const modalHouse = document.getElementById('modalHouse');
      const modalBarangay = document.getElementById('modalBarangay');
      const modalMunicipal = document.getElementById('modalMunicipal');
      const modalProvince = document.getElementById('modalProvince');
      const modalStatus = document.getElementById('modalStatus');
      const modalUpdateBtn = document.getElementById('modalUpdateBtn');

      let currentRow = null;

      // Event delegation: open modal when clicking arrow cell
      tableBody.addEventListener('click', function(e){
        const td = e.target.closest('td');
        if (!td) return;
        if (!td.classList.contains('arrow')) return;
        const tr = td.closest('tr');
        if (!tr) return;
        currentRow = tr;
        // Extract basic fields (id, name, applied, status). Additional fields left blank unless your backend provides them.
        const cols = tr.querySelectorAll('td');
        const id = cols[0] ? cols[0].textContent.trim() : '';
        const name = cols[1] ? cols[1].textContent.trim() : '';
        const applied = cols[2] ? cols[2].textContent.trim() : '';
        const statusText = cols[3] ? cols[3].textContent.trim() : '';

        // Try splitting name into parts (best-effort)
  let first = name, last = '';
  const parts = name.split(' ');
  if (parts.length >= 2) { last = parts.pop(); first = parts.shift(); }

  modalAppId.textContent = id;
  modalFirstName.textContent = first;
  modalLastName.textContent = last;
        modalApplied.textContent = applied;
        modalEmail.textContent = '';
        modalMobile.textContent = '';
        modalHouse.textContent = '';
        modalBarangay.textContent = '';
        modalMunicipal.textContent = '';
        modalProvince.textContent = '';

        // Set select to current status if we can map it
        const mapLabelToValue = {
          'pending review': 'pending_review',
          'scheduled': 'scheduled',
          'hired': 'hired',
          'rejected': 'rejected'
        };
        const sKey = statusText.toLowerCase();
        const val = mapLabelToValue[sKey] || (sKey.replace(/\s+/g,'_')) || 'pending_review';
        modalStatus.value = val;

        // Show modal
        modal.style.display = 'flex';
      });

      function closeModal(){ modal.style.display = 'none'; currentRow = null; }
      modalClose.addEventListener('click', closeModal);
      modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

      // Update status: update UI cell in the current row. This is client-side only.
      modalUpdateBtn.addEventListener('click', function(){
        if (!currentRow) return;
        const newStatus = modalStatus.value;
        const statusCell = currentRow.querySelector('td:nth-child(4) .status');
        if (statusCell){
          // Update text and class
          const label = {
            pending_review: 'Pending Review',
            scheduled: 'Scheduled',
            hired: 'Hired',
            rejected: 'Rejected'
          }[newStatus] || newStatus;
          statusCell.textContent = label;
          statusCell.className = 'status ' + (newStatus === 'pending_review' ? 'pending' : newStatus);
        }
        // Close modal
        closeModal();
      });
    })();
  </script>
</body>
</html>


