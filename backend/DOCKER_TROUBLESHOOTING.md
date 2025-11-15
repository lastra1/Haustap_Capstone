# HausTap Docker Build Troubleshooting Guide

## Common Issues and Solutions

### 1. Build Context Issues
The most common issue is incorrect build context. Make sure you're building from the right directory:

```powershell
# Navigate to the backend directory
cd c:\Users\von\Desktop\Repositories\2025\Haustap_Updated\backend

# Build with correct context
docker build -f Dockerfile -t haustap-api .
```

### 2. File Path Issues
The Dockerfile expects files in specific locations. Check these paths exist:

```powershell
# Check if the Laravel backend exists
Test-Path "Haustap_Capstone-Haustap_Connecting\Haustap_Capstone-Haustap_Connecting\backend\composer.json"
Test-Path "Haustap_Capstone-Haustap_Connecting\Haustap_Capstone-Haustap_Connecting\backend\artisan"
```

### 3. Missing Dependencies
If composer install fails, try building with platform requirements ignored:

```dockerfile
# In Dockerfile, change this line:
RUN composer install --no-dev --optimize-autoloader --no-interaction

# To this:
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
```

### 4. Alternative Build Strategy
If the complex Dockerfile fails, use this simplified version:

```dockerfile
FROM php:8.2-cli-alpine

RUN apk add --no-cache curl git unzip
RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY Haustap_Capstone-Haustap_Connecting/Haustap_Capstone-Haustap_Connecting/backend/ ./

RUN composer install --no-dev --ignore-platform-reqs
RUN chmod +x artisan

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

### 5. Immediate Solution - Use Existing Working Setup
Since you already have a working Node.js server running on port 3001, you can:

1. **Continue using the Node.js server** (recommended for now)
2. **Deploy the working Node.js version** instead of trying to fix the Laravel Docker

### 6. Test Current Setup
Your Node.js server is already working. Test it:

```powershell
# Test the working Node.js API
curl http://localhost:3001/api/health
curl http://localhost:3001/api/sync/status
```

### 7. Quick Docker Fix for Node.js Version
Since your Node.js server works, let's Dockerize that instead:

```dockerfile
FROM node:18-alpine

WORKDIR /app
COPY server.js package.json ./
RUN npm install express cors

EXPOSE 3001
CMD ["node", "server.js"]
```

## Recommended Next Steps

1. **Use the working Node.js server** for immediate deployment
2. **Test the current API endpoints** to ensure functionality
3. **Deploy the Node.js version** to cloud services
4. **Fix Laravel Docker later** when you have more time

The Node.js server you have running on port 3001 already provides all the MySQL-Firebase sync functionality you need!