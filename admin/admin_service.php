<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Providers</title>
  <link rel="stylesheet" href="css/admin_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="images/logo.png" alt="Haustap Logo" />
    </div>
    <ul class="menu">
      <li>DashBoard Overview</li>
      <li>Manage Users</li>
      <li class="active">Manage Providers</li>
      <li>View All Bookings</li>
      <li>Job Status Monitor</li>
      <li>Analytics & Report</li>
      <li>System Settings</li>
    </ul>
  </div>

  <div class="main-content">
    <header>
      <h2>Manage Providers</h2>
      <div class="header-buttons">
        <button class="btn admin">Admin</button>
        <button class="btn logout">Logout</button>
      </div>
    </header>

    <section class="user-section">
      <div class="user-controls">
        <div class="search-box">
          <i class="fa fa-search"></i>
          <input type="text" placeholder="Search Name" />
        </div>
        <div class="filter">
          <i class="fa fa-sliders"></i>
          <span>Filter</span>
        </div>
      </div>

      <div class="user-table">
        <table>
          <thead>
            <tr>
              <th>PROVIDER ID</th>
              <th>NAME</th>
              <th>SERVICE</th>
              <th>RATING</th>
              <th>VERIFIED ON</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>001</td>
              <td>Ana Santos</td>
              <td>Home Cleaner</td>
              <td>4.8 / 5.0</td>
              <td>January 7, 2025</td>
              <td class="arrow">&gt;</td>
            </tr>
            <tr>
              <td>002</td>
              <td>Carl Mirabueno</td>
              <td>Home Cleaner</td>
              <td>4.8 / 5.0</td>
              <td>January 24, 2025</td>
              <td class="arrow">&gt;</td>
            </tr>
            <tr>
              <td>003</td>
              <td>Mj Punzalan</td>
              <td>Home Cleaner</td>
              <td>4.5 / 5.0</td>
              <td>February 3, 2025</td>
              <td class="arrow">&gt;</td>
            </tr>
            <tr>
              <td>004</td>
              <td>Mc Organo</td>
              <td>Home Cleaner</td>
              <td>4.8 / 5.0</td>
              <td>March 8, 2025</td>
              <td class="arrow">&gt;</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</body>
</html>
