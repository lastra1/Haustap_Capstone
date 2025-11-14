<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Subscription Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/subscription_management.css" />
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="images/logo.png" alt="logo" />
        <span>Admin Dashboard</span>
      </div>
      <nav>
        <ul>
          <li>Dashboard Overview</li>
          <li>Manage Applicants</li>
          <li>Manage Clients</li>
          <li>Manage Providers</li>
          <li>Manage Bookings</li>
          <li>Job Status Monitor</li>
          <li>Analytics & Report</li>
          <li class="active">Subscription Management</li>
          <li>Feedback & Reviews</li>
          <li>System Settings</li>
        </ul>
      </nav>
    </aside>

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
              <a href="#">View Profile</a>
              <a href="#">Change Password</a>
              <a href="#">Activity Logs</a>
              <a href="#" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <!-- Search and Filter -->
      <div class="search-filter">
        <input type="text" placeholder="Search Services">
        <div class="filter-dropdown">
          <div class="filter-btn"><i class="fa fa-sliders"></i> Filter</div>
          <div class="dropdown-content">
            <p class="filter-title">Filter by Status</p>
            <label><input type="checkbox"> Active</label>
            <label><input type="checkbox"> Expired</label>
            <label><input type="checkbox"> Inactive</label>
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

    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target) && e.target !== dropdownBtn) {
        dropdown.classList.remove("show");
      }
    });

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
