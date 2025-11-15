#!/bin/bash

# HausTap Docker Setup Script
# This script sets up the complete Docker environment for HausTap backend

set -e

echo "🚀 HausTap Docker Setup Script"
echo "================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if Docker is installed
check_docker() {
    if ! command -v docker &> /dev/null; then
        print_error "Docker is not installed. Please install Docker first."
        exit 1
    fi
    
    if ! command -v docker-compose &> /dev/null; then
        print_error "Docker Compose is not installed. Please install Docker Compose first."
        exit 1
    fi
    
    print_status "Docker and Docker Compose are installed"
}

# Check if .env file exists
check_env_file() {
    if [ ! -f ".env" ]; then
        print_status "Creating .env file from .env.docker..."
        cp .env.docker .env
        print_status ".env file created successfully"
    else
        print_warning ".env file already exists"
    fi
}

# Setup Firebase service account
setup_firebase() {
    print_status "Setting up Firebase service account..."
    
    # Create Firebase directory
    mkdir -p storage/app/firebase
    
    if [ ! -f "storage/app/firebase/service-account.json" ]; then
        print_warning "Firebase service account file not found!"
        echo "Please follow these steps:"
        echo "1. Go to Firebase Console → Project Settings → Service Accounts"
        echo "2. Click 'Generate new private key'"
        echo "3. Save the JSON file as 'storage/app/firebase/service-account.json'"
        echo ""
        read -p "Press Enter when you have added the service account file..."
        
        if [ ! -f "storage/app/firebase/service-account.json" ]; then
            print_error "Service account file still not found. Please add it manually."
            exit 1
        fi
    fi
    
    print_status "Firebase service account setup completed"
}

# Build and start Docker containers
start_docker() {
    print_status "Building and starting Docker containers..."
    
    # Stop existing containers if running
    docker-compose down 2>/dev/null || true
    
    # Build and start containers
    docker-compose up -d --build
    
    if [ $? -eq 0 ]; then
        print_status "Docker containers started successfully"
    else
        print_error "Failed to start Docker containers"
        exit 1
    fi
}

# Wait for services to be ready
wait_for_services() {
    print_status "Waiting for services to be ready..."
    
    # Wait for MySQL
    print_status "Waiting for MySQL..."
    timeout=60
    while ! docker-compose exec -T mysql mysqladmin ping -h localhost -u haustap_user -p"haustap_password" --silent; do
        sleep 2
        timeout=$((timeout - 2))
        if [ $timeout -le 0 ]; then
            print_error "MySQL failed to start within timeout"
            exit 1
        fi
    done
    print_status "MySQL is ready"
    
    # Wait for Redis
    print_status "Waiting for Redis..."
    timeout=30
    while ! docker-compose exec -T redis redis-cli ping; do
        sleep 2
        timeout=$((timeout - 2))
        if [ $timeout -le 0 ]; then
            print_error "Redis failed to start within timeout"
            exit 1
        fi
    done
    print_status "Redis is ready"
}

# Run Laravel setup commands
setup_laravel() {
    print_status "Setting up Laravel..."
    
    # Generate application key
    docker-compose exec -T backend php artisan key:generate
    
    # Run migrations
    docker-compose exec -T backend php artisan migrate --force
    
    # Clear and cache config
    docker-compose exec -T backend php artisan config:clear
    docker-compose exec -T backend php artisan cache:clear
    docker-compose exec -T backend php artisan config:cache
    
    # Set proper permissions
    docker-compose exec -T backend chown -R www-data:www-data /var/www/storage
    docker-compose exec -T backend chown -R www-data:www-data /var/www/bootstrap/cache
    docker-compose exec -T backend chmod -R 775 /var/www/storage
    docker-compose exec -T backend chmod -R 775 /var/www/bootstrap/cache
    
    print_status "Laravel setup completed"
}

# Install Node dependencies
install_node_deps() {
    print_status "Installing Node.js dependencies..."
    
    # Install backend dependencies
    docker-compose exec -T backend npm install
    docker-compose exec -T backend npm run build
    
    # Install socket server dependencies
    docker-compose exec -T socket_server npm install
    
    print_status "Node.js dependencies installed"
}

# Display service information
display_info() {
    echo ""
    echo "🎉 HausTap Docker Setup Completed!"
    echo "===================================="
    echo ""
    echo "🌐 Services are now available at:"
    echo "  • Laravel Backend: http://localhost:8001"
    echo "  • PHPMyAdmin: http://localhost:8081"
    echo "  • Socket Server: http://localhost:3000"
    echo ""
    echo "📊 Database Information:"
    echo "  • MySQL Host: localhost:3306"
    echo "  • Database: haustap_db"
    echo "  • Username: haustap_user"
    echo "  • Password: haustap_password"
    echo ""
    echo "🔧 Useful Commands:"
    echo "  • View logs: docker-compose logs -f [service_name]"
    echo "  • Stop services: docker-compose down"
    echo "  • Restart services: docker-compose restart"
    echo "  • Access backend: docker-compose exec backend bash"
    echo "  • Access database: docker-compose exec mysql mysql -u haustap_user -p"
    echo ""
    echo "📚 API Endpoints:"
    echo "  • User Management: /api/firebase/users/*"
    echo "  • Booking Management: /api/firebase/bookings/*"
    echo "  • Service Providers: /api/firebase/service-providers/*"
    echo "  • Vouchers: /api/firebase/vouchers/*"
    echo "  • Dashboard: /api/firebase/dashboard/stats"
    echo ""
    echo "🔥 Firebase Integration:"
    echo "  • Project ID: haustap-booking-system"
    echo "  • Service Account: storage/app/firebase/service-account.json"
    echo ""
    echo "⚠️  Important Notes:"
    echo "  • Make sure Firebase service account file is in place"
    echo "  • Configure your .env file for production deployment"
    echo "  • Set up SSL certificates for HTTPS in production"
    echo ""
}

# Main execution
main() {
    echo "Starting HausTap Docker setup..."
    echo ""
    
    check_docker
    check_env_file
    setup_firebase
    start_docker
    wait_for_services
    setup_laravel
    install_node_deps
    display_info
    
    print_status "Setup completed successfully! 🚀"
}

# Run main function
main "$@"