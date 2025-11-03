<?php
include '../utils/config.php';
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Homi</title>
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <?php include '../utils/header.php'; ?>
    <main class="main-content">
        <div class="services-header">
            <h1 class="services-title">Services</h1>
            <select id="categorySelect" class="category-select">
              <option value="">All Categories</option>
            </select>
        </div>

          <!-- Services Container -->
          <div id="services-container" class="services-grid">
              <p>Loading services...</p>
          </div>
        </div>
    </main>
  <?php include '../utils/footer.php'; ?>
</body>
</html>