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
              <a href="activity_logs.php">Activity Logs</a>
              <a href="logout.php" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <section class="content-area">
        <div class="summary-cards">
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

        <div class="controls">
          <div class="tabs">
            <button class="tab active" data-target="all">All</button>
            <button class="tab" data-target="pending">Pending</button>
            <button class="tab" data-target="in-review">In Review</button>
            <button class="tab" data-target="resolved">Resolved</button>
          </div>
          <div class="search-box">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            <input type="text" id="reportSearch" placeholder="Search reports..." />
          </div>
        </div>

        <div class="table-container">
          <table class="reports-table">
            <thead>
              <tr>
                <th>Report ID</th>
                <th>Booking / Client</th>
                <th>Provider</th>
                <th>Category</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="reportsTbody">
              <tr data-status="pending">
                <td>RPT-023</td>
                <td><strong>BK-10087</strong><div class="muted">Jenn B. — "Poor Service Quality"</div></td>
                <td>Ana Santos<br/><span class="muted">SP-112</span></td>
                <td>Poor Service</td>
                <td>2025-11-10</td>
                <td><span class="badge pending">Pending</span></td>
                <td><button class="btn review">Review</button> <button class="btn suspend danger">Suspend</button></td>
              </tr>
              <tr data-status="in-review">
                <td>RPT-019</td>
                <td><strong>BK-09902</strong><div class="muted">Mark D. — "No-show"</div></td>
                <td>Rizal Dela Cruz<br/><span class="muted">SP-087</span></td>
                <td>No-show</td>
                <td>2025-11-08</td>
                <td><span class="badge review">In Review</span></td>
                <td><button class="btn review">Review</button> <button class="btn suspend danger">Suspend</button></td>
              </tr>
              <tr data-status="resolved">
                <td>RPT-011</td>
                <td><strong>BK-08833</strong><div class="muted">Liza M. — "Misconduct"</div></td>
                <td>Jon Santos<br/><span class="muted">SP-042</span></td>
                <td>Misconduct</td>
                <td>2025-10-30</td>
                <td><span class="badge resolved">Resolved</span></td>
                <td><button class="btn view">View</button></td>
              </tr>
            </tbody>
          </table>
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
        var target = btn.getAttribute('data-target');
        var rows = document.querySelectorAll('#reportsTbody tr');
        rows.forEach(function(r){
          if(target === 'all') r.style.display = '';
          else r.style.display = (r.dataset.status === target) ? '' : 'none';
        });
      });
    });

    // Simple client-side search
    document.getElementById('reportSearch').addEventListener('input', function(){
      var q = this.value.toLowerCase();
      document.querySelectorAll('#reportsTbody tr').forEach(function(r){
        var text = r.textContent.toLowerCase();
        r.style.display = text.indexOf(q) !== -1 ? '' : 'none';
      });
    });
  </script>
</body>
</html>
