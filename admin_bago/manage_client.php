<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Clients | Admin Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="css/manage_client.css">
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
          <li class="active">Manage Clients</li>
          <li>Manage Providers</li>
          <li>Manage Bookings</li>
          <li>Job Status Monitor</li>
          <li>Analytics & Report</li>
          <li>Finance & Transactions</li>
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

        <!-- Search + Filter -->
        <div class="search-filter">
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="Search Client">
            </div>

            <div class="filter-btn"><i class="fa fa-sliders"></i> Filter</div>

            <!-- ✅ Filter Dropdown -->
            <div class="filter-dropdown" id="filterBox">
                <p>Filter by Status</p>
                <label><input type="checkbox" > Active</label>
                <label><input type="checkbox" > Inactive</label>
                <label><input type="checkbox" > Suspended</label>

                <button class="apply-btn">Apply</button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Date Joined</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td><td>Jenn Bornilla</td><td>January 7, 2024</td>
                        <td><span class="status active">Active</span></td><td>></td>
                    </tr>
                    <tr>
                        <td>2</td><td>Pagod na</td><td>January 24, 2024</td>
                        <td><span class="status inactive">Inactive</span></td><td>></td>
                    </tr>
                    <tr>
                        <td>3</td><td>Pagod na</td><td>January 24, 2024</td>
                        <td><span class="status suspended">Suspend</span></td><td>></td>
                    </tr>
                    <tr>
                        <td>4</td><td>Jenn Bornilla</td><td>January 7, 2024</td>
                        <td><span class="status active">Active</span></td><td>></td>
                    </tr>
                    <tr>
                        <td>5</td><td>Pagod na</td><td>January 24, 2024</td>
                        <td><span class="status inactive">Inactive</span></td><td>></td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination">
                <span>◄ Prev</span>
                <span>Showing 1–10 of 120</span>
                <span>Next ►</span>
            </div>
        </div>

        <div class="footer-count">
            Total Clients: 1250 | Active: 1000 | Inactive: 200 | Suspend: 50
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

document.querySelector('.filter-btn').addEventListener('click', () => {
    const box = document.getElementById('filterBox');
    box.style.display = box.style.display === "block" ? "none" : "block";
});

document.addEventListener('click', (event) => {
    const filterBox = document.getElementById('filterBox');
    const filterBtn = document.querySelector('.filter-btn');
    if (!filterBox.contains(event.target) && !filterBtn.contains(event.target)) {
        filterBox.style.display = "none";
    }
});
</script>

</body>
</html>
