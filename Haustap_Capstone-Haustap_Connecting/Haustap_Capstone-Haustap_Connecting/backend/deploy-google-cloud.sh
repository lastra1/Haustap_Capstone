#!/bin/bash

# HausTap Google Cloud Run Deployment Script
# This script deploys the HausTap backend to Google Cloud Run

echo "🚀 HausTap Google Cloud Run Deployment"
echo "======================================="

# Function to check if command succeeded
check_status() {
    if [ $? -eq 0 ]; then
        echo "✅ $1"
    else
        echo "❌ $1"
        exit 1
    fi
}

# Check if Google Cloud SDK is installed
echo "Checking Google Cloud SDK..."
gcloud --version > /dev/null 2>&1
check_status "Google Cloud SDK is installed"

# Check if user is authenticated
echo "Checking authentication..."
gcloud auth list --filter=status:ACTIVE --format="value(account)" | grep -q .
check_status "User is authenticated"

# Set project ID
PROJECT_ID="haustap-booking-system"
echo "Setting project to: $PROJECT_ID"
gcloud config set project $PROJECT_ID
check_status "Project set successfully"

# Enable required APIs
echo "Enabling required APIs..."
gcloud services enable run.googleapis.com
gcloud services enable cloudbuild.googleapis.com
gcloud services enable secretmanager.googleapis.com
gcloud services enable sqladmin.googleapis.com
check_status "Required APIs enabled"

# Create service account for Cloud Run
echo "Creating service account..."
gcloud iam service-accounts create haustap-cloudrun \
  --display-name="HausTap Cloud Run Service Account" \
  --description="Service account for HausTap Cloud Run deployment"

# Grant necessary permissions
gcloud projects add-iam-policy-binding $PROJECT_ID \
  --member="serviceAccount:haustap-cloudrun@$PROJECT_ID.iam.gserviceaccount.com" \
  --role="roles/secretmanager.secretAccessor"

gcloud projects add-iam-policy-binding $PROJECT_ID \
  --member="serviceAccount:haustap-cloudrun@$PROJECT_ID.iam.gserviceaccount.com" \
  --role="roles/cloudsql.client"

check_status "Service account created and permissions granted"

# Build and push Docker image
echo "Building and pushing Docker image..."
docker build -f Dockerfile.production -t gcr.io/$PROJECT_ID/haustap-api:latest .
check_status "Docker image built"

docker push gcr.io/$PROJECT_ID/haustap-api:latest
check_status "Docker image pushed to GCR"

# Create Secret Manager secrets
echo "Creating secrets in Secret Manager..."
# Create Firebase service account secret
echo '{"type":"service_account","project_id":"'$PROJECT_ID'"}' | \
gcloud secrets create firebase-service-account \
  --data-file=- \
  --replication-policy="automatic"

# Create database password secret
echo "your-secure-db-password" | \
gcloud secrets create db-password \
  --data-file=- \
  --replication-policy="automatic"

# Create Redis password secret  
echo "your-secure-redis-password" | \
gcloud secrets create redis-password \
  --data-file=- \
  --replication-policy="automatic"

check_status "Secrets created in Secret Manager"

# Deploy to Cloud Run
echo "Deploying to Cloud Run..."
gcloud run deploy haustap-api \
  --image gcr.io/$PROJECT_ID/haustap-api:latest \
  --platform managed \
  --region us-central1 \
  --allow-unauthenticated \
  --service-account haustap-cloudrun@$PROJECT_ID.iam.gserviceaccount.com \
  --memory 2Gi \
  --cpu 2 \
  --max-instances 10 \
  --min-instances 1 \
  --timeout 300s \
  --port 8000 \
  --set-env-vars "^:^APP_ENV=production:APP_DEBUG=false:DB_CONNECTION=mysql:DB_HOST=your-cloudsql-instance:DB_DATABASE=haustap_db:DB_USERNAME=haustap_user:REDIS_HOST=your-redis-host:REDIS_PORT=6379:FIREBASE_PROJECT_ID=$PROJECT_ID:FIREBASE_DATABASE_URL=https://$PROJECT_ID-default-rtdb.asia-southeast1.firebasedatabase.app:FIREBASE_STORAGE_BUCKET=$PROJECT_ID.firebasestorage.app"

check_status "Cloud Run deployment completed"

# Get service URL
SERVICE_URL=$(gcloud run services describe haustap-api \
  --platform managed \
  --region us-central1 \
  --format "value(status.url)")

echo ""
echo "🎉 Google Cloud Run Deployment Completed!"
echo "=========================================="
echo ""
echo "🌐 Service URL: $SERVICE_URL"
echo "📊 Deployment Region: us-central1"
echo "🔧 Service Account: haustap-cloudrun@$PROJECT_ID.iam.gserviceaccount.com"
echo ""
echo "🔥 API Endpoints:"
echo "  • Health Check: $SERVICE_URL/api/health"
echo "  • Firebase Config: $SERVICE_URL/api/firebase/firebase-config"
echo "  • User Management: $SERVICE_URL/api/firebase/users/*"
echo "  • Booking Management: $SERVICE_URL/api/firebase/bookings/*"
echo ""
echo "📋 Next Steps:"
echo "  1. Setup Cloud SQL for MySQL database"
echo "  2. Setup Memorystore for Redis cache"
echo "  3. Configure custom domain"
echo "  4. Setup monitoring and alerting"
echo "  5. Configure backup strategy"
echo ""
echo "🚀 Deployment completed successfully!"