<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Account</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/my_account.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>
  <?php include '../utils/header.php'; ?>

  <main class="account-page">
  <div class="account-container">
    <!-- LEFT SIDEBAR -->
    <aside class="sidebar">
      <div class="profile-card">
  <div class="profile-header-side">
    <i class="fa-solid fa-user fa-2x"></i>
    <div class="profile-text">
      <p class="profile-name">Jenn Bornilla</p>
      <button class="edit-profile-btn">
        <i class="fa-solid fa-pen"></i> Edit Profile
      </button>
    </div>
  </div>
</div>

      <nav class="sidebar-nav">
  <div class="sidebar-nav-group">
    <h4><i class="fa-solid fa-user-circle"></i> My Account</h4>
    <ul>
      <li><a href="#" class="active">Profile</a></li>
      <li><a href="#">Addresses</a></li>
      <li><a href="#">Privacy Settings</a></li>
    </ul>
  </div>
  <ul class="sidebar-secondary">
    <li><i class="fa-solid fa-user-group"></i> Referral</li>
    <li><i class="fa-solid fa-ticket"></i> My Vouchers</li>
    <li><i class="fa-solid fa-link"></i> Connect Haustap</li>
    <li><i class="fa-solid fa-file-contract"></i> Terms and Conditions</li>
    <li><i class="fa-solid fa-star"></i> Rate HOMI</li>
    <li><i class="fa-solid fa-circle-info"></i> About us</li>
  </ul>

  <button class="logout-btn" id="logout-btn">Log out</button>
</nav>
    </aside>

    <!-- RIGHT MAIN CONTENT -->
    <section class="profile-section">
      <div class="profile-box">
        <h2 class="profile-header">Profile</h2>

        <div class="profile-content">
          <div class="profile-info">
            <div class="info-row">
              <label>Name:</label>
              <input type="text" id="name" placeholder="">
            </div>

            <div class="info-row">
              <label>Email:</label>
              <span>jen********@gmail.com <a href="#">Change</a></span>
            </div>

            <div class="info-row">
              <label>Phone Number:</label>
              <span>********89 <a href="#">Change</a></span>
            </div>

            <div class="info-row">
              <label>Gender:</label>
              <span>
                <label><input type="radio" name="gender"> Male</label>
                <label><input type="radio" name="gender"> Female</label>
              </span>
            </div>

            <div class="info-row">
              <label>Date of Birth:</label>
              <span><a href="#">Add</a></span>
            </div>

            <div class="btn-group">
              <button class="change-password">Change Password</button>
              <button class="save-btn">Save</button>
            </div>
          </div>

          <div class="profile-image">
            <i class="fa-solid fa-user fa-4x"></i>
            <button class="select-image">Select Image</button>
            <p class="file-note">File size: maximum 1MB<br>File extension: JPEG, PNG</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
<?php include '../utils/footer.php'; ?>
</body>
</html>