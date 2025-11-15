# 🚀 HausTap MySQL + Firebase/Google Cloud Deployment Guide
# Architecture: MySQL Docker Database + Firebase/Google Cloud Server Infrastructure

## 🏗️ Architecture Overview:
```
┌─────────────────────────────────────────────────────────────┐
│                    CLIENT DEVICES                          │
├─────────────────┬─────────────────┬──────────────────────┤
│  Android App    │  Web Browser    │    iOS App          │
│  (React Native) │  (PHP Website)  │    (Future)         │
└─────────┬───────┴─────────┬───────┴──────────┬────────────┘
          │                 │                  │
          │ API Calls        │ Web Requests     │ API Calls
          │                 │                  │
          └─────────────────┼──────────────────┘
                            │
┌───────────────────────────┴──────────────────────────────┐
│              FIREBASE / GOOGLE CLOUD                      │
│  ┌────────────────────────────────────────────────────┐   │
│  │        Cloud Run / Cloud Functions               │   │
│  │  ┌────────────────────────────────────────────┐  │   │
│  │  │    Laravel API Server (Containerized)     │  │   │
│  │  │  - Authentication                           │  │   │
│  │  │  - Bookings Management                      │  │   │
│  │  │  - Real-time Chat                           │  │   │
│  │  │  - Notifications                            │  │   │
│  │  └────────────────────────────────────────────┘  │   │
│  └────────────────────────────────────────────────────┘   │
└─────────────────────────────┬──────────────────────────────┘
                              │ External Connection
┌─────────────────────────────┴──────────────────────────────┐
│                    YOUR DOCKER SETUP                        │
│  ┌────────────────────────────────────────────────────┐   │
│  │         MySQL 8.0 Database (Local)                │   │
│  │  - Users Table (23 total tables)                 │   │
│  │  - Bookings Management                           │   │
│  │  - Service Providers                             │   │
│  │  - Chat Messages                                 │   │
│  │  - Notifications                                 │   │
│  │  - Location Pins                                 │   │
│  └────────────────────────────────────────────────────┘   │
└──────────────────────────────────────────────────────────────┘
```

## 🎯 Key Benefits of This Architecture:

### **✅ Data Sovereignty:**
- **Your MySQL database stays local** - Full control over data
- **No vendor lock-in** - Can migrate anytime
- **Custom backup strategies** - Your rules

### **✅ Scalable Server Infrastructure:**
- **Firebase/Google Cloud** handles API scaling automatically
- **Pay-per-use** pricing model
- **Global CDN** for fast API responses

### **✅ Security:**
- **Database behind firewall** - Not exposed to internet
- **API layer handles authentication** - Secure by design
- **SSL/TLS encryption** - All communications encrypted

### **✅ Cost Effective:**
- **Local MySQL** - No database hosting costs
- **Cloud Functions** - Only pay for what you use
- **Auto-scaling** - No over-provisioning

---

## 🔧 Step 1: Prepare Your MySQL Docker Database

### **Current Setup Verification:**
```bash
# Check if MySQL is running
docker ps | grep mysql

# Connect to your database
docker exec -it haustap_mysql mysql -u haustap_user -p

# Verify your tables
mysql> SHOW TABLES;
# Should show: users, bookings, providers, chat_messages, etc.
```

### **Database Connection Test:**
```bash
# Test connection from API container
docker run --rm --network host mysql:8.0 mysqladmin ping -h localhost -P 3307 -u haustap_user -p
```

---

## 🚀 Step 2: Deploy Laravel API to Google Cloud Run

### **Option A: Google Cloud Run (Recommended)**

1. **Build and Push Docker Image:**
```bash
# Build MySQL-optimized image
cd backend/api
docker build -f Dockerfile.mysql -t gcr.io/YOUR-PROJECT-ID/haustap-api:latest .

# Push to Google Container Registry
docker push gcr.io/YOUR-PROJECT-ID/haustap-api:latest
```

2. **Deploy to Cloud Run:**
```bash
# Deploy with MySQL connection
gcloud run deploy haustap-api \
  --image gcr.io/YOUR-PROJECT-ID/haustap-api:latest \
  --platform managed \
  --region us-central1 \
  --allow-unauthenticated \
  --set-env-vars "DB_CONNECTION=mysql,DB_HOST=YOUR_MYSQL_HOST_IP,DB_PORT=3307,DB_DATABASE=haustap_db,DB_USERNAME=haustap_user,DB_PASSWORD=haustap_password" \
  --memory 2Gi \
  --cpu 2 \
  --max-instances 10
```

### **Option B: Render with External MySQL**

1. **Use the provided `render-mysql-config.yaml`**
2. **Update MySQL host IP in environment variables**
3. **Deploy to Render**

---

## 🔥 Step 3: Configure Firebase Integration

### **Set Up Firebase Project:**
```bash
# Install Firebase CLI
npm install -g firebase-tools

# Login to Firebase
firebase login

# Initialize Firebase in your project
firebase init

# Deploy Firebase Functions (if needed)
firebase deploy --only functions
```

### **Update Laravel Firebase Configuration:**
```php
// In config/services.php
'firebase' => [
    'project_id' => env('FIREBASE_PROJECT_ID'),
    'service_account' => env('FIREBASE_SERVICE_ACCOUNT_PATH'),
],
```

---

## 📱 Step 4: Update Client Applications

### **Android App (React Native):**
```javascript
// Update API configuration
const API_CONFIG = {
  PROD_API_URL: 'https://haustap-api-abc123-uc.a.run.app/api',
  PROD_WEB_URL: 'https://your-web-domain.com',
  
  // Firebase configuration
  FIREBASE_CONFIG: {
    apiKey: "your-firebase-api-key",
    authDomain: "your-project.firebaseapp.com",
    projectId: "your-project-id",
    storageBucket: "your-project.appspot.com",
    messagingSenderId: "123456789",
    appId: "your-app-id"
  }
};
```

### **Web Frontend (PHP):**
```php
<?php
// Update API base URL
$API_BASE_URL = 'https://haustap-api-abc123-uc.a.run.app/api';
$FIREBASE_CONFIG = [
  'apiKey' => 'your-firebase-api-key',
  'authDomain' => 'your-project.firebaseapp.com',
  'projectId' => 'your-project-id',
];
?>
```

---

## 🔐 Step 5: Security Configuration

### **MySQL Security:**
```bash
# Create dedicated API user with limited permissions
mysql> CREATE USER 'api_user'@'%' IDENTIFIED BY 'secure_password';
mysql> GRANT SELECT, INSERT, UPDATE, DELETE ON haustap_db.* TO 'api_user'@'%';
mysql> FLUSH PRIVILEGES;
```

### **API Security:**
```php
// In Laravel middleware
// Rate limiting, CORS, authentication
```

### **Network Security:**
```bash
# Configure firewall rules
# Allow only Cloud Run IPs to access MySQL
# Use VPN or private network connection
```

---

## 🧪 Step 6: Testing & Validation

### **Database Connection Test:**
```bash
# Test from Cloud Run
curl https://haustap-api-abc123-uc.a.run.app/api/health

# Expected response:
{"status":"ok","database":"connected","timestamp":"2024-..."}
```

### **API Endpoints Test:**
```bash
# Test authentication
curl -X POST https://haustap-api-abc123-uc.a.run.app/api/v2/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'

# Test bookings
curl https://haustap-api-abc123-uc.a.run.app/api/bookings \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### **Mobile App Test:**
```javascript
// Test from React Native app
const response = await fetch('https://haustap-api-abc123-uc.a.run.app/api/health');
const data = await response.json();
console.log('API Status:', data.status); // Should be "ok"
```

---

## 📊 Monitoring & Maintenance

### **Cloud Monitoring:**
```bash
# View logs
gcloud logging read "resource.type=cloud_run_revision AND resource.labels.service_name=haustap-api"

# Monitor performance
gcloud monitoring dashboards create --config-from-file=monitoring-dashboard.json
```

### **Database Monitoring:**
```bash
# Monitor MySQL performance
docker stats haustap_mysql

# Check slow queries
mysql> SHOW PROCESSLIST;
mysql> SHOW VARIABLES LIKE 'slow_query_log%';
```

---

## 🚨 Troubleshooting

### **Database Connection Issues:**
```bash
# Check MySQL container
docker logs haustap_mysql

# Test connection
telnet YOUR_MYSQL_HOST 3307

# Check firewall rules
sudo ufw status
```

### **API Connection Issues:**
```bash
# Check Cloud Run logs
gcloud run services describe haustap-api --region=us-central1

# Test health endpoint
curl -v https://haustap-api-abc123-uc.a.run.app/api/health
```

### **CORS Issues:**
```bash
# Check CORS configuration
curl -H "Origin: https://your-app.com" \
     -H "Access-Control-Request-Method: POST" \
     -X OPTIONS https://haustap-api-abc123-uc.a.run.app/api/health
```

---

## 🎯 Final URLs (Example):
```
📊 API Backend:    https://haustap-api-abc123-uc.a.run.app/api
🌐 Web Frontend:   https://your-web-domain.com
📱 Mobile App:     Connected to API above
🔥 Firebase:       https://console.firebase.google.com/project/your-project
☁️  Google Cloud:  https://console.cloud.google.com/run/detail/us-central1/haustap-api
🗄️  MySQL Admin:   http://localhost:8080 (phpMyAdmin)
```

---

## 💰 Cost Optimization:
- **Cloud Run**: Pay only when serving requests (~$0.24/million requests)
- **Firebase**: Free tier available, pay-as-you-grow
- **MySQL**: Runs on your infrastructure - no hosting costs
- **Bandwidth**: First 1GB/month free, then ~$0.12/GB

**🚀 Ready to deploy? Your MySQL database + Firebase/Google Cloud architecture is production-ready!**