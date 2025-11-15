#!/bin/bash

# Haustap Docker Deployment Test Script
# This script tests the Docker build and local deployment

echo "🚀 Haustap Docker Deployment Test"
echo "=================================="

# Function to check if command succeeded
check_status() {
    if [ $? -eq 0 ]; then
        echo "✅ $1"
    else
        echo "❌ $1"
        exit 1
    fi
}

# Test Docker build
echo "1. Testing Docker build..."
docker build -f Dockerfile.production -t haustap-api-production .
check_status "Docker build completed"

# Test Docker Compose
echo "2. Testing Docker Compose..."
docker-compose -f docker-compose.production.yml config > /dev/null
check_status "Docker Compose configuration valid"

# Test local deployment
echo "3. Testing local deployment..."
docker-compose -f docker-compose.production.yml up -d
check_status "Local deployment started"

# Wait for services to be ready
echo "4. Waiting for services..."
sleep 30

# Test health endpoint
echo "5. Testing health endpoint..."
curl -f http://localhost:8000/api/health > /dev/null 2>&1
check_status "Health endpoint responding"

# Test API endpoints
echo "6. Testing API endpoints..."
curl -f http://localhost:8000/api/firebase/firebase-config > /dev/null 2>&1
check_status "Firebase config endpoint working"

echo ""
echo "🎉 All tests passed! Docker deployment is ready."
echo ""
echo "Next steps:"
echo "1. Deploy to Google Cloud Run: gcloud run deploy haustap-api --source . --region us-central1"
echo "2. Deploy to Render: Use the render.yaml configuration"
echo "3. Deploy to Railway: Use the railway.toml configuration"
echo ""
echo "To stop local deployment: docker-compose -f docker-compose.production.yml down"