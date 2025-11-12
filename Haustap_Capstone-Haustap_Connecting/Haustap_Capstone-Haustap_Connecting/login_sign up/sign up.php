<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up | HausTap</title>
  <link rel="stylesheet" href="/css/global.css">
  <link rel="stylesheet" href="/login_sign%20up/css/sign%20up.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    .consent { margin-top: 12px; background:#f8f8f8; border:1px solid #e3e3e3; padding:10px; border-radius:8px }
    .consent-item { display:flex; align-items:flex-start; gap:8px; margin:6px 0 }
    .consent-item input[type="checkbox"] { margin-top:2px }
    .consent small { display:block; color:#666 }
    .doc-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 9998 }
    .doc-modal { background: #fff; width: 100%; max-width: 720px; height: 80vh; border-radius: 8px; padding: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); display:flex; flex-direction:column }
    .doc-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px }
    .doc-title { font-weight:700 }
    .doc-frame { flex:1; width: 100%; border: 1px solid #e3e3e3; border-radius:6px }
    .doc-actions { display:flex; gap:8px; justify-content:flex-end; margin-top:8px }
    .doc-btn { padding:8px 12px; border:none; border-radius:6px; cursor:pointer }
    .doc-btn.primary { background:#1db7a6; color:#fff }
    .doc-btn.secondary { background:#eee }
  </style>
</head>
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
      <div class="consent" aria-label="User consent">
        <div class="consent-item">
          <input type="checkbox" id="agreeTerms" aria-required="true" disabled>
          <label for="agreeTerms">I have read and agree to the <a href="/client/terms.php" target="_blank" rel="noopener" id="openTerms">Terms &amp; Conditions</a>.</label>
        </div>
        <div class="consent-item">
          <input type="checkbox" id="agreePrivacy" aria-required="true" disabled>
          <label for="agreePrivacy">I have read and agree to the <a href="/my_account/privacy_settings.php" target="_blank" rel="noopener" id="openPrivacy">Privacy Policy</a>.</label>
        </div>
        <small>To enable the checkboxes, open and review the linked documents.</small>
      </div>
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
    <div class="doc-overlay" id="termsOverlay" role="dialog" aria-modal="true" aria-labelledby="termsTitle">
      <div class="doc-modal">
        <div class="doc-header"><div class="doc-title" id="termsTitle">Terms &amp; Conditions</div><button type="button" class="doc-btn secondary" id="closeTerms">Close</button></div>
        <iframe class="doc-frame" src="/client/terms.php"></iframe>
        <div class="doc-actions"><button type="button" class="doc-btn primary" id="agreeInModalTerms">I Agree</button></div>
      </div>
    </div>
    <div class="doc-overlay" id="privacyOverlay" role="dialog" aria-modal="true" aria-labelledby="privacyTitle">
      <div class="doc-modal">
        <div class="doc-header"><div class="doc-title" id="privacyTitle">Privacy Policy</div><button type="button" class="doc-btn secondary" id="closePrivacy">Close</button></div>
        <iframe class="doc-frame" src="/my_account/privacy_settings.php"></iframe>
        <div class="doc-actions"><button type="button" class="doc-btn primary" id="agreeInModalPrivacy">I Agree</button></div>
      </div>
    </div>
  </div>
   <!-- FOOTER -->
<?php include dirname(__DIR__) . "/client/includes/footer.php"; ?>
<script>
  // Ensure signup targets the Laravel backend API
  window.API_TARGET = 'backend';
</script>
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
      let apiBaseUsed = window.API_BASE;
      let isMock = typeof apiBaseUsed === 'string' && apiBaseUsed.indexOf('/mock-api') !== -1;
      let termsOpened = false;
      let privacyOpened = false;

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

        const name = `${firstName} ${lastName}`.trim();
        const payload = {
          name,
          email,
          password,
          confirmPassword,
          // Keep extra fields for client-side use (ignored by backend)
          firstName,
          lastName,
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
        if (!termsOpened) { alert('Please open and read the Terms & Conditions.'); return; }
        if (!privacyOpened) { alert('Please open and read the Privacy Policy.'); return; }
        if (!agreeTermsEl?.checked) { alert('You must agree to the Terms & Conditions to sign up.'); return; }
        if (!agreePrivacyEl?.checked) { alert('You must agree to the Privacy Policy to sign up.'); return; }

        try {
          // First attempt: backend API
          let res = await fetch(`${window.API_BASE}/auth/register`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });

          // Try to parse JSON safely; support HTML responses too
          let data;
          let ct = res.headers.get('content-type') || '';
          if (ct.includes('application/json')) {
            data = await res.json();
          } else {
            const text = await res.text();
            try { data = JSON.parse(text); } catch { data = { message: text }; }
          }

          // If backend is not available (404), fall back to mock API
          if (!res.ok && res.status === 404) {
            const origin = (window.location && window.location.origin) || '';
            const altBase = origin ? origin + '/mock-api' : '/mock-api';
            try {
              const res2 = await fetch(`${altBase}/auth/register`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
              });
              ct = res2.headers.get('content-type') || '';
              if (ct.includes('application/json')) { data = await res2.json(); }
              else { const t2 = await res2.text(); try { data = JSON.parse(t2); } catch { data = { message: t2 }; } }
              if (res2.ok) { apiBaseUsed = altBase; isMock = true; res = res2; }
            } catch (e) {
              // keep original 404 error
            }
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
            const sendRes = await fetch(`${apiBaseUsed}/auth/otp/send`, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ email })
            });
            let sendData;
            const sendCt = sendRes.headers.get('content-type') || '';
            if (sendCt.includes('application/json')) sendData = await sendRes.json();
            else { const t = await sendRes.text(); try { sendData = JSON.parse(t); } catch { sendData = { message: t }; } }

            if (!sendRes.ok || !sendData?.success) {
              alert(sendData?.message || 'Failed to send OTP');
              return;
            }
            // Capture mock-specific fields if present
            currentOtpId = sendData.otpId || null;
            const masked = (sendData.masked || email || mobile || '').trim();
            otpDesc.textContent = `Enter the 6-digit code sent to ${masked}.`;
            const devCode = sendData.dev_code || sendData.devCode;
            otpHint.textContent = devCode ? `(For testing, use ${devCode})` : '';
            otpCodeEl.value = '';
            otpOverlay.style.display = 'flex';
            otpCodeEl.focus();
            return;
          }

          console.error('Registration failed:', data);
          var errMap = (data && data.errors && typeof data.errors === 'object') ? data.errors : {};
          var messages = [];
          for (var key in errMap) {
            if (!Object.prototype.hasOwnProperty.call(errMap, key)) continue;
            var arr = errMap[key];
            if (Array.isArray(arr)) {
              for (var i = 0; i < arr.length; i++) {
                messages.push((key + ': ' + String(arr[i])).trim());
              }
            } else if (typeof arr === 'string') {
              messages.push((key + ': ' + arr).trim());
            }
          }
          var msgText = (data && data.message) ? String(data.message) : (messages.length ? messages.join('\n') : 'Registration failed. Please check your details.');
          alert(msgText);
          var lowerText = msgText.toLowerCase();
          if (lowerText.includes('already registered')) {
            if (confirm('This email is already registered. Go to Login page now?')) {
              window.location.href = '/login';
            }
          }
        } catch (err) {
          console.error('Network error:', err);
          alert('Network error. Please try again.');
        }
      });

      // Resend OTP
      otpResendBtn?.addEventListener('click', async function() {
        if (!pendingUser) return;
        try {
          const sendRes = await fetch(`${apiBaseUsed}/auth/otp/send`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: pendingUser.email })
          });
          let sendData = await sendRes.json().catch(async () => { const t = await sendRes.text(); try { return JSON.parse(t); } catch { return { message: t }; } });
          if (!sendRes.ok || !sendData?.success) { alert(sendData?.message || 'Failed to resend OTP'); return; }
          currentOtpId = sendData.otpId || currentOtpId;
          const devCode = sendData.dev_code || sendData.devCode;
          otpHint.textContent = devCode ? `(For testing, use ${devCode})` : '';
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
          const payload = (isMock && currentOtpId) ? { otpId: currentOtpId, code } : { email: pendingUser?.email || '', code };
          const vRes = await fetch(`${apiBaseUsed}/auth/otp/verify`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });
          let vData = await vRes.json().catch(async () => { const t = await vRes.text(); try { return JSON.parse(t); } catch { return { message: t }; } });
          if (!vRes.ok || !vData?.success) { alert(vData?.message || 'Invalid OTP'); return; }

          // Persist after successful verification
          const token = vData?.token || pendingToken;
          if (token) localStorage.setItem('haustap_token', token);
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

      // Require users to open Terms and Privacy before agreeing
      const agreeTermsEl = document.getElementById('agreeTerms');
      const agreePrivacyEl = document.getElementById('agreePrivacy');
      const openTermsLink = document.getElementById('openTerms');
      const openPrivacyLink = document.getElementById('openPrivacy');
      const termsOverlay = document.getElementById('termsOverlay');
      const privacyOverlay = document.getElementById('privacyOverlay');
      const closeTermsBtn = document.getElementById('closeTerms');
      const closePrivacyBtn = document.getElementById('closePrivacy');
      const agreeModalTermsBtn = document.getElementById('agreeInModalTerms');
      const agreeModalPrivacyBtn = document.getElementById('agreeInModalPrivacy');
      if (openTermsLink) {
        openTermsLink.addEventListener('click', function(ev){ ev.preventDefault(); termsOpened = true; if (agreeTermsEl) agreeTermsEl.disabled = false; if (termsOverlay) termsOverlay.style.display = 'flex'; });
      }
      if (openPrivacyLink) {
        openPrivacyLink.addEventListener('click', function(ev){ ev.preventDefault(); privacyOpened = true; if (agreePrivacyEl) agreePrivacyEl.disabled = false; if (privacyOverlay) privacyOverlay.style.display = 'flex'; });
      }
      if (closeTermsBtn && termsOverlay) { closeTermsBtn.addEventListener('click', function(){ termsOverlay.style.display = 'none'; }); }
      if (closePrivacyBtn && privacyOverlay) { closePrivacyBtn.addEventListener('click', function(){ privacyOverlay.style.display = 'none'; }); }
      if (agreeModalTermsBtn && termsOverlay && agreeTermsEl) { agreeModalTermsBtn.addEventListener('click', function(){ agreeTermsEl.checked = true; termsOverlay.style.display = 'none'; }); }
      if (agreeModalPrivacyBtn && privacyOverlay && agreePrivacyEl) { agreeModalPrivacyBtn.addEventListener('click', function(){ agreePrivacyEl.checked = true; privacyOverlay.style.display = 'none'; }); }
