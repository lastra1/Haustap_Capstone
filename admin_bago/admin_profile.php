<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - View Profile</title>
  <link rel="stylesheet" href="css/profile_admin.css">
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <img src="images/logo.png" alt="logo">
        <span>Admin Dashboard</span>
      </div>
      <nav>
        <ul>
          <li class="active">Dashboard Overview</li>
          <li>Manage Applicants</li>
          <li>Manage Clients</li>
          <li>Manage Providers</li>
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
      <header class="topbar">
        <div class="user">
          <button class="notif-btn">🔔</button>
          <div class="user-menu">
            <button class="user-btn" id="userDropdownBtn">
              Mj Punzalan ▼
            </button>
            <div class="dropdown" id="userDropdown">
              <a href="#">View Profile</a>
              <a href="#">Change Password</a>
              <a href="#">Activity Logs</a>
              <a href="#" class="logout">Log out</a>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Header -->
      <section class="page-header">
        <h3>Admin &gt; View Profile</h3>
      </section>

      <!-- Profile Section -->
      <section class="profile-section">
        <div class="profile-card">
          <div class="profile-left">
            <h2>Profile</h2>
            <form>
              <label>Name</label>
              <input type="text" placeholder="Enter name">

              <label>Email</label>
              <div class="email-field">
                <span>je********@gmail.com</span>
                <a href="#">Change</a>
              </div>

              <label>Role</label>
              <p>Superadmin</p>

              <label>Phone Number</label>
              <div class="phone-field">
                <span>********46</span>
                <a href="#">Change</a>
              </div>

              <label>Gender</label>
              <div class="gender">
                <label><input type="radio" name="gender"> Male</label>
                <label><input type="radio" name="gender"> Female</label>
              </div>

              <label>Date of Birth</label>
              <a href="#" class="add-link">Add</a>

              <div class="buttons">
                <button type="button" class="change-password">Change Password</button>
                <button type="submit" class="save-btn">Save</button>
              </div>
            </form>
          </div>

          <div class="divider"></div>

          <div class="profile-right">
            <div class="image-upload">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg>
              <button class="upload-btn">Select Image</button>
              <p class="file-info">File size: maximum 1 MB<br>File extension: .JPEG, .PNG</p>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
    // Dropdown toggle
    const dropdownBtn = document.getElementById("userDropdownBtn");
    const dropdown = document.getElementById("userDropdown");

    dropdownBtn.addEventListener("click", () => {
      dropdown.classList.toggle("show");
    });

    window.addEventListener("click", (e) => {
      if (!dropdownBtn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.remove("show");
      }
    });
  </script>
</body>
</html>
