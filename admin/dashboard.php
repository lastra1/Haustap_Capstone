<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="images/logo.png" alt="Haustap Logo" />
    </div>
    <ul class="menu">
      <li class="active">DashBoard Overview</li>
      <li>Manage Users</li>
      <li>Manage Providers</li>
      <li>View All Bookings</li>
      <li>Job Status Monitor</li>
      <li>Analytics & Report</li>
      <li>System Settings</li>
    </ul>
  </div>

  <div class="main-content">
    <header>
      <h2>Admin Dashboard</h2>
      <div class="header-buttons">
        <button class="btn admin">Admin</button>
        <button class="btn logout">Logout</button>
      </div>
    </header>

    <section class="stats">
      <div class="card">
        <i class="fa fa-user"></i>
        <h3>1250</h3>
        <p>Total Users</p>
      </div>
      <div class="card">
        <i class="fa fa-clock"></i>
        <h3>4</h3>
        <p>Pending Jobs</p>
      </div>
      <div class="card">
        <i class="fa fa-briefcase"></i>
        <h3>420</h3>
        <p>Verified Service Providers</p>
      </div>
    </section>

    <section class="list">
      <h3>List of Applicants</h3>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Date Applied</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Juan Dela Cruz</td>
            <td>May 10, 2025</td>
            <td><a href="#">View Documents</a></td>
          </tr>
          <tr>
            <td>Ramon Ang</td>
            <td>May 18, 2025</td>
            <td><a href="#">View Documents</a></td>
          </tr>
          <tr>
            <td>Christine Samson</td>
            <td>May 20, 2025</td>
            <td><a href="#">View Documents</a></td>
          </tr>
          <tr>
            <td>Megan Reyes</td>
            <td>May 23, 2025</td>
            <td><a href="#">View Documents</a></td>
          </tr>
        </tbody>
      </table>
    </section>

    <section class="alerts">
      <h3>System Alert</h3>
      <div class="alert">
        <i class="fa fa-exclamation-triangle"></i>
        <p>3 new booking request pending</p>
      </div>
      <div class="alert">
        <i class="fa fa-exclamation-triangle"></i>
        <p>Provider approval required for 2 new applicants</p>
      </div>
    </section>
  </div>
</body>
</html>
