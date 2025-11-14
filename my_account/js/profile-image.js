(function(){
  function initProfileImage() {
    var selectBtn = document.getElementById('selectImageBtn');
    var fileInput = document.getElementById('profileFileInput');
    var wrap = document.getElementById('profileImageWrap');
    if (!selectBtn || !fileInput || !wrap) return;

    var MAX_BYTES = 3 * 1024 * 1024; // 3MB
    var ACCEPTED = ['image/jpeg','image/png'];

    selectBtn.addEventListener('click', function(e){
      e.preventDefault();
      fileInput.click();
    });

    // If there's a saved image URL in localStorage, show it on load
    try {
      var saved = localStorage.getItem('profile_image_url');
      if (saved) {
        wrap.innerHTML = '';
        var img0 = document.createElement('img');
        img0.src = saved;
        img0.alt = 'Profile image';
        img0.style.width = '96px';
        img0.style.height = '96px';
        img0.style.objectFit = 'cover';
        img0.style.borderRadius = '50%';
        wrap.appendChild(img0);
      }
    } catch(e) {}

    fileInput.addEventListener('change', function(){
      var f = fileInput.files && fileInput.files[0];
      if (!f) return;

      // Validate type
      if (ACCEPTED.indexOf(f.type) === -1) {
        var msg = 'Invalid file type. Please choose a JPEG or PNG image.';
        if (window.htToast && typeof window.htToast.error === 'function') window.htToast.error(msg);
        else alert(msg);
        fileInput.value = '';
        return;
      }

      // Validate size
      if (f.size > MAX_BYTES) {
        var msg2 = 'File is too large. Maximum allowed size is 3MB.';
        if (window.htToast && typeof window.htToast.error === 'function') window.htToast.error(msg2);
        else alert(msg2);
        fileInput.value = '';
        return;
      }

      // Preview
      try {
        var url = URL.createObjectURL(f);
        wrap.innerHTML = '';
        var img = document.createElement('img');
        img.src = url;
        img.alt = 'Profile image';
        img.style.width = '96px';
        img.style.height = '96px';
        img.style.objectFit = 'cover';
        img.style.borderRadius = '50%';
        wrap.appendChild(img);
      } catch (e) {
        console.error('preview error', e);
      }

      // Upload to server endpoint
      (function uploadFile(file){
        try {
          var form = new FormData();
          form.append('profile_image', file);
          // Post to server-side handler we added
          fetch('/my_account/upload-profile-image.php', {
            method: 'POST',
            body: form
          }).then(function(res){
            if (!res.ok) throw new Error('Upload failed');
            return res.json().catch(function(){ return {}; });
          }).then(function(json){
            var msg = 'Profile image uploaded.';
            if (json && json.url) {
              try { localStorage.setItem('profile_image_url', json.url); } catch(e){}
            }
            if (window.htToast && typeof window.htToast.success === 'function') window.htToast.success(msg);
            else console.log(msg, json);
          }).catch(function(err){
            console.warn('upload error', err);
            var msg = 'Upload failed. (This may be expected if no backend is available)';
            if (window.htToast && typeof window.htToast.error === 'function') window.htToast.error(msg);
            else console.warn(msg);
          });
        } catch (e) { console.error(e); }
      })(f);
    });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initProfileImage);
  else initProfileImage();
})();