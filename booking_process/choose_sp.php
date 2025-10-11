<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Choose Service Provider</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/choose_sp.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
  <main class="choose-provider-page">
  <h1 class="page-title">Choose Provider</h1>

  <section class="providers-container">
    <!-- Provider 1 -->
    <div class="provider-box">
      <div class="profile-icon"><i class="fa-solid fa-user"></i></div>
      <div class="provider-info">
        <h3>Ana Santos</h3>
        <p><i class="fa-solid fa-star"></i> Rate: 4.5</p>
        <p><i class="fa-solid fa-location-dot"></i> 2.5 km away</p>
      </div>
    </div>

    <!-- Provider 2 -->
    <div class="provider-box">
      <div class="profile-icon"><i class="fa-solid fa-user"></i></div>
      <div class="provider-info">
        <h3>Maria Lopez</h3>
        <p><i class="fa-solid fa-star"></i> Rate: 4.5</p>
        <p><i class="fa-solid fa-location-dot"></i> 2.6 km away</p>
      </div>
    </div>

    <!-- Provider 3 -->
    <div class="provider-box">
      <div class="profile-icon"><i class="fa-solid fa-user"></i></div>
      <div class="provider-info">
        <h3>Lisa Deleon</h3>
        <p><i class="fa-solid fa-star"></i> Rate: 4.5</p>
        <p><i class="fa-solid fa-location-dot"></i> 2.8 km away</p>
      </div>
    </div>
  </section>

  <!-- Filter Box -->
  <section class="filter-box">
    <div class="filter-header">
      <p>Show service provider within:</p>
    </div>
    <div class="filter-options">
      <label><input type="radio" name="distance" /> 5 km</label>
      <label><input type="radio" name="distance" /> 10 km</label>
    </div>
  </section>

  <!-- Buttons -->
  <div class="action-buttons">
    <button class="cancel-btn">Cancel</button>
    <button class="book-btn">Book</button>
  </div>
</main>


</body>
</html>
