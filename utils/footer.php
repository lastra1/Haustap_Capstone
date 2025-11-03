
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
        <img src="images/logo.png" alt="HausTap Logo" />
        <p>Your space. Your peace. Your Glow</p>
      </div>

      <!-- Right Section -->
      <div class="footer-right">
        <h4>FOLLOW US</h4> <br>
        <ul>
          <li><i class="fab fa-facebook-f"></i> Facebook</li>
          <li><i class="fab fa-instagram"></i> Instagram</li>
          
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
<?php if ($current_page === 'homepage.php'): ?>
    
  <script>
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById('account-container');
    const token = localStorage.getItem('haustap_token');
    const user = JSON.parse(localStorage.getItem('haustap_user') || '{}');

    if (token && user.name) {
        // User is logged in
        container.innerHTML = `
            <a href="../my_account/my_account.php" class="icon-button account-link">
                <i class="bi bi-person-circle"></i>
                <span>Welcome, ${user.name}</span>
            </a>
        `;
    } else {
        // User not logged in
        container.innerHTML = `
            <div class="auth-links">
                <div class="signup-link">
                    <a href="../login_sign up/sign up.php">Sign up</a>
                </div>
                <span>|</span>
                <div class="login-link">
                    <a href="../login_sign up/login.php">Login</a>
                </div>
            </div>
        `;
    }

});


    // Service Categories Fetching
    document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById('categories-container');

    try {
        const res = await fetch("<?php
                                  include '../utils/config.php';
                                  echo API_CATEGORIES_ENDPOINT;
                                  ?>" );
        if (!res.ok) throw new Error('Failed to fetch categories');

        const categories = await res.json();

        // Render each category card
        container.innerHTML = categories.map(cat => `
        <a href="../guest/services.php?category_id=${cat.id}" class="category-card-link">
        <div class="category-card">
            <img 
      src="images/${cat.name.toLowerCase().replace(/\s+/g, '-')}.png"
      alt="${cat.name}"
      onerror="this.onerror=null; this.src='../utils/no-img.png';"
    >
            <div class="category-card-title">${cat.name}</div>
            <div class="category-card-desc">${cat.description}</div>
        </div>
    </a>
        `).join('');

    } catch (err) {
        console.error(err);
        container.innerHTML = '<p>Failed to load categories.</p>';
    }
    });
</script>

<?php elseif ($current_page === 'services.php'): ?>
<script>
  window.API_CATEGORIES_ENDPOINT = "<?php echo API_CATEGORIES_ENDPOINT; ?>";
  window.API_SERVICES_ENDPOINT = "<?php echo API_SERVICES_ENDPOINT; ?>";
  window.SELECTED_CATEGORY_ID = "<?php echo $categoryId ?? ''; ?>";
</script>
<script src="../utils/js/services.js" defer></script>
<?php elseif ($current_page === 'my_account.php'): ?>

<script>
    // Logout
    document.getElementById('logout-btn').addEventListener('click', (e) => {
        e.preventDefault();

        // Remove token and user info from localStorage
        localStorage.removeItem('haustap_token');
        localStorage.removeItem('haustap_user');

        // Optional: Redirect to login or homepage
        window.location.href = '../login_sign up/login.php';
    });
</script>
<?php endif; ?>