<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View All Bookings</title>
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
      <li>Manage Providers</li>
      <li class="active">View All Bookings</li>
      <li>Job Status Monitor</li>
      <li>Analytics & Report</li>
      <li>System Settings</li>
    </ul>
  </div>

  <div class="main-content">
    <header>
      <h2>Bookings</h2>
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
              <th>BOOKING ID</th>
              <th>USERNAME</th>
              <th>PROVIDERNAME</th>
              <th>SERVICE TYPE</th>
              <th>DATE & TIME</th>
              <th>STATUS</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>A32514</td>
              <td>Jenn Bornilla</td>
              <td>Ana Santos</td>
              <td>Home Cleaning - Basic Cleaning</td>
              <td>2025-06-07 &nbsp;&nbsp;14:30</td>
              <td><span class="status completed">Completed</span></td>
            </tr>
            <tr>
              <td>A32516</td>
              <td>CJ Garcia</td>
              <td>
                Carl Mirabueno<br>
                Mj Punzalan<br>
                Mc Organo
              </td>
              <td>Home Cleaning - Deep Cleaning</td>
              <td>2025-06-07 &nbsp;&nbsp;10:30</td>
              <td><span class="status in-progress">In-Progress</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</body>
</html>
