<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up | HausTap</title>
  <link rel="stylesheet" href="/css/global.css">
  <link rel="stylesheet" href="/login_sign%20up/css/sign%20up.css">
<link rel="stylesheet" href="/client/css/homepage.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<style>
  /* Minimal styles for OTP overlay */
  .otp-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 9999; }
  .otp-modal { background: #fff; width: 100%; max-width: 420px; border-radius: 8px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
  .otp-modal h3 { margin: 0 0 8px; }
  .otp-modal p { margin: 0 0 12px; color: #444; }
  .otp-input { letter-spacing: 6px; font-size: 20px; text-align: center; padding: 10px; width: 100%; box-sizing: border-box; }
  .otp-actions { margin-top: 14px; display: flex; gap: 8px; }
  .otp-actions button { flex: 1; padding: 10px; border: none; border-radius: 6px; cursor: pointer; }
  .btn-primary { background: #1db7a6; color: #fff; }
  .btn-secondary { background: #eee; }
  .otp-hint { font-size: 12px; color: #888; margin-top: 6px; }
</style>
<body>
  <div class="container">
    <div class="logo">
      <img src="/login_sign%20up/image/logo.png" alt="HausTap Logo" width="120" height="100">
    </div>
    <form class="signup-form">
      <h2>Sign Up</h2>
      <div class="row">
        <div>
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" name="firstName" required>
        </div>
        <div>
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="lastName" required>
        </div>
      </div>
      <div class="row">
        <div>
          <label for="birthMonth">Birth Month</label>
          <input type="number" id="birthMonth" name="birthMonth" min="1" max="12" required>
        </div>
        <div>
          <label for="birthDay">Day</label>
          <input type="number" id="birthDay" name="birthDay" min="1" max="31" required>
        </div>
        <div>
          <label for="birthYear">Year</label>
          <input type="number" id="birthYear" name="birthYear" min="1900" max="2025" required>
        </div>
      </div>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      <label for="mobile">Mobile Number</label>
      <input type="text" id="mobile" name="mobile" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required>
      <button type="submit">Sign Up</button>
      <div class="login-link">
        Already have an account? <a href="/login">Login</a>
      </div>
      <button type="button" class="partner-btn">Become a HausTap Partner</button>
    </form>
    <!-- OTP Modal -->
    <div class="otp-overlay" id="otpOverlay" role="dialog" aria-modal="true" aria-labelledby="otpTitle">
      <div class="otp-modal">
        <h3 id="otpTitle">Verify your account</h3>
        <p id="otpDesc">Enter the 6-digit code we sent to your contact.</p>
        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" class="otp-input" id="otpCode" placeholder="••••••" aria-label="OTP code">
        <div class="otp-actions">
          <button class="btn-secondary" type="button" id="otpResend">Resend Code</button>
          <button class="btn-primary" type="button" id="otpVerify">Verify</button>
        </div>
        <div class="otp-hint" id="otpHint"></div>
      </div>
    </div>
  </div>
   <!-- FOOTER -->
<?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>
<script src="/login_sign%20up/js/api.js"></script>
  <script>
    (function() {
      const form = document.querySelector('.signup-form');
      if (!form) return;

      // OTP elements
      const otpOverlay = document.getElementById('otpOverlay');
      const otpCodeEl = document.getElementById('otpCode');
      const otpResendBtn = document.getElementById('otpResend');
      const otpVerifyBtn = document.getElementById('otpVerify');
      const otpDesc = document.getElementById('otpDesc');
      const otpHint = document.getElementById('otpHint');
      let currentOtpId = null;
      let pendingUser = null;
      let pendingToken = null;

      // Navigate to Application Form when "Become a HausTap Partner" is clicked
      const partnerBtn = document.querySelector('.partner-btn');
      if (partnerBtn) {
        partnerBtn.addEventListener('click', function() {
          // Route to the web application form that includes Individual and Team
          window.location.href = '/Application_Individual/application_form.php';
        });
      }

      form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const firstName = document.getElementById('firstName').value.trim();
        const lastName = document.getElementById('lastName').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const mobile = document.getElementById('mobile').value.trim();

        const birthMonth = document.getElementById('birthMonth').value;
        const birthDay = document.getElementById('birthDay').value;
        const birthYear = document.getElementById('birthYear').value;

        const payload = {
          firstName,
          lastName,
          email,
          password,
          confirmPassword,
          mobile,
          birthMonth,
          birthDay,
          birthYear
        };

        // Client-side validations before hitting backend/OTP
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const mobilePattern = /^\+?[0-9]{10,15}$/; // simple international format
        const toInt = (v) => parseInt(v, 10);
        const m = toInt(birthMonth), d = toInt(birthDay), y = toInt(birthYear);
        const isValidDate = (yy, mm, dd) => {
          if (!yy || !mm || !dd) return false;
          const dt = new Date(yy, mm - 1, dd);
          return dt.getFullYear() === yy && (dt.getMonth() + 1) === mm && dt.getDate() === dd;
        };
        if (!firstName) { alert('First name is required.'); return; }
        if (!lastName) { alert('Last name is required.'); return; }
        if (!email || !emailPattern.test(email)) { alert('Please enter a valid email address.'); return; }
        if (!mobile || !mobilePattern.test(mobile)) { alert('Please enter a valid mobile number (10-15 digits).'); return; }
        if (!password || password.length < 6) { alert('Password must be at least 6 characters.'); return; }
        if (password !== confirmPassword) { alert('Passwords do not match.'); return; }
        if (!isValidDate(y, m, d)) { alert('Please enter a valid birth date.'); return; }

        try {
          const res = await fetch(`${window.API_BASE}/auth/register`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });

          // Try to parse JSON safely; support HTML responses too
          let data;
          const ct = res.headers.get('content-type') || '';
          if (ct.includes('application/json')) {
            data = await res.json();
          } else {
            const text = await res.text();
            try { data = JSON.parse(text); } catch { data = { message: text }; }
          }

          if (res.status === 201 || res.ok) {
            // Hold onto user/token until OTP is verified
            pendingToken = data?.token || null;
            const userFromApi = data?.user;
            pendingUser = userFromApi || {
              name: `${firstName} ${lastName}`.trim(),
              firstName,
              lastName,
              email,
              mobile,
              dob: `${birthMonth}/${birthDay}/${birthYear}`,
              role: { name: 'client' }
            };

            // Request OTP
            const sendRes = await fetch(`${window.API_BASE}/auth/otp/send`, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ email, mobile })
            });
            let sendData;
            const sendCt = sendRes.headers.get('content-type') || '';
            if (sendCt.includes('application/json')) sendData = await sendRes.json();
            else { const t = await sendRes.text(); try { sendData = JSON.parse(t); } catch { sendData = { message: t }; } }

            if (!sendRes.ok || !sendData?.success) {
              alert(sendData?.message || 'Failed to send OTP');
              return;
            }
            currentOtpId = sendData.otpId;
            const masked = sendData.masked || email || mobile || '';
            otpDesc.textContent = `Enter the 6-digit code sent to ${masked}.`;
            otpHint.textContent = sendData.devCode ? `(For testing, use ${sendData.devCode})` : '';
            otpCodeEl.value = '';
            otpOverlay.style.display = 'flex';
            otpCodeEl.focus();
            return;
          }

          console.error('Registration failed:', data);
          alert('Registration failed. Please check your details.');
        } catch (err) {
          console.error('Network error:', err);
          alert('Network error. Please try again.');
        }
      });

      // Resend OTP
      otpResendBtn?.addEventListener('click', async function() {
        if (!pendingUser) return;
        try {
          const sendRes = await fetch(`${window.API_BASE}/auth/otp/send`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: pendingUser.email, mobile: pendingUser.mobile })
          });
          let sendData = await sendRes.json().catch(async () => { const t = await sendRes.text(); try { return JSON.parse(t); } catch { return { message: t }; } });
          if (!sendRes.ok || !sendData?.success) { alert(sendData?.message || 'Failed to resend OTP'); return; }
          currentOtpId = sendData.otpId;
          otpHint.textContent = sendData.devCode ? `(For testing, use ${sendData.devCode})` : '';
          alert('OTP resent. Please check again.');
        } catch (err) {
          console.error('Resend OTP error:', err);
          alert('Network error. Please try again.');
        }
      });

      // Verify OTP
      otpVerifyBtn?.addEventListener('click', async function() {
        const code = (otpCodeEl?.value || '').trim();
        if (code.length !== 6) { alert('Enter the 6-digit code.'); return; }
        try {
          const vRes = await fetch(`${window.API_BASE}/auth/otp/verify`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ otpId: currentOtpId, code })
          });
          let vData = await vRes.json().catch(async () => { const t = await vRes.text(); try { return JSON.parse(t); } catch { return { message: t }; } });
          if (!vRes.ok || !vData?.success) { alert(vData?.message || 'Invalid OTP'); return; }

          // Persist after successful verification
          if (pendingToken) localStorage.setItem('haustap_token', pendingToken);
          if (pendingUser) {
            try { localStorage.setItem('haustap_user', JSON.stringify(pendingUser)); } catch {}
          }

          otpOverlay.style.display = 'none';
          window.location.href = '../my_account/my_account.php';
        } catch (err) {
          console.error('Verify OTP error:', err);
          alert('Network error. Please try again.');
        }
      });
    })();
  </script>
</body>
</html>

