<?php
// Shared header partial for both guest and client contexts
// Usage: set $context = 'guest' or 'client' before requiring this file

$context = isset($context) ? $context : 'guest';
$current = $_SERVER['REQUEST_URI'] ?? '';
?>
<link rel="stylesheet" href="/client/css/search.css">
<?php
$isActive = function(array $patterns) use ($current) {
  foreach ($patterns as $p) {
    if (stripos($current, $p) === 0) { return ' class="active"'; }
  }
  return '';
};

if ($context === 'client') {
  $logoHref = '/client/homepage.php';
  $logoSrc  = '/client/images/logo.png';
  $nav = [
    ['/client/homepage.php', 'Home', ['/client/homepage.php','/client/index.php','/index.php']],
    ['/client/services.php', 'Services', ['/client/services']],
    ['/bookings/booking.php', 'Bookings', ['/bookings']],
    ['/client/About.php', 'About', ['/client/About.php']],
    ['/client/contact_client.php', 'Contact', ['/client/contact_client.php']],
  ];
} else {
  $logoHref = '/guest/homepage.php';
  $logoSrc  = '/guest/images/logo.png';
  $nav = [
    ['/guest/homepage.php', 'Home', ['/guest/homepage.php','/index.php']],
    ['/guest/services.php', 'Services', ['/guest/services']],
    ['/login', 'Bookings', ['/bookings']],
    ['/guest/About.php', 'About', ['/guest/About.php']],
    ['/guest/Contact.php', 'Contact', ['/guest/Contact.php']],
  ];
}
?>
<header class="header">
  <!-- Logo -->
  <a href="<?= htmlspecialchars($logoHref) ?>">
    <img src="<?= htmlspecialchars($logoSrc) ?>" alt="HausTap" class="logo-img">
  </a>

  <!-- Navigation -->
  <nav class="nav">
    <?php foreach ($nav as $item): list($href, $label, $patterns) = $item; ?>
      <a href="<?= htmlspecialchars($href) ?>"<?= $isActive($patterns) ?>><?= htmlspecialchars($label) ?></a>
    <?php endforeach; ?>
  </nav>

  <!-- Right side: restore original simplified layout -->
  <div class="header-right">
    <!-- Search -->
    <div class="search-box">
      <input type="text" placeholder="Search services..." aria-label="Search services">
      <button class="search-btn" aria-label="Search"><i class="fa-solid fa-search"></i></button>
    </div>

    <?php if ($context === 'guest'): ?>
      <div class="auth-links">
        <div class="signup-link"><a href="/signup">Sign up</a></div>
        <span>|</span>
        <div class="login-link"><a href="/login">Login</a></div>
      </div>
    <?php else: ?>
      <a href="#" id="notifBellBtn" class="icon-link" aria-expanded="false" aria-controls="notifDropdown" title="Notifications">
        <i class="fa-solid fa-bell"></i>
        <span id="notifCount" style="display:none;background:#3dbfc3;color:#fff;border-radius:10px;font-size:12px;padding:0 6px;margin-left:4px;">0</span>
      </a>
      <a href="/account" class="account-link" title="My Account">
        <i class="fa-solid fa-user account-icon"></i>
        <span class="account-name">My Account</span>
      </a>
      <div id="notifDropdown" class="hidden" style="position:absolute;right:48px;top:72px;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,.1);width:320px;z-index:1000;">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;border-bottom:1px solid #f1f5f9;">
          <strong>Notifications</strong>
          <button id="notifMarkAll" style="background:transparent;border:none;color:#3dbfc3;cursor:pointer">Mark all read</button>
        </div>
        <ul id="notifList" style="list-style:none;margin:0;padding:0;max-height:360px;overflow:auto"></ul>
      </div>
    <?php endif; ?>
  </div>
</header>
