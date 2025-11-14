<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Providers</title>
  <link rel="stylesheet" href="css/manage_provider.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
          <li class="active">Manage Providers</li>
          <li>Manage Bookings</li>
          <li>Job Status Monitor</li>
          <li>Analytics & Report</li>
          <li>Subscription Management</li>
          <li>Feedback & Reviews</li>
          <li>System Settings</li>
        </ul>
      </nav>
    </aside>

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
              <a href="#">Activity Logs</a>
              <a href="#" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <section class="content-area">
        <!-- Search and Filter -->
        <div class="search-filter">
          <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search Provider" />
          </div>

          <!-- Filter Dropdown -->
          <div class="filter-dropdown">
            <button class="filter-btn" id="filterBtn">
               <div class="filter-btn"><i class="fa fa-sliders"></i> Filter</div>
            </button>

            <div class="dropdown-content" id="filterDropdown">
              <div class="filter-section">
                <label>Filter by Status</label>
                <div class="checkbox-group">
                  <label><input type="checkbox" checked> Active</label>
                  <label><input type="checkbox" checked> Inactive</label>
                  <label><input type="checkbox" checked> Suspended</label>
                </div>
              </div>

              <div class="filter-section">
                <label>Filter by Rating</label>
                <div class="stars">
                  <div>★★★★★</div>
                  <div>★★★★☆</div>
                  <div>★★★☆☆</div>
                  <div>★★☆☆☆</div>
                  <div>★☆☆☆☆</div>
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
                <th>Id</th>
                <th>Name</th>
                <th>Skills</th>
                <th>Rating</th>
                <th>Date Hired</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td><td>Jenn Bornilla</td><td>Home Cleaning</td><td>4.5/5</td><td>January 7, 2024</td>
                <td><span class="status active">Active</span></td><td><span class="arrow">&gt;</span></td>
              </tr>
              <tr>
                <td>2</td><td>Pagod na</td><td>Plumbing</td><td>4.5/5</td><td>January 24, 2024</td>
                <td><span class="status inactive">Inactive</span></td><td><span class="arrow">&gt;</span></td>
              </tr>
              <tr>
                <td>3</td><td>Pagod na</td><td>Electrical</td><td>4.5/5</td><td>January 24, 2024</td>
                <td><span class="status suspend">Suspend</span></td><td><span class="arrow">&gt;</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination and Summary -->
        <div class="table-footer">
          <div class="pagination">
            <span>[ ◄ Prev ]</span>
            <span>Showing 1–10 of 120</span>
            <span>[ Next ► ]</span>
          </div>
          <div class="summary">
            <span>Total Clients: 1250</span>
            <span>Active: 1,000</span>
            <span>Inactive: 200</span>
            <span>Suspend: 50</span>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
    // User dropdown
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");
    dropdownBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });
    window.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) dropdown.classList.remove("show");
    });

    // Filter dropdown
    const filterBtn = document.getElementById("filterBtn");
    const filterDropdown = document.getElementById("filterDropdown");
    filterBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      filterDropdown.classList.toggle("show");
    });
    window.addEventListener("click", (e) => {
      if (!filterDropdown.contains(e.target)) filterDropdown.classList.remove("show");
    });
  </script>
</body>
</html>
