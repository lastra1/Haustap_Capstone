<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account Address</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/account_address.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    
     <main class="address-page">
    <div class="address-container">
      <div class="address-header">
        <h2>Addresses</h2>
        <button class="add-address-btn"><i class="fa fa-plus"></i> Add New Address</button>
      </div>
      <hr class="divider">

      <!-- Address Card 1 -->
      <div class="address-box">
        <div class="address-info">
          <p class="address-name">Jen Bornilla</p>
          <p class="address-details">123 P. Burgos Street, Brgy. San Isidro, Quezon City, Metro Manila</p>
        </div>
        <div class="address-actions">
          <div class="edit-delete">
            <button class="edit-btn">Edit</button>
            <button class="delete-btn">Delete</button>
          </div>
          <button class="default-btn">Set as Default</button>
        </div>
      </div>

      <!-- Address Card 2 -->
      <div class="address-box">
        <div class="address-info">
          <p class="address-name">Maria Santos</p>
          <p class="address-details">45 Mabini Street, Brgy. Malate, Manila City, Metro Manila</p>
        </div>
        <div class="address-actions">
          <div class="edit-delete">
            <button class="edit-btn">Edit</button>
            <button class="delete-btn">Delete</button>
          </div>
          <button class="default-btn">Set as Default</button>
        </div>
      </div>
    </div>
  </main>

</body>
</html>