# Environment Setup: Development / Staging / Production

This repository contains two PHP web apps (Client and Admin) and a Laravel-style backend. This document outlines how to run each environment consistently.

## 1) Environments and .env files

Top-level `.env` loader lives in `bootstrap.php`. It loads:
- Base file: `.env`
- Overrides: `.env.{APP_ENV}` (e.g. `.env.development`, `.env.staging`, `.env.production`)

Environment variables are made available via `getenv()` and `$_ENV` to all PHP scripts.

Included templates:
- Root: `.env.example`, `.env.development.example`, `.env.staging.example`, `.env.production.example`
- Backend: `backend/.env.example`, `backend/.env.development.example`, `backend/.env.staging.example`, `backend/.env.production.example`

Recommended usage:
- Development: copy `.env.development.example` to `.env` at repo root. For backend, copy `backend/.env.development.example` to `backend/.env`.
- Staging: copy `.env.staging.example` to `.env` (root) and `backend/.env.staging.example` to `backend/.env` on the staging server.
- Production: copy `.env.production.example` to `.env` (root) and `backend/.env.production.example` to `backend/.env` on the production server.

Sensitive values (`DB_PASSWORD`, `SMTP_PASS`) must be set on each server; never commit secrets.

## 2) Error reporting and logs

- Controlled by `APP_DEBUG`. When `true`, errors are shown; otherwise hidden.
- PHP error logs go to `storage/logs/php-error.log` (created automatically).
- Laravel backend uses its own logging per `backend/config/logging.php` and `.env`.

## 3) Development

Run Client app locally:

```powershell
# From repo root
php -S localhost:8080 -t "C:\Users\mozom\OneDrive\Desktop\Haustap_Capstone\Haustap_Capstone-Haustap_Connecting\Haustap_Capstone-Haustap_Connecting"
```

Run Admin app locally:

```powershell
php -S localhost:8081 -t "C:\Users\mozom\OneDrive\Desktop\Haustap_Capstone\admin_haustap\admin_haustap"
```

Optional: run the friendly router (maps clean URLs) from `public`:

```powershell
php -S localhost:8000 -t public public/index.php
```

Backend (Laravel-like):
- Ensure `backend/.env` exists (use `backend/.env.development`).
- If Composer is available, run typical commands (optional):

```powershell
cd "Haustap_Capstone-Haustap_Connecting/Haustap_Capstone-Haustap_Connecting/backend"
# composer install
# php artisan migrate
```

## 4) Staging

General approach:
- Host Client and Admin under a web server (Apache/Nginx/IIS) pointing to their respective directories.
- Set `.env` and `backend/.env` to the staging variants.
- Use a dedicated MySQL database (`haustap_staging`).
- Disable `APP_DEBUG`.

Example Nginx server blocks (Linux):

```
server {
    server_name staging.haustap.example.com;
    root /var/www/Haustap_Capstone/Haustap_Capstone-Haustap_Connecting/Haustap_Capstone-Haustap_Connecting;
    index index.php index.html;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}

server {
    server_name admin.staging.haustap.example.com;
    root /var/www/Haustap_Capstone/admin_haustap/admin_haustap;
    index index.php;
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## 5) Production

Same layout as staging with production `.env` files and hardening:
- `APP_DEBUG=false`
- Strict firewall and TLS
- Use managed MySQL or equivalent
- Enable caching (OPcache, HTTP cache) and CDN for static assets

## 6) Database strategy

- Development: `sqlite` (simple, file-based) or local MySQL
- Staging: MySQL schema mirroring production
- Production: MySQL with backups and migrations

## 7) Mail strategy

- Development: test accounts or mailhog
- Staging: provider sandbox/tags
- Production: dedicated sender with DKIM/SPF

## 8) Environment variables overview

Key variables:
- `APP_ENV` — `development` | `staging` | `production`
- `APP_DEBUG` — `true`/`false` shows/hides detailed errors
- `APP_URL` — base URL used by backend
- `DB_*` — database connection per environment
- `SMTP_*` — mail settings consumed by `mock-api/config.php`
- `LOG_LEVEL` — logging granularity

## 9) Notes

- Do not commit secrets.
- Ensure CI/CD replaces `.env` files per environment during deploy.
- For Windows IIS, map sites to the two directories and enable PHP.
 - For onboarding, you can pull the tag `v0.1.0-onboarding` to ensure a consistent snapshot.
### Mobile App (Expo)

The mobile app lives in `android-capstone-main/HausTap/`.

- Create a local env file:
  - Copy `android-capstone-main/HausTap/.env.example` to `android-capstone-main/HausTap/.env`.
  - Set `GMAIL_USER` and `GMAIL_APP_PASSWORD` (use a Gmail App Password or SMTP credentials).
  - Optional: adjust `PORT` if `3000` is busy.

- Start the local email/Express server:
  - `cd android-capstone-main/HausTap`
  - `npm install`
  - `npm run server` (reads config from `.env`)

- Run the Expo app:
  - In the same directory: `npm start`
  - Open with Android emulator, iOS simulator, or Expo Go.

Notes:
- `.env` is intentionally ignored by Git; only `.env.example` is committed.
- `process.env.EXPO_OS` comes from Expo; you do not need to set it.
