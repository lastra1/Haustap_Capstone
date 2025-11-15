# 🚀 HausTap Complete Deployment Guide
# Android App + Website + API Backend

## 📱 What You'll Get:
- ✅ **Laravel API Backend** - Live URL for mobile app
- ✅ **PHP Web Frontend** - Full website for browsers
- ✅ **Android App Support** - API endpoints configured for mobile
- ✅ **Cross-Platform CORS** - Works on all devices

---

## 🎯 Deployment Strategy

### Service Architecture:
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Android App   │    │  Web Browser    │    │   iOS App      │
│   (React Native)│    │   (PHP Website) │    │   (Future)     │
└─────────┬───────┘    └─────────┬───────┘    └─────────┬───────┘
          │                      │                      │
          │ API Calls            │ Web Requests          │ API Calls
          │                      │                      │
          └──────────────────────┼──────────────────────┘
                                 │
                    ┌─────────────┴─────────────┐
                    │   Laravel API Backend     │
                    │   (Render Deployment)     │
                    └───────────────────────────┘
```

---

## 🚀 Step 1: Deploy API Backend (First Priority)

### Option A: Render (Recommended - Fastest)
1. **Go to** [Render.com](https://render.com)
2. **Connect GitHub** → Select your repo
3. **Use** `render-multi-service.yaml` configuration
4. **Deploy** → Get URL: `https://haustap-api.onrender.com`

### Option B: Railway (Alternative)
```bash
npm install -g @railway/cli
railway login
railway up
```

---

## 📱 Step 2: Configure Android App

### Update API Configuration:
1. **Copy** `mobile-app-config.js` to your React Native app
2. **Update** the production URLs:
```javascript
// In your React Native app
PROD_API_URL: 'https://your-api-domain.com/api',
PROD_WEB_URL: 'https://your-web-domain.com',
```

### Update Your API Calls:
```javascript
// Before (Local development)
fetch('http://localhost:8000/api/auth/login')

// After (Production)
fetch('https://haustap-api.onrender.com/api/v2/auth/login')
```

### Test Mobile App Endpoints:
```bash
# Health Check
curl https://your-api.onrender.com/api/health

# Authentication
curl -X POST https://your-api.onrender.com/api/v2/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

---

## 🌐 Step 3: Deploy Web Frontend

### PHP Website Deployment:
1. **Use** the web service in `render-multi-service.yaml`
2. **Configure** API base URL in your PHP files:
```php
<?php
// In your PHP configuration file
$API_BASE_URL = 'https://haustap-api.onrender.com/api';
$WEB_BASE_URL = 'https://haustap-web.onrender.com';
?>
```

### Update JavaScript API Calls:
```javascript
// Update your web frontend JavaScript
const API_BASE_URL = 'https://haustap-api.onrender.com/api';

// Example API call
fetch(`${API_BASE_URL}/bookings`, {
  method: 'GET',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  }
});
```

---

## 🔧 Step 4: Cross-Platform Configuration

### CORS Settings (Already Configured):
Your Laravel API is configured to accept requests from:
- ✅ **Android Apps** (`capacitor://localhost`)
- ✅ **iOS Apps** (`ionic://localhost`)
- ✅ **Web Browsers** (`https://*.onrender.com`)
- ✅ **Local Development** (`http://localhost:*`)

### Environment Variables:
```bash
# API Backend
APP_URL=https://haustap-api.onrender.com
FRONTEND_URL=https://haustap-web.onrender.com
MOBILE_APP_URL=https://haustap-mobile.onrender.com

# Web Frontend
API_BASE_URL=https://haustap-api.onrender.com
WEB_BASE_URL=https://haustap-web.onrender.com
```

---

## 📋 Step 5: Testing Checklist

### ✅ API Backend Tests:
```bash
# Health check
curl https://your-api.onrender.com/api/health

# Authentication flow
curl -X POST https://your-api.onrender.com/api/v2/auth/register

# Mobile-specific endpoints
curl https://your-api.onrender.com/api/v2/notifications
```

### ✅ Web Frontend Tests:
```bash
# Website accessibility
curl https://haustap-web.onrender.com

# API integration
curl https://haustap-web.onrender.com/api-test.php
```

### ✅ Mobile App Tests:
```javascript
// In your React Native app
const testConnection = async () => {
  try {
    const response = await fetch('https://your-api.onrender.com/api/health');
    const data = await response.json();
    console.log('API Connection:', data);
  } catch (error) {
    console.error('Connection failed:', error);
  }
};
```

---

## 🎯 Final URLs (Example):
```
🌐 Website:     https://haustap-web.onrender.com
📱 API:          https://haustap-api.onrender.com/api
🔄 Health Check: https://haustap-api.onrender.com/api/health
📖 API Docs:     https://haustap-api.onrender.com/api/v2/docs
```

---

## 🆘 Troubleshooting

### Common Issues:

1. **CORS Errors:**
   - Check `config/cors.php` settings
   - Verify your domain is in allowed origins

2. **Mobile App Connection Failed:**
   - Update API URLs in mobile config
   - Check internet permissions in AndroidManifest.xml

3. **Website API Calls Failing:**
   - Verify CORS headers in browser console
   - Check API base URL in JavaScript files

4. **Render Deployment Issues:**
   - Check deployment logs in Render dashboard
   - Verify all environment variables are set

### Support Commands:
```bash
# Check API health
curl https://your-api.onrender.com/api/health

# Test CORS
curl -H "Origin: https://your-web-domain.com" \
     -H "Access-Control-Request-Method: POST" \
     -H "Access-Control-Request-Headers: X-Requested-With" \
     -X OPTIONS https://your-api.onrender.com/api/health
```

---

## 🎉 Success!
Once deployed, you'll have:
- ✅ **Live API** for Android app
- ✅ **Live Website** for browsers  
- ✅ **Cross-platform support** for all devices
- ✅ **Automatic scaling** based on traffic
- ✅ **Free SSL certificates** on all platforms

**Ready to deploy? Start with Step 1 and get your live URLs in under 10 minutes!** 🚀