<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Confirm Booking</title>
  <link rel="stylesheet" href="/css/global.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/booking_process/css/confirm_booking.css" />
  <link rel="stylesheet" href="/client/css/homepage.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script>window.API_BASE_OVERRIDE = ((window.location && window.location.origin) || '') + '/mock-api';</script>
  <script src="/login_sign up/js/api.js"></script>
  <script src="/client/js/booking-api.js"></script>
</head>
<body>
  <!-- HEADER -->
  <?php include dirname(__DIR__) . "/client/includes/header.php"; ?>
  <script>
    // Require login for confirm booking step: redirect guests to /login
    (function(){
      try {
        var t = localStorage.getItem('haustap_token');
        if (!t) { window.location.href = '/login'; return; }
      } catch(e) { window.location.href = '/login'; return; }
    })();
  </script>
    <main class="confirm-container">
    <div class="confirm-box">
      <img src="/booking_process/images/logo.png" alt="HausTap Logo" class="logo" />
    <div class ="check-icon">
      <i class="fa-solid fa-check-circle check-icon"></i>
    </div>
      <h1 id="confirm-title">Processing your booking…</h1>
      <p id="confirm-status" style="margin-top:8px;color:#555"></p>
      <button class="home-btn">Back To Home</button>
      <a class="bookings-btn" href="/bookings/booking.php" style="display:none;margin-left:8px">View My Bookings</a>
    </div>
  </main>
  <script>
    (function(){
      var titleEl = document.getElementById('confirm-title');
      var statusEl = document.getElementById('confirm-status');
      var homeBtn = document.querySelector('.home-btn');
      var bookingsBtn = document.querySelector('.bookings-btn');
      if (homeBtn) {
        homeBtn.addEventListener('click', function(){ window.location.href = '/client/homepage.php'; });
      }

      function show(msg){ if (statusEl) statusEl.textContent = msg || ''; }

      var token = (typeof HausTapBookingAPI !== 'undefined') ? HausTapBookingAPI.getToken() : (localStorage.getItem('haustap_token') || '');
      var mockMode = (typeof window !== 'undefined') && ((window.API_BASE || '').indexOf('/mock-api') !== -1);
      if (!token && !mockMode) {
        titleEl && (titleEl.textContent = 'Please login to continue');
        show('Redirecting to login…');
        setTimeout(function(){ window.location.href = '/login'; }, 1000);
        return;
      }

      // Collect selections from previous steps
      var providerId = parseInt(localStorage.getItem('selected_provider_id') || '0', 10);
      var providerName = localStorage.getItem('selected_provider_name') || '';
      var scheduledDate = localStorage.getItem('selected_date') || null;
      var scheduledTime = localStorage.getItem('selected_time') || null;
      var serviceName = localStorage.getItem('selected_service_name') || 'General Service';
      var address = localStorage.getItem('booking_address') || null;

      // Minimal guardrails
      if (!providerId) {
        if (mockMode) {
          providerId = 1;
          providerName = providerName || 'Demo Provider';
          show('Preview mode: using a demo provider');
        } else {
          titleEl && (titleEl.textContent = 'Select a provider to proceed');
          show('Redirecting to service provider list…');
          setTimeout(function(){ window.location.href = '/booking/choose-sp'; }, 1000);
          return;
        }
      }
      if (!scheduledDate || !scheduledTime) {
        if (mockMode) {
          var now = new Date();
          var yyyy = now.getFullYear();
          var mm = String(now.getMonth() + 1).padStart(2, '0');
          var dd = String(now.getDate()).padStart(2, '0');
          scheduledDate = yyyy + '-' + mm + '-' + dd;
          scheduledTime = '09:00';
          show('Preview mode: using a demo schedule');
        } else {
          titleEl && (titleEl.textContent = 'Pick a schedule to proceed');
          show('Redirecting to schedule selection…');
          setTimeout(function(){ window.location.href = '/booking/schedule'; }, 1000);
          return;
        }
      }

      var payload = {
        provider_id: providerId,
        service_name: serviceName,
        scheduled_date: scheduledDate,
        scheduled_time: scheduledTime,
        address: (function(){
          var lat = localStorage.getItem('booking_lat');
          var lng = localStorage.getItem('booking_lng');
          if (address && address.trim()) return address;
          if (lat && lng) return (Number(lat).toFixed(5) + ', ' + Number(lng).toFixed(5));
          return '';
        })(),
        lat: (function(){ var v = localStorage.getItem('booking_lat'); return v ? Number(v) : null; })(),
        lng: (function(){ var v = localStorage.getItem('booking_lng'); return v ? Number(v) : null; })(),
        price: (function(){ try { var v = localStorage.getItem('selected_service_price'); return v ? Number(v) : 0; } catch(e){ return 0; } })(),
        notes: providerName ? ('Booked with ' + providerName) : 'Created via web booking flow',
      };

      titleEl && (titleEl.textContent = 'Creating your booking…');
      show('Please wait while we submit to the server');

      if (typeof HausTapBookingAPI === 'undefined') {
        titleEl && (titleEl.textContent = 'Thank You For Booking!');
        show('Preview mode: API helper not loaded.');
        // Allow user to navigate to Bookings page even in preview mode
        if (bookingsBtn) { bookingsBtn.style.display = 'inline-block'; }
        return;
      }

      HausTapBookingAPI.createBooking(payload)
        .then(function(resp){
          titleEl && (titleEl.textContent = 'Thank You For Booking!');
          var bookingId = null;
          try {
            bookingId = (resp && resp.data && (resp.data.id || (resp.data.booking && resp.data.booking.id)))
              || (resp && (resp.id || resp.booking_id))
              || null;
          } catch(e) { bookingId = null; }
          var msg = 'Booking created successfully.';
          if (bookingId) { msg = 'Booking created successfully. Booking ID: #' + bookingId; }
          show(msg);
          try {
            localStorage.removeItem('selected_date');
            localStorage.removeItem('selected_time');
            localStorage.removeItem('selected_provider_id');
            localStorage.removeItem('selected_provider_name');
            if (bookingId) {
              localStorage.setItem('last_booking_id', String(bookingId));
            }
          } catch {}

          // Reveal Bookings CTA and deep-link to the new booking
          if (bookingsBtn) {
            if (bookingId) {
              bookingsBtn.setAttribute('href', '/bookings/booking.php?focus=' + encodeURIComponent(bookingId));
            }
            bookingsBtn.style.display = 'inline-block';
          }
        })
        .catch(function(err){
          var msg = (err && err.message) || 'Failed to create booking';
          titleEl && (titleEl.textContent = 'Could not complete booking');
          show(msg + '. Please try again later.');
          // Still allow user to check Bookings page
          if (bookingsBtn) { bookingsBtn.style.display = 'inline-block'; }
        });
    })();
  </script>
 </body>

