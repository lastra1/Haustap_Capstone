# Laravel API Deployment Script for Windows
# This script helps deploy your Laravel API to various cloud platforms

Write-Host "🚀 Laravel API Deployment Script" -ForegroundColor Green
Write-Host "=================================" -ForegroundColor Green
Write-Host ""
Write-Host "Your Dockerfile and configuration files are ready!" -ForegroundColor Yellow
Write-Host ""
Write-Host "📋 Deployment Options:" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. 🚄 RAILWAY (Recommended - Easiest)" -ForegroundColor Green
Write-Host "   - Install Railway CLI: npm install -g @railway/cli"
Write-Host "   - Login: railway login"
Write-Host "   - Deploy: railway up"
Write-Host "   - Your API will be available at: https://your-app.railway.app"
Write-Host ""
Write-Host "2. 🎨 RENDER (Alternative)" -ForegroundColor Blue
Write-Host "   - Go to: https://render.com"
Write-Host "   - Connect your GitHub repository"
Write-Host "   - Create new Web Service"
Write-Host "   - Use the render.yaml configuration"
Write-Host "   - Your API will be available at: https://your-app.onrender.com"
Write-Host ""
Write-Host "3. ☁️  GOOGLE CLOUD RUN (Advanced)" -ForegroundColor Magenta
Write-Host "   - Install Google Cloud SDK"
Write-Host "   - Build: docker build -t gcr.io/YOUR-PROJECT/laravel-api ."
Write-Host "   - Push: docker push gcr.io/YOUR-PROJECT/laravel-api"
Write-Host "   - Deploy: gcloud run deploy --image gcr.io/YOUR-PROJECT/laravel-api"
Write-Host ""
Write-Host "📝 Next Steps:" -ForegroundColor Yellow
Write-Host "1. Choose your preferred platform above"
Write-Host "2. Follow the deployment instructions"
Write-Host "3. Your API will be live with a public URL"
Write-Host "4. Test the health endpoint: https://your-domain/api/health"
Write-Host ""
Write-Host "🔧 Configuration Files Created:" -ForegroundColor Cyan
Write-Host "- Dockerfile (Optimized for Laravel)"
Write-Host "- render.yaml (Render configuration)"
Write-Host "- railway.yaml (Railway configuration)"
Write-Host "- .dockerignore (Optimized build)"
Write-Host ""
Write-Host "✅ Your Laravel API is ready for deployment!" -ForegroundColor Green

# Pause to keep the terminal open
Read-Host "Press Enter to continue..."