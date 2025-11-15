# 🚀 Laravel API Docker Deployment Guide

Your Laravel API is now ready for deployment with Docker! This guide will help you get a live URL for your mobile app.

## ✅ What's Been Created

- **Dockerfile** - Optimized for Laravel with PHP 8.2
- **.dockerignore** - Excludes unnecessary files for faster builds
- **render.yaml** - Configuration for Render deployment
- **railway.yaml** - Configuration for Railway deployment
- **deploy.ps1** - Deployment script with instructions

## 🚀 Quick Deployment Options

### Option 1: Railway (Recommended - Fastest)

1. **Install Railway CLI**:
   ```bash
   npm install -g @railway/cli
   ```

2. **Login to Railway**:
   ```bash
   railway login
   ```

3. **Deploy your API**:
   ```bash
   railway up
   ```

4. **Get your live URL**: Railway will provide you with a URL like `https://your-app.railway.app`

### Option 2: Render (Alternative)

1. **Go to** [Render.com](https://render.com)
2. **Connect your GitHub repository** containing this Laravel API
3. **Create a new Web Service**
4. **Select your repository**
5. **Render will automatically detect** the `render.yaml` configuration
6. **Deploy** - Your API will be live at `https://your-app.onrender.com`

### Option 3: Google Cloud Run (Advanced)

1. **Install Google Cloud SDK**
2. **Build your Docker image**:
   ```bash
   docker build -t gcr.io/YOUR-PROJECT/laravel-api .
   ```
3. **Push to Google Container Registry**:
   ```bash
   docker push gcr.io/YOUR-PROJECT/laravel-api
   ```
4. **Deploy to Cloud Run**:
   ```bash
   gcloud run deploy --image gcr.io/YOUR-PROJECT/laravel-api
   ```

## 🔍 Testing Your Deployment

Once deployed, test your API endpoints:

### Health Check
```bash
curl https://your-domain/api/health
```
Expected response: `{"status":"ok"}`

### API Documentation
```bash
curl https://your-domain/api/v2/docs
```

### Authentication Endpoints
- `POST /api/v2/auth/register` - Register new user
- `POST /api/v2/auth/login` - Login user
- `GET /api/v2/auth/profile` - Get user profile

## 📱 Mobile App Integration

Update your mobile app to use the new live URL:

```javascript
// Replace your current API base URL
const API_BASE_URL = 'https://your-domain.com/api';

// Example API calls
const login = async (email, password) => {
  const response = await fetch(`${API_BASE_URL}/v2/auth/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ email, password }),
  });
  return response.json();
};
```

## 🔧 Environment Variables

Your deployment will automatically configure these environment variables:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_CONNECTION=sqlite`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`
- `QUEUE_CONNECTION=database`

## 🚨 Important Notes

1. **Database**: The deployment uses SQLite for simplicity. For production, consider using PostgreSQL or MySQL.

2. **Storage**: File uploads are stored locally. For production, consider using cloud storage like AWS S3.

3. **SSL**: All platforms provide automatic SSL certificates.

4. **Scaling**: Railway and Render offer automatic scaling based on traffic.

## 🆘 Troubleshooting

### Common Issues:

1. **Build fails**: Check that your `composer.json` is valid
2. **Database errors**: Ensure migrations run automatically
3. **Permission issues**: The Dockerfile sets proper permissions
4. **Port issues**: The API runs on port 8000 internally

### Health Check Failed?
- Wait 2-3 minutes for the initial deployment
- Check deployment logs on your chosen platform
- Ensure all environment variables are set correctly

## 📞 Support

If you encounter issues:
1. Check the deployment logs on your platform
2. Test locally with: `php artisan serve`
3. Verify your Dockerfile builds locally: `docker build -t laravel-api .`

---

**🎉 Your Laravel API is ready for deployment! Choose Railway for the fastest setup and get your live URL in minutes.**