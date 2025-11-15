# HausTap Mobile App Build Guide

## 🚨 Current Status: Disk Space Issue

Your system is currently experiencing disk space constraints that prevent building the mobile app. Here's what you need to know:

## ✅ API Configuration Complete

Your mobile app has been successfully configured with the live API URL:

```javascript
// Updated in HausTap.tsx
const API_URL = 'https://us-central1-haustap-booking-system.cloudfunctions.net/api';
```

**Updated Files:**
- `android-capstone-main/HausTap/app/HausTap.tsx` - Main API URL updated
- `android-capstone-main/HausTap/app.config.ts` - Configuration updated
- `android-capstone-main/HausTap/.env` - Environment file created
- `android-capstone-main/HausTap/eas.json` - Build configuration updated

## 🏗️ Build Options

### Option 1: Development Mode (Immediate Testing)
```bash
cd android-capstone-main/HausTap
npm install
npx expo start
```

### Option 2: Local APK Build (When Disk Space Available)
```bash
# Install EAS CLI (when space available)
npm install -g eas-cli

# Build APK
eas build -p android --profile client
```

### Option 3: Cloud Build (Recommended)
```bash
# Use Expo's cloud build service
eas build -p android --profile client --non-interactive
```

## 📱 Testing the API Connection

### Test Local API (Currently Running)
```bash
# Test local Laravel API
curl http://localhost:8001/api/health

# Test local Node.js server
curl http://localhost:3000/api/send-otp \
  -X POST \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","otp":"123456"}'
```

### Test Live Firebase Functions (When Deployed)
```bash
# Test live API
curl https://us-central1-haustap-booking-system.cloudfunctions.net/api/health
```

## 🔧 Current Running Services

**Local Services (Ready for Testing):**
- Laravel API: `http://localhost:8001` ✅ Running
- Node.js Server: `http://localhost:3000` ✅ Running
- MySQL Database: `localhost:3307` ✅ Running (23 tables)

## 📋 Next Steps When Space Available

1. **Free up disk space** (delete node_modules, temp files, etc.)
2. **Install dependencies**: `npm install`
3. **Test in development**: `npx expo start`
4. **Build APK**: `eas build -p android`

## 🌐 Live URLs Ready

**Firebase Functions API:** `https://us-central1-haustap-booking-system.cloudfunctions.net/api`
**Local Laravel API:** `http://localhost:8001`
**Local Node.js Server:** `http://localhost:3000`

Your mobile app is configured and ready to connect to your APIs! The configuration is complete - you just need to resolve the disk space issue to build the APK.