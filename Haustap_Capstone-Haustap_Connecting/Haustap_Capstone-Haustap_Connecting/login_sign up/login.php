<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log In | HausTap</title>
  <link rel="stylesheet" href="/css/global.css">
  <link rel="stylesheet" href="/login_sign%20up/css/login.css">
<link rel="stylesheet" href="/client/css/homepage.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body>
  <script src="/login_sign%20up/js/api.js"></script>
  <div class="container">
    <div class="logo">
      <a href="/guest/homepage.php" aria-label="Go to homepage">
        <img src="/login_sign%20up/image/logo.png" alt="HausTap Logo" width="120" height="100">
      </a>
    </div>
    <form class="login-form">
      <h2>Log In</h2>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
  <a href="/reset-password" class="forgot">Forgot Password?</a>
      <button type="submit">Log In</button>
      <div class="signup-link">
        New to HausTap? <a href="/signup">Sign Up</a>
      </div>
    </form>
  </div>
    <!-- FOOTER -->
<?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>
  <script>
    (function() {
      const form = document.querySelector('.login-form');
      if (!form) return;

      form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        // Basic client-side validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) { alert('Email is required.'); return; }
        if (!emailPattern.test(email)) { alert('Please enter a valid email address.'); return; }
        if (!password || password.length < 6) { alert('Password must be at least 6 characters.'); return; }

        try {
          const res = await fetch(`${window.API_BASE}/auth/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
          });

          // Try to parse JSON safely; show readable error on HTML responses
          let data;
          const ct = res.headers.get('content-type') || '';
          if (ct.includes('application/json')) {
            data = await res.json();
          } else {
            const text = await res.text();
            try { data = JSON.parse(text); } catch { data = { message: text }; }
          }

          if (!res.ok || !data?.token) {
            console.error('Login failed:', data);
            alert(data?.message || 'Login failed');
            return;
          }

          // Persist token and user for subsequent requests/UI
          localStorage.setItem('haustap_token', data.token);
          if (data?.user) {
            try {
              // Overwrite any stale local user cache with the fresh login payload
              const u = { ...data.user };
              // Robust fallback: if no name provided, derive from email local-part
              if (!u.name || !String(u.name).trim()) {
                const localPart = (email || '').split('@')[0] || '';
                u.name = localPart || (u.email ? String(u.email).split('@')[0] : '');
              }
              localStorage.setItem('haustap_user', JSON.stringify(u));
            } catch {}
          }

          // Role-based redirect
          const roleName = (data?.user?.role?.name || '').toLowerCase();
          let redirect = '../client/homepage.php'; // default for client/admin
          if (roleName === 'client') {
            redirect = '../client/homepage.php';
          } else if (roleName === 'provider') {
            redirect = '../Application_Individual/application_services.php';
          } else if (roleName === 'admin') {
            // Admin page not yet defined; keep user on client homepage for now
            redirect = '../client/homepage.php';
          }

          window.location.href = redirect;
        } catch (err) {
          console.error('Network error:', err);
          alert('Network error. Please try again.');
        }
      });
    })();
  </script>
</body>
</html>





