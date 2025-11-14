<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Password</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/change_password.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <main class="change-password-page">
  <div class="change-password-box">
    <div class="change-password-header">
      <button class="back-btn"><i class="fas fa-arrow-left"></i></button>
      <h2>Change Password</h2>
    </div>

    <form class="password-form" method="POST" action="#">
      <div class="form-group">
        <label for="current-password">Current Password</label>
        <input type="password" id="current-password" name="current_password" placeholder="Enter current password">
      </div>

      <div class="form-group password-toggle">
        <label for="new-password">New Password</label>
        <div class="input-wrapper">
          <input type="password" id="new-password" name="new_password" placeholder="Enter new password">
          <i class="fas fa-eye toggle-icon"></i>
        </div>
      </div>

      <div class="form-group password-toggle">
        <label for="confirm-password">Confirm New Password</label>
        <div class="input-wrapper">
          <input type="password" id="confirm-password" name="confirm_password" placeholder="Re-enter new password">
          <i class="fas fa-eye toggle-icon"></i>
        </div>
      </div>

      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </div>
</main>
</body>
</html>