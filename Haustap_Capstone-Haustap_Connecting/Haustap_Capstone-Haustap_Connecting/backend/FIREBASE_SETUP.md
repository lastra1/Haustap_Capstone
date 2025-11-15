# Firebase Service Account Setup Guide

## 🔐 Setting up Firebase Service Account for Docker

### Step 1: Access Firebase Console
1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select your project: `haustap-booking-system`
3. Click on **Project Settings** (gear icon)

### Step 2: Generate Service Account Key
1. Go to **Service Accounts** tab
2. Click **Generate new private key**
3. A JSON file will be downloaded automatically

### Step 3: Place Service Account File
1. Copy the downloaded JSON file
2. Rename it to `service-account.json`
3. Place it in: `storage/app/firebase/service-account.json`

### Step 4: Verify Setup
Run this command to verify the file is in place:
```bash
# Check if file exists
ls -la storage/app/firebase/service-account.json

# Verify JSON format
cat storage/app/firebase/service-account.json | jq .project_id
```

## 🔧 Service Account Permissions

Your service account needs these permissions:
- **Firebase Admin SDK Administrator Service Agent**
- **Service Account Token Creator**
- **Firebase Authentication Admin**
- **Cloud Firestore Service Agent**
- **Firebase Rules System**

## 🚀 Quick Setup Commands

### Create directory:
```bash
mkdir -p storage/app/firebase
```

### Copy service account:
```bash
# Copy your downloaded file
cp ~/Downloads/your-service-account.json storage/app/firebase/service-account.json
```

### Set permissions:
```bash
chmod 644 storage/app/firebase/service-account.json
```

## 🔍 Troubleshooting

### File not found error:
- Ensure the file is named exactly `service-account.json`
- Check the path is correct: `storage/app/firebase/`
- Verify file permissions are readable

### Permission denied error:
- Service account may not have proper Firebase permissions
- Check Firebase project settings
- Regenerate service account key if needed

### Invalid service account error:
- Verify the JSON file is valid
- Check project_id matches your Firebase project
- Ensure the service account is active

## 📋 Service Account JSON Structure

Your `service-account.json` should look like this:
```json
{
  "type": "service_account",
  "project_id": "haustap-booking-system",
  "private_key_id": "...",
  "private_key": "-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----\n",
  "client_email": "firebase-adminsdk-xxxxx@haustap-booking-system.iam.gserviceaccount.com",
  "client_id": "...",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-xxxxx%40haustap-booking-system.iam.gserviceaccount.com"
}
```

## 🔗 Related Files

- Docker configuration: `docker-compose.yml`
- Environment file: `.env.docker`
- Firebase service: `app/Services/FirebaseService.php`
- API controller: `app/Http/Controllers/Api/FirebaseApiController.php`