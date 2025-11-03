<?php
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if (!isset($current_page)) {
    $current_page = basename($_SERVER['PHP_SELF']);
}
?>
<div class="header">
    <a href="homepage.php" class="logo-link"><img src="images/logo.png" alt="HausTap" class="logo-img"></a>
    <?php
        if (strpos($url, "bookings") !== false) {
            echo '<nav class="nav">
                    <a href="../guest/homepage.php">Home</a>
                    <a href="../guest/services.php">Services</a>
                    <a href="booking.php" class="active">Bookings</a>
                    <a href="../guest/About.php">About</a>
                    <a href="../guest/Contact.php">Contact</a>
                </nav>';
        } else {
            echo '<nav class="nav">
                    <a href="homepage.php" class="active">Home</a>
                    <a href="services.php">Services</a>
                    <a href="../bookings/booking.php">Bookings</a>
                    <a href="About.php">About</a>
                    <a href="Contact.php">Contact</a>
                </nav>';
        }
    ?>

    <!-- Right side (Search + Auth Links) -->
    <div class="header-right">
      <div class="search-box">
        <input type="text" placeholder="Search services">
        <i class="fa fa-search"></i>
      </div>
       <div id="account-container">
        <!-- Auth links or account will be injected here -->
        </div>
    </div>
  </div>
    </div>
  </div>