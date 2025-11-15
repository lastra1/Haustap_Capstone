# Database Switching Guide

This guide explains how to switch between different database systems in the HausTap application. The application supports three database drivers: **Firestore**, **MySQL**, and **SQLite**.

## Quick Start

### Switch to MySQL (Current Default)
```bash
php artisan db:switch mysql
```

### Switch to Firestore
```bash
php artisan db:switch firestore
```

### Switch to SQLite
```bash
php artisan db:switch sqlite
```

## Available Database Drivers

### 🔥 Firestore (Google Cloud)
- **Type**: NoSQL Cloud Database
- **Best for**: Real-time applications, global scaling, offline support
- **Features**: Auto-scaling, real-time sync, global distribution
- **Configuration**: Requires Firebase project setup

### 🗄️ MySQL
- **Type**: Relational Database
- **Best for**: Traditional applications, complex queries, ACID transactions
- **Features**: Full-text search, complex joins, referential integrity
- **Configuration**: Requires MySQL server installation

### 💾 SQLite
- **Type**: File-based Database
- **Best for**: Development, testing, small applications
- **Features**: Zero configuration, portable, serverless
- **Configuration**: No setup required (file-based)

## Database Switch Command

### Usage
```bash
php artisan db:switch {driver} {--force}
```

### Parameters
- `driver`: The database driver to switch to (`firestore`, `mysql`, `sqlite`)
- `--force`: Skip confirmation prompt

### Examples
```bash
# Switch to MySQL with confirmation
php artisan db:switch mysql

# Switch to Firestore without confirmation
php artisan db:switch firestore --force

# Switch to SQLite
php artisan db:switch sqlite
```

## Configuration Files

The system maintains separate environment files for each database:

- `.env.firestore` - Firestore configuration
- `.env.mysql` - MySQL configuration  
- `.env.sqlite` - SQLite configuration
- `.env` - Current active configuration (symlink/copy)

## Switching Process

### 1. Automatic Backup
When you run the switch command, the system automatically creates a backup of your current `.env` file:
```
.env.backup.2025-11-14-123456
```

### 2. Configuration Validation
The system validates the target configuration and warns about missing settings.

### 3. Cache Clearing
The system automatically clears configuration and application caches to ensure changes take effect.

### 4. Post-Switch Instructions
After switching, you'll receive specific instructions for the selected database.

## Database-Specific Setup

### MySQL Setup

1. **Install MySQL Server**
   ```bash
   # Ubuntu/Debian
   sudo apt install mysql-server
   
   # macOS
   brew install mysql
   
   # Windows
   # Download from https://dev.mysql.com/downloads/mysql/
   ```

2. **Create Database**
   ```sql
   CREATE DATABASE haustap;
   ```

3. **Configure User (Optional)**
   ```sql
   CREATE USER 'haustap'@'localhost' IDENTIFIED BY 'your-password';
   GRANT ALL PRIVILEGES ON haustap.* TO 'haustap'@'localhost';
   FLUSH PRIVILEGES;
   ```

4. **Update Environment Variables**
   Edit `.env.mysql` if needed:
   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=haustap
   DB_USERNAME=your-username
   DB_PASSWORD=your-password
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

### Firestore Setup

1. **Create Firebase Project**
   - Go to [Firebase Console](https://console.firebase.google.com/)
   - Create a new project or select existing
   - Enable Firestore Database

2. **Get Configuration**
   - Project Settings → General → Your apps → Web app
   - Copy configuration values

3. **Update Environment Variables**
   Edit `.env.firestore`:
   ```env
   FIREBASE_PROJECT_ID=your-project-id
   FIREBASE_API_KEY=your-api-key
   FIREBASE_AUTH_DOMAIN=your-project.firebaseapp.com
   FIREBASE_APP_ID=your-app-id
   FIREBASE_STORAGE_BUCKET=your-project.appspot.com
   FIREBASE_MESSAGING_SENDER_ID=your-sender-id
   ```

4. **Set Up Security Rules**
   Go to Firestore → Rules and configure:
   ```javascript
   rules_version = '2';
   service cloud.firestore {
     match /databases/{database}/documents {
       match /{document=**} {
         allow read: if true;
         allow write: if request.auth != null;
       }
     }
   }
   ```

### SQLite Setup

1. **No Installation Required**
   SQLite is included with PHP.

2. **Create Database File (Optional)**
   ```bash
   touch database/database.sqlite
   ```

3. **Run Migrations**
   ```bash
   php artisan migrate
   ```

## Testing Database Connections

### Test Current Configuration
```bash
php artisan db:monitor
```

### Test Firestore (if using Firestore)
```bash
php artisan firestore:test
```

### Test MySQL Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### Test SQLite Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

## Migration Between Databases

### Export from MySQL/SQLite
```bash
# MySQL
mysqldump -u username -p haustap > backup.sql

# SQLite
sqlite3 database/database.sqlite .dump > backup.sql
```

### Import to Firestore
Use Firebase Admin SDK or create a custom script to import data into Firestore collections.

### Hybrid Approach
You can use Firestore for real-time features while keeping MySQL for complex reporting:
- Set `DB_CONNECTION=mysql` for main data
- Use Firestore repositories directly for specific features
- Keep both configurations active

## Troubleshooting

### Common Issues

#### "Driver not supported"
- Ensure the driver name is correct: `firestore`, `mysql`, or `sqlite`
- Check available drivers: `php artisan db:switch --help`

#### "Connection refused"
- **MySQL**: Check if MySQL server is running
- **Firestore**: Verify Firebase project configuration
- **SQLite**: Ensure database file exists and is writable

#### "Access denied"
- **MySQL**: Check username/password in `.env.mysql`
- **Firestore**: Verify Firebase security rules

#### "Configuration not found"
- Check if environment file exists: `.env.{driver}`
- Create default configuration: `php artisan db:switch {driver}`

### Recovery
If switching fails:
1. Check backup files: `ls -la .env.backup.*`
2. Restore from backup: `cp .env.backup.{timestamp} .env`
3. Clear cache: `php artisan config:clear`
4. Retry the switch

## Performance Considerations

### Firestore
- **Pros**: Real-time sync, global scaling, offline support
- **Cons**: Query limitations, higher latency for complex queries
- **Best for**: User data, real-time features, mobile apps

### MySQL
- **Pros**: Complex queries, transactions, full-text search
- **Cons**: Requires server management, scaling complexity
- **Best for**: Reporting, analytics, complex relationships

### SQLite
- **Pros**: Zero configuration, fast for small datasets
- **Cons**: Not suitable for concurrent access, limited scaling
- **Best for**: Development, testing, small applications

## Security Considerations

### Firestore Security
- Configure security rules properly
- Use Firebase Authentication
- Enable audit logging
- Set up proper IAM roles

### MySQL Security
- Use strong passwords
- Configure SSL/TLS connections
- Limit user privileges
- Enable query logging

### SQLite Security
- File permissions (600 recommended)
- Backup encryption
- Access control to database directory

## Best Practices

1. **Use SQLite for Development**: Fast setup, no dependencies
2. **Test with MySQL for Staging**: Validate SQL compatibility
3. **Use Firestore for Production**: When you need real-time features
4. **Keep Backups**: Always backup before switching
5. **Document Changes**: Track which database is used where
6. **Monitor Performance**: Use appropriate monitoring tools

## Environment-Specific Configurations

### Development
```bash
php artisan db:switch sqlite  # Fast setup
```

### Staging
```bash
php artisan db:switch mysql   # Production-like
```

### Production
```bash
php artisan db:switch firestore  # Real-time features
# or
php artisan db:switch mysql      # Traditional setup
```

## Additional Resources

- [Firestore Documentation](backend/api/docs/FIRESTORE_SETUP.md)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [SQLite Documentation](https://www.sqlite.org/docs.html)
- [Laravel Database Documentation](https://laravel.com/docs/database)

## Support

If you encounter issues:
1. Check this documentation
2. Run diagnostic commands
3. Check log files: `storage/logs/laravel.log`
4. Create an issue in the project repository