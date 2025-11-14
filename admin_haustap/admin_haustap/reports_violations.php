<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reports & Violations</title>
  <link rel="stylesheet" href="css/manage_provider.css" />
  <link rel="stylesheet" href="css/reports_violations.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <?php $active = 'reports'; include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Topbar -->
      <header class="topbar">
        <h3>Reports & Violations</h3>
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button id="userDropdownBtn" class="user-dropdown-btn">Mj Punzalan ▼</button>
            <div class="user-dropdown" id="userDropdown">
              <a href="admin_profile.php">View Profile</a>
              <a href="change_password.php">Change Password</a>
<<<<<<< Updated upstream
              <a href="activity_logs.php">Activity Logs</a>
=======
>>>>>>> Stashed changes
              <a href="logout.php" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <section class="content-area">
        <div class="tabs-bar">
          <div class="tabs">
            <button class="tab active" data-target="all">All</button>
            <button class="tab" data-target="pending">Pending</button>
            <button class="tab" data-target="resolved">Resolved</button>
          </div>
        </div>

        <div class="controls">
          <div class="search-box">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
<<<<<<< Updated upstream
            <input type="text" id="reportSearch" placeholder="Search Provider" />
=======
            <input type="text" id="reportSearch" placeholder="Search Name" />
>>>>>>> Stashed changes
          </div>
          <div class="filter-box filter-dropdown">
            <button id="filterBtn" class="filter-btn" title="Filter"><i class="fa-solid fa-sliders"></i></button>
            <div id="filterPanel" class="filter-panel" role="dialog" aria-hidden="true">
              <div class="filter-row">
                <label for="filterStart">Start Date</label>
                <input id="filterStart" type="date" />
              </div>
              <div class="filter-row">
                <label for="filterEnd">End Date</label>
                <input id="filterEnd" type="date" />
              </div>
              <div class="filter-actions">
                <button id="filterReset" type="button" class="btn-reset">Reset</button>
                <button id="filterApply" type="button" class="btn-apply">Apply</button>
              </div>
            </div>
          </div>
        </div>

        <div class="table-panel">
          <div class="table-container">
          <table class="reports-table">
            <thead>
              <tr>
                <th style="width:60px">User ID</th>
                <th>Name</th>
                <th style="width:120px">Booking ID</th>
                <th style="width:140px">User-Type</th>
                <th>Category</th>
                <th style="width:120px">Date</th>
                <th style="width:80px">Time</th>
                <th style="width:120px">Status</th>
                <th style="width:60px"></th>
              </tr>
            </thead>
            <tbody id="reportsTbody">
              <tr data-status="resolved">
                <td>1</td>
                <td><strong>Jenn Bornilla</strong></td>
                <td>123</td>
                <td>Client</td>
                <td>No Priornotice</td>
                <td>2025-06-07</td>
                <td>8:00</td>
                <td><span class="status-pill status-resolved">Resolved</span></td>
                <td class="row-action-cell"><button class="row-action" aria-label="Open"><i class="fa-solid fa-chevron-right"></i></button></td>
              </tr>
              <tr data-status="pending">
                <td>2</td>
                <td><strong>Ana Santos</strong></td>
                <td>234</td>
                <td>Service Provider</td>
                <td>Last Minute Cancellation</td>
                <td>2025-06-07</td>
                <td>8:00</td>
                <td><span class="status-pill status-pending">Pending</span></td>
                <td class="row-action-cell"><button class="row-action" aria-label="Open"><i class="fa-solid fa-chevron-right"></i></button></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="9">
                  <div class="pagination">
                    <div class="pagination-left">[ ◀ Prev ]</div>
                    <div class="pagination-center">Showing 2–10 of 120 Reviews</div>
                    <div class="pagination-right">[ Next ▶ ]</div>
                  </div>
                </td>
              </tr>
            </tfoot>
          </table>
          </div>
        </div>

        <div class="summary-cards bottom-cards">
          <div class="card">
            <div class="label">Total Reports (This Month)</div>
            <div class="value">18</div>
          </div>
          <div class="card">
            <div class="label">Pending</div>
            <div class="value">5</div>
          </div>
          <div class="card">
            <div class="label">Resolved</div>
            <div class="value">11</div>
          </div>
          <div class="card highlight">
            <div class="label">Top Reason</div>
            <div class="value small">Poor Service Quality</div>
          </div>
        </div>
      
      <!-- Report Details Modal -->
      <div id="reportModal" class="modal-backdrop" role="dialog" aria-hidden="true">
        <div class="modal-card" role="document">
          <button class="modal-close" id="modalClose" aria-label="Close">&times;</button>
          <h3>Report Details</h3>
          <div class="modal-row"><span class="label">User ID:</span> <span id="modalUserId">—</span></div>
          <div class="modal-row"><span class="label">Booking ID:</span> <span id="modalBooking">—</span></div>
          <div class="modal-row"><span class="label">Name(Reported):</span> <span id="modalName">—</span></div>
          <div class="modal-row"><span class="label">User Type(Reported) :</span> <span id="modalUserType">—</span></div>
          <div class="modal-row"><span class="label">Category :</span> <span id="modalCategory">—</span></div>

          <div class="modal-actions">
            <button id="modalResolve" class="btn-resolve">Mark as Resolved</button>
            <button id="modalWarn" class="btn-warning">Send Warning</button>
          </div>
        </div>
      </div>
      </section>
    </main>
  </div>

  <script>
    // User dropdown (same behaviour as other admin pages)
    (function(){
      try {
        const dropdownBtn = document.getElementById("userDropdownBtn");
        const dropdown = document.getElementById("userDropdown");
        if (dropdownBtn && dropdown) {
          dropdownBtn.addEventListener("click", function(e){
            e.stopPropagation();
            dropdown.classList.toggle('show');
          });
          window.addEventListener('click', function(e){
            try { if (!dropdown.contains(e.target)) dropdown.classList.remove('show'); } catch(_){}
          });
        }
      } catch(err){ console.warn('user dropdown init failed', err); }
    })();

    // Tabs
    document.querySelectorAll('.tab').forEach(function(btn){
      btn.addEventListener('click', function(){
        document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
        btn.classList.add('active');
        applyFilters();
      });
    });

    // Simple client-side search
    document.getElementById('reportSearch').addEventListener('input', function(){
      applyFilters();
    });

    // Row action: open modal populated with row data
    (function(){
      function openModalForRow(row){
        const modal = document.getElementById('reportModal');
        document.getElementById('modalUserId').textContent = row.cells[0].textContent.trim();
        document.getElementById('modalBooking').textContent = row.cells[2].textContent.trim();
        document.getElementById('modalName').textContent = row.cells[1].textContent.trim();
        document.getElementById('modalUserType').textContent = row.cells[3].textContent.trim();
        document.getElementById('modalCategory').textContent = row.cells[4].textContent.trim();
        // If the row is already resolved, show a details-only modal (no actions)
        const modalCard = modal.querySelector('.modal-card');
        const statusCell = row.querySelector('.status-pill');
        const statusText = statusCell ? statusCell.textContent.trim().toLowerCase() : (row.dataset.status || '').toLowerCase();
        if(statusText === 'resolved'){
          modalCard.classList.add('no-actions');
        } else {
          modalCard.classList.remove('no-actions');
        }
        modal.classList.add('show'); modal.setAttribute('aria-hidden','false');
        // remember which row is active
        modal._targetRow = row;
      }

      function closeModal(){
        const modal = document.getElementById('reportModal');
        modal.classList.remove('show'); modal.setAttribute('aria-hidden','true');
        modal._targetRow = null;
      }

      // attach click handlers to existing row actions
      function initRowActions(){
        document.querySelectorAll('.row-action').forEach(function(btn){
          btn.removeEventListener('click', btn._handler);
          const handler = function(e){
            const tr = btn.closest('tr');
            if(!tr) return;
            openModalForRow(tr);
          };
          btn.addEventListener('click', handler);
          btn._handler = handler;
        });
      }

      // modal controls
      document.getElementById('modalClose').addEventListener('click', closeModal);
      document.getElementById('reportModal').addEventListener('click', function(e){ if(e.target === this) closeModal(); });

      document.getElementById('modalResolve').addEventListener('click', function(){
        const modal = document.getElementById('reportModal');
        const row = modal._targetRow;
        if(row){
          // update status pill text and class
          const statusCell = row.querySelector('.status-pill');
          if(statusCell){ statusCell.textContent = 'Resolved'; statusCell.className = 'status-pill status-resolved'; }
          // update dataset status so filtering uses the new state
          row.dataset.status = 'resolved';

          // switch active tab to 'resolved' so the list shows resolved items
          document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
          const resolvedTab = document.querySelector('.tab[data-target="resolved"]');
          if(resolvedTab) resolvedTab.classList.add('active');

          // re-apply filters so the row moves into the resolved view
          applyFilters();
        }
        closeModal();
      });

      document.getElementById('modalWarn').addEventListener('click', function(){
        const modal = document.getElementById('reportModal');
        const row = modal._targetRow;
        if(row){
          if(!row.classList.contains('warn-sent-row')) row.classList.add('warn-sent-row');
          alert('Warning sent to the provider.');
        }
        closeModal();
      });

      // initialize any row actions on page load
      initRowActions();
      // re-init when filters change (rows re-rendered/hidden) - safe to call repeatedly
      window.applyFilters = applyFilters; // ensure accessible
    })();

    // Filter dropdown toggle and behavior
    (function(){
      const filterBtn = document.getElementById('filterBtn');
      const filterPanel = document.getElementById('filterPanel');
      const filterApply = document.getElementById('filterApply');
      const filterReset = document.getElementById('filterReset');
      const filterStart = document.getElementById('filterStart');
      const filterEnd = document.getElementById('filterEnd');

      if(filterBtn && filterPanel){
        filterBtn.addEventListener('click', function(e){
          e.stopPropagation();
          filterPanel.classList.toggle('show');
          filterPanel.setAttribute('aria-hidden', filterPanel.classList.contains('show') ? 'false' : 'true');
        });
        window.addEventListener('click', function(e){ if(!filterPanel.contains(e.target) && e.target !== filterBtn){ filterPanel.classList.remove('show'); filterPanel.setAttribute('aria-hidden','true'); } });
      }

      // Apply: run filters and close
      if(filterApply){ filterApply.addEventListener('click', function(){ applyFilters(); filterPanel.classList.remove('show'); filterPanel.setAttribute('aria-hidden','true'); }); }
      // Reset: clear inputs and run filters
      if(filterReset){ filterReset.addEventListener('click', function(){ filterStart.value=''; filterEnd.value=''; applyFilters(); filterPanel.classList.remove('show'); filterPanel.setAttribute('aria-hidden','true'); }); }
    })();

    // Combined filter function: status (tabs) + search + date range
    function applyFilters(){
      const q = (document.getElementById('reportSearch').value || '').toLowerCase();
      const activeTab = document.querySelector('.tab.active');
      const statusTarget = activeTab ? activeTab.getAttribute('data-target') : 'all';
      const startVal = document.getElementById('filterStart').value;
      const endVal = document.getElementById('filterEnd').value;
      const start = startVal ? new Date(startVal) : null;
      const end = endVal ? new Date(endVal) : null;

      document.querySelectorAll('#reportsTbody tr').forEach(function(r){
        let show = true;
        // status/tab filter
        if(statusTarget && statusTarget !== 'all'){
          if(r.dataset.status !== statusTarget) show = false;
        }
        // search filter
        if(show && q){ if(r.textContent.toLowerCase().indexOf(q) === -1) show = false; }
        // date filter: date is in column index 5
        if(show && (start || end)){
          const dateText = (r.cells[5] && r.cells[5].textContent) ? r.cells[5].textContent.trim() : '';
          const rowDate = dateText ? new Date(dateText) : null;
          if(rowDate){
            // normalize times to date-only for comparison
            if(start){ start.setHours(0,0,0,0); }
            if(end){ end.setHours(23,59,59,999); }
            if(start && rowDate < start) show = false;
            if(end && rowDate > end) show = false;
          } else {
            // if no parsable date and a date filter exists, hide row
            show = false;
          }
        }
        r.style.display = show ? '' : 'none';
      });
    }
  </script>
</body>
</html>
