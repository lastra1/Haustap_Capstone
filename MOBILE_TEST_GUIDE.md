# HausTap Mobile App Testing Guide

## ✅ Current Status: Ready for Testing

Your mobile app configuration is complete! Here's how to test it:

## 🔧 API Configuration Verified

**Updated API URLs:**
- ✅ Main API: `https://us-central1-haustap-booking-system.cloudfunctions.net/api`
- ✅ Local Laravel: `http://localhost:8001`
- ✅ Local Node.js: `http://localhost:3000`

## 📱 Testing Options

### Option 1: Development Mode (Immediate)
```bash
cd android-capstone-main/HausTap
npx expo start --web
```
Then open: `http://localhost:19000` in your browser

### Option 2: Mobile Device Testing
```bash
cd android-capstone-main/HausTap
npx expo start --tunnel
```
Scan QR code with Expo Go app

### Option 3: Android Emulator
```bash
cd android-capstone-main/HausTap
npx expo start --android
```

## 🧪 Test the API Connection

### Test 1: Local Laravel API (Running on Port 8001)
```bash
curl http://localhost:8001/api/health
```

### Test 2: Local Node.js OTP Server (Running on Port 3000)
```bash
curl -X POST http://localhost:3000/api/send-otp \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","otp":"123456"}'
```

### Test 3: Mobile App Registration Flow
1. Start development server: `npx expo start --web`
2. Open browser to development URL
3. Test sign-up with email verification
4. Check OTP email functionality

## 📊 Current Running Services

| Service | Port | Status | URL |
|---------|------|--------|-----|
| Laravel API | 8001 | ✅ Running | http://localhost:8001 |
| Node.js Server | 3000 | ✅ Running | http://localhost:3000 |
| MySQL Database | 3307 | ✅ Running | localhost:3307 |
| Expo Dev Server | 19000 | 🔄 Ready | http://localhost:19000 |

## 🎯 Next Steps

1. **Test Development Mode**: Run `npx expo start --web`
2. **Verify API Connection**: Test OTP email functionality
3. **Build APK Later**: When disk space available, run `eas build -p android`

## 🔍 Troubleshooting

**If API calls fail:**
- Check if local servers are running (ports 8001, 3000)
- Verify network connectivity
- Check CORS settings in your API

**If Expo fails to start:**
- Try different port: `npx expo start --port 19001`
- Clear cache: `npx expo start --clear`
- Check for port conflicts

**Your mobile app is ready to test!** 🚀