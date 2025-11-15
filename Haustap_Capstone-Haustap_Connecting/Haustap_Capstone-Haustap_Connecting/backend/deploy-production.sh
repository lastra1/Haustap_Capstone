#!/bin/bash

# HausTap Docker Production Deployment Script
# This script deploys the HausTap backend to production using Docker

echo "🚀 HausTap Production Deployment"
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

# Check if Docker is running
echo "Checking Docker status..."
docker info > /dev/null 2>&1
check_status "Docker is running"

# Create production environment file
echo "Setting up production environment..."
if [ ! -f ".env.production" ]; then
    cp .env.production.example .env.production
    echo "⚠️  Please update .env.production with your production values"
fi

# Generate Laravel key if not set
if grep -q "YOUR_APP_KEY_HERE" .env.production; then
    echo "Generating Laravel key..."
    APP_KEY=$(docker run --rm -v $(pwd):/app php:8.2-cli php -r "echo base64_encode(random_bytes(32));")
    sed -i "s/YOUR_APP_KEY_HERE/$APP_KEY/g" .env.production
fi

# Build production Docker image
echo "Building production Docker image..."
docker build -f Dockerfile.production -t haustap-api-production .
check_status "Production Docker image built"

# Create Docker network
echo "Creating Docker network..."
docker network create haustap-network 2>/dev/null || true
check_status "Docker network created/verified"

# Deploy MySQL database
echo "Deploying MySQL database..."
docker run -d \
  --name haustap-mysql \
  --network haustap-network \
  -e MYSQL_ROOT_PASSWORD=root_password \
  -e MYSQL_DATABASE=haustap_db \
  -e MYSQL_USER=haustap_user \
  -e MYSQL_PASSWORD=haustap_password \
  -p 3306:3306 \
  -v haustap-mysql-data:/var/lib/mysql \
  --restart unless-stopped \
  mysql:8.0

check_status "MySQL database deployed"

# Deploy Redis cache
echo "Deploying Redis cache..."
docker run -d \
  --name haustap-redis \
  --network haustap-network \
  -p 6379:6379 \
  -v haustap-redis-data:/data \
  --restart unless-stopped \
  redis:7-alpine

check_status "Redis cache deployed"

# Wait for database to be ready
echo "Waiting for database to be ready..."
sleep 30

# Deploy Laravel API
echo "Deploying Laravel API..."
docker run -d \
  --name haustap-api \
  --network haustap-network \
  -p 8000:8000 \
  -v $(pwd)/storage:/var/www/html/storage \
  -v $(pwd)/.env.production:/var/www/html/.env \
  --env-file .env.production \
  --restart unless-stopped \
  haustap-api-production

check_status "Laravel API deployed"

# Wait for API to start
echo "Waiting for API to be ready..."
sleep 20

# Test API endpoints
echo "Testing API endpoints..."
curl -f http://localhost:8000/api/health > /dev/null 2>&1
check_status "Health endpoint working"

curl -f http://localhost:8000/api/firebase/firebase-config > /dev/null 2>&1
check_status "Firebase config endpoint working"

# Setup SSL with Let's Encrypt (optional)
echo "Setting up SSL certificates..."
read -p "Do you want to setup SSL with Let's Encrypt? (y/N): " setup_ssl
if [[ $setup_ssl =~ ^[Yy]$ ]]; then
    read -p "Enter your domain name: " domain_name
    
    # Deploy Nginx with SSL
    docker run -d \
      --name haustap-nginx \
      --network haustap-network \
      -p 80:80 \
      -p 443:443 \
      -v $(pwd)/nginx.conf:/etc/nginx/nginx.conf:ro \
      -v $(pwd)/ssl:/etc/nginx/ssl \
      --restart unless-stopped \
      nginx:alpine
    
    echo "✅ SSL setup initiated for $domain_name"
    echo "⚠️  Please configure DNS and run certbot for SSL certificates"
fi

# Display deployment information
echo ""
echo "🎉 HausTap Production Deployment Completed!"
echo "==========================================="
echo ""
echo "🌐 Services Available:"
echo "  • Laravel API: http://localhost:8000"
echo "  • MySQL Database: localhost:3306"
echo "  • Redis Cache: localhost:6379"
echo ""
echo "📊 Database Credentials:"
echo "  • Database: haustap_db"
echo "  • Username: haustap_user"
echo "  • Password: haustap_password"
echo ""
echo "🔧 API Endpoints:"
echo "  • Health Check: /api/health"
echo "  • Firebase Config: /api/firebase/firebase-config"
echo "  • User Management: /api/firebase/users/*"
echo "  • Booking Management: /api/firebase/bookings/*"
echo ""
echo "🔥 Firebase Integration:"
echo "  • Project ID: haustap-booking-system"
echo "  • Service Account: Configured"
echo ""
echo "🐳 Docker Commands:"
echo "  • View logs: docker logs haustap-api"
echo "  • Stop services: docker stop haustap-api haustap-mysql haustap-redis"
echo "  • Remove services: docker rm haustap-api haustap-mysql haustap-redis"
echo "  • View running containers: docker ps"
echo ""
echo "⚠️  Important Notes:"
echo "  • Update .env.production with production values"
echo "  • Configure firewall rules for production"
echo "  • Setup monitoring and alerting"
echo "  • Configure backup strategy for database"
echo ""
echo "🚀 Deployment completed successfully!"