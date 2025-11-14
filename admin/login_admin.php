<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Haustap Login</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="images/logo.png" alt="Haustap Logo">
    </div>

    <div class="login-box">
      <form>
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Enter your password" required>

        <div class="remember">
          <input type="checkbox" id="remember">
          <label for="remember">Remember me</label>
        </div>

        <button type="submit" class="login-btn">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
