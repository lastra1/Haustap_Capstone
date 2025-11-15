<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log In | HausTap</title>
  <link rel="stylesheet" href="/css/global.css">
  <link rel="stylesheet" href="/login_sign%20up/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-auth-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore-compat.js"></script>
  
  <!-- Firebase Configuration -->
  <script src="/js/firebase-config.js"></script>
  
  <div class="container">
    <div class="logo">
      <a href="/guest/homepage.php" aria-label="Go to homepage">
        <img src="/login_sign%20up/image/logo.png" alt="HausTap Logo" width="120" height="100">
      </a>
    </div>
    <form class="login-form" id="loginForm">
      <h2>Log In</h2>
      
      <div id="errorMessage" class="error-message" style="display: none;"></div>
      
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required placeholder="Enter your email">
      
      <label for="password">Password</label>
      <div class="password-container">
        <input type="password" id="password" name="password" required placeholder="Enter your password">
        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
      </div>
      
      <a href="#" class="forgot" id="forgotPassword">Forgot Password?</a>
      
      <button type="submit" id="loginButton">Log In</button>
      <div class="loading" id="loadingSpinner" style="display: none;">
        <i class="fas fa-spinner fa-spin"></i> Logging in...
      </div>
      
      <div class="signup-link">
        New to HausTap? <a href="/signup">Sign Up</a>
      </div>
    </form>
  </div>

  <!-- FOOTER -->
  <?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loginForm = document.getElementById('loginForm');
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      const loginButton = document.getElementById('loginButton');
      const loadingSpinner = document.getElementById('loadingSpinner');
      const errorMessage = document.getElementById('errorMessage');
      const togglePassword = document.getElementById('togglePassword');
      const forgotPasswordLink = document.getElementById('forgotPassword');

      // Password toggle functionality
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });

      // Forgot password functionality
      forgotPasswordLink.addEventListener('click', function(e) {
        e.preventDefault();
        const email = emailInput.value.trim();
        if (!email) {
          showError('Please enter your email address first.');
          emailInput.focus();
          return;
        }
        
        if (confirm(`Send password reset email to ${email}?`)) {
          resetPassword(email);
        }
      });

      // Login form submission
      loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        
        // Basic validation
        if (!email || !password) {
          showError('Please enter both email and password.');
          return;
        }
        
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
          showError('Please enter a valid email address.');
          return;
        }
        
        if (password.length < 6) {
          showError('Password must be at least 6 characters.');
          return;
        }

        try {
          showLoading(true);
          hideError();
          
          // Use FirebaseAuth helper
          const result = await FirebaseAuth.login(email, password);
          console.log('Login successful:', result);
          
          // Get user role and redirect accordingly
          const userRole = await FirebaseAuth.getUserRole(result.user.uid);
          console.log('User role:', userRole);
          
          // Redirect based on role
          if (userRole === 'service_provider') {
            window.location.href = '/service-provider';
          } else {
            window.location.href = '/client/homepage.php';
          }
          
        } catch (error) {
          console.error('Login error:', error);
          showError(getErrorMessage(error));
        } finally {
          showLoading(false);
        }
      });

      // Helper functions
      function showLoading(show) {
        loginButton.style.display = show ? 'none' : 'block';
        loadingSpinner.style.display = show ? 'block' : 'none';
        loginButton.disabled = show;
      }

      function showError(message) {
        errorMessage.textContent = message;
        errorMessage.style.display = 'block';
      }

      function hideError() {
        errorMessage.style.display = 'none';
      }

      function getErrorMessage(error) {
        if (error.code) {
          switch (error.code) {
            case 'auth/user-not-found':
              return 'No user found with this email address.';
            case 'auth/wrong-password':
              return 'Incorrect password. Please try again.';
            case 'auth/invalid-email':
              return 'Invalid email address format.';
            case 'auth/user-disabled':
              return 'This account has been disabled.';
            default:
              return error.message || 'Login failed. Please try again.';
          }
        }
        return error.message || 'An unexpected error occurred.';
      }

      // Reset password function
      async function resetPassword(email) {
        try {
          // Note: This would require Firebase Admin SDK on the backend
          // For now, we'll show a message
          alert('Password reset functionality will be implemented soon. Please contact support.');
        } catch (error) {
          console.error('Password reset error:', error);
          showError('Failed to send password reset email.');
        }
      }

      // Check if user is already logged in
      if (FirebaseAuth.isAuthenticated()) {
        const currentUser = FirebaseAuth.getCurrentUser();
        console.log('User already logged in:', currentUser);
        // Optionally redirect to dashboard
      }
    });
  </script>

  <style>
    .error-message {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      border: 1px solid #f5c6cb;
    }
    
    .password-container {
      position: relative;
    }
    
    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
    }
    
    .loading {
      text-align: center;
      color: #3DC1C6;
      margin: 10px 0;
    }
    
    .loading i {
      margin-right: 5px;
    }
    
    button:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }
  </style>
</body>
</html>