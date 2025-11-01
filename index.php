<?php
// Redirect root to the public homepage without changing existing pages
header('Location: /guest/homepage.php', true, 302);
exit;