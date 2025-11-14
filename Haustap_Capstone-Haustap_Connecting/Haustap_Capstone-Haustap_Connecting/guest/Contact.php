<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact - HausTap</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="/css/global.css" />
  <link rel="stylesheet" href="css/homepage.css" />
  <link rel="stylesheet" href="css/contact.css" />

</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

  <!-- MAIN SECTION -->
  <section class="contact-section">
    <div class="tab-container">
      <div class="tabs">
        <button class="tab active">Chat</button>
        <button class="tab">Connect Haustap with</button>
      </div>

      <div class="tab-content chat-tab active">
        <div class="chat-box">
          <p>No messages</p>
        </div>
      </div>

      <div class="tab-content connect-tab">
        <div class="social-icons">
          <div class="social-card">
            <a href="https://www.facebook.com/profile.php?id=61583010005975" target="_blank" rel="noopener noreferrer">
              <img src="images/facebook.png" alt="Facebook">
            </a>
            <a href="https://www.facebook.com/profile.php?id=61583010005975" target="_blank" rel="noopener noreferrer">Facebook page</a>
          </div>
          <div class="social-card">
            <a href="https://www.instagram.com/haustap.ph/" target="_blank" rel="noopener noreferrer">
              <img src="images/instagram.png" alt="Instagram">
            </a>
            <a href="https://www.instagram.com/haustap.ph/" target="_blank" rel="noopener noreferrer">Instagram page</a>
          </div>
          <div class="social-card">
            <img src="images/twitter.png" alt="X">
            <a href="#">X</a>
          </div>
        </div>

        <p class="email-text">Or send us your concern via email:</p>

        <div class="contact-info">
          <h4>Contact Us</h4>
          <p>Email: <a href="mailto:haustap_ph@gmail.com">haustap_ph@gmail.com</a></p>
          <p>Phone: 09451234521</p>
          <p>Phone: 09264502561</p>
          <p>Address: 29 San Pedro, Laguna City of Sta Rosa, Laguna</p>
          <p>If you have any questions or feedback, feel free to reach out!</p>
        </div>
  </div>
    </div>
  </section>


  <script>
    // Tab switching functionality
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach((tab, index) => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));
        tab.classList.add('active');
        contents[index].classList.add('active');
      });
    });
  </script>
  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>

