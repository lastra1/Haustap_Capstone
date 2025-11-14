<?php
// Shared footer partial for both guest and client contexts
// Usage: set $context = 'guest' or 'client' before requiring this file

$context = isset($context) ? $context : 'guest';
$logoSrc = $context === 'client' ? '/client/images/logo.png' : '/guest/images/logo.png';
?>
<link rel="stylesheet" href="/css/footer.css">
<!-- FOOTER -->
<footer>
  <div class="footer-content">
    <!-- Left Section -->
    <div class="footer-left">
      <h4>ABOUT HausTap</h4>
      <ul>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Policies</a></li>
        <li><a href="#">Our Sitemap</a></li>
        <li><a href="#">Our Services</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Testimonials</a></li>
      </ul>
    </div>

    <!-- Center Section -->
    <div class="footer-center">
      <img src="<?= $logoSrc ?>" alt="HausTap Logo" />
      <p>Your space. Your peace. Your Glow</p>
    </div>

    <!-- Right Section -->
    <div class="footer-right">
      <h4>FOLLOW US</h4> <br>
      <ul>
        <li><a href="https://www.facebook.com/profile.php?id=61583010005975" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
        <li><a href="https://www.instagram.com/haustap.ph/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
      </ul>
      <div class="contact-info">
        <p>
          Address: Abc Road 12345<br />
          Philippines<br />
          Phone: +65 949 9226 246<br />
          Email: HAUSTAP_PH@gmail.com
        </p>
      </div>
    </div>
  </div>
  <div class="footer-bottom">2025 HausTap. All Rights Reserved.</div>
</footer>
<script>
document.addEventListener('DOMContentLoaded', function () {
  try {
    var prevNavs = document.querySelectorAll('nav.pagination a[aria-label="Previous"]');
    prevNavs.forEach(function(el){
      el.addEventListener('click', function(e){ e.preventDefault(); window.history.back(); });
    });
    var pagDivs = document.querySelectorAll('div.pagination');
    pagDivs.forEach(function(pag){
      var buttons = pag.querySelectorAll('button');
      if (!buttons.length) return;
      var prev = buttons[0];
      if (prev && prev.textContent.trim() === '<') {
        prev.addEventListener('click', function(e){ e.preventDefault(); window.history.back(); });
      }
    });
  } catch (e) {}
});
</script>
<!-- Logout handler shared across guest/client pages -->
<script src="/client/js/logout.js" defer></script>
<script src="/client/js/search-categories.js" defer></script>
<script>
// Client-side repair for common mojibake sequences caused by prior mis-encoding
document.addEventListener('DOMContentLoaded', function () {
  try {
    var map = {
      'â€“': '–',
      'â€”': '—',
      'â€˜': '‘',
      'â€™': '’',
      'â€œ': '“',
      'â€': '”',
      'â€¢': '•',
      'â€¦': '…',
      'Â ': ' ',
      'Â': '',
      'â‚±': '₱',
      'â˜…': '★',
      'âœ”': '✔',
      'â†�': '←',
      'ðŸ“·': '📷',
      'ðŸŽ¥': '🎥'
    };
    function replaceText(s){
      var out = s;
      for (var k in map) {
        if (!Object.prototype.hasOwnProperty.call(map, k)) continue;
        out = out.split(k).join(map[k]);
      }
      return out;
    }
    var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null);
    var node;
    var changed = 0;
    while (node = walker.nextNode()) {
      var t = node.nodeValue;
      var r = replaceText(t);
      if (r !== t) { node.nodeValue = r; changed++; }
    }
    // Optionally log to console for debugging
    // if (changed) console.debug('Mojibake text repaired:', changed);
  } catch (e) {}
});
</script>
