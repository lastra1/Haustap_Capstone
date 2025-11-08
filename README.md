# HausTap Capstone — Monorepo

This repository contains multiple projects used across the HausTap Capstone:

- Web app (PHP) — `Haustap_Capstone-Haustap_Connecting/Haustap_Capstone-Haustap_Connecting`
- Admin panel (PHP) — `admin_haustap/admin_haustap`
- Root MVC app (PHP) — `public/`, `core/`, `app/`
- Mobile app (Expo/React Native) — `android-capstone-main/HausTap`
- Mock API (PHP) — `mock-api`
- Backend libraries — `backend`

No UI or UX changes are introduced by this document.

## Prerequisites

- `PHP 8.1+`
- `Composer`
- `Node.js 18+` and `npm` (or `yarn`)
- `Git`

## Environment Files

- Root examples: `.env.example`, `.env.development.example`, `.env.staging.example`, `.env.production.example`
- Backend examples: `backend/.env.example`, `backend/.env.development.example`, `backend/.env.staging.example`, `backend/.env.production.example`
- Mobile app: `android-capstone-main/HausTap/.env`

Create local `.env` files from the provided examples and fill credentials as needed. Secrets are ignored by Git. Example: copy `.env.development.example` to `.env` (root) and `backend/.env.development.example` to `backend/.env` for local development.

## Quick Start (Unified on port 8001)

1. Start the unified PHP dev server (UI, Admin, Mock API):
   - From repo root (recommended): `./start-dev.ps1` (PowerShell)
   - Or manually: `php -S localhost:8001 -t . public/index.php`
   - Open UI: `http://localhost:8001/`
   - Open Admin: `http://localhost:8001/admin/dashboard.php`
   - Mock API: available under `http://localhost:8001/mock-api/*` (no separate server needed)
2. Mobile app:
  - `cd android-capstone-main/HausTap`
  - `npm install`
  - `npm run start` (or `npx expo start`)
  - APK builds (Client & Provider): trigger GitHub Actions workflow "Build Android APKs (Client & Provider)"; download artifacts after the run completes.
3. Backend libraries (optional):
   - `cd backend`
   - `composer install`
4. Tips:
   - If `localhost` fails on some Windows setups, use `http://127.0.0.1:8001/`.
   - Ensure the document root is the project root (`-t .`), not `public/`, so static assets like `/css/global.css` resolve correctly.
   - The built-in router (`public/index.php`) maps clean routes (e.g. `/signup`, `/login`) and exposes the Mock API under `/mock-api/*` used by the web signup flow.

## Git Ignore & Line Endings

- A comprehensive `.gitignore` avoids committing OS, IDE, build, vendor, and secret files.
- `.gitattributes` ensures consistent line endings across platforms without changing UI/UX.

## Pushing to GitHub (Replace Contents)

From the repo root:

- `git init`
- `git add .`
- `git branch -M main`
- `git commit -m "Sync project and add updated .gitignore + README"`
- `git remote add origin https://github.com/lastra1/Haustap_Capstone.git`
- `git push -u origin main --force`

If authentication is required, use a Personal Access Token (PAT) with `repo` scope.

## Troubleshooting

- If pages don’t load, start the unified server exactly as: `php -S localhost:8001 -t . public/index.php`.
- If CSS or JS return 404, verify the document root is the repo root (`-t .`), not `-t public`.
- If `localhost` refuses to connect, try `http://127.0.0.1:8001/`.
- After pulling, run `composer install` (for PHP) and `npm install` (for JS) on each relevant project.
- Review `docs/environment-setup.md` for machine-specific setup notes.

## APK Builds & Download Links

- The workflow `.github/workflows/android-apk.yml` builds two debug APKs: Client and Provider.
- To generate download links:
  - Go to GitHub → Actions → "Build Android APKs (Client & Provider)" → Run workflow.
  - After it finishes, open the run and download artifacts named:
    - `haustap-client-debug-apk`
    - `haustap-provider-debug-apk`
- These debug APKs are unsigned but installable on most Android devices when "Install from unknown sources" is enabled.
- The mobile app’s API base (`EXPO_PUBLIC_API_BASE`) defaults to `http://26.242.103.174:8001` for both variants.

### Build APKs Locally (Android Studio / CLI)

- Requirements: Android Studio (SDK 34), JDK 17, Node 18, npm.
- Scripted build (recommended):
  - From repo root, run: `./build-apks.ps1 -ApiBase "http://26.242.103.174:8001" -Mode both -Clean`
  - Outputs: `dist/android/haustap-client-debug.apk` and `dist/android/haustap-provider-debug.apk`.
- Android Studio path:
  - Run `./build-apks.ps1 -Mode client -Clean` (or `-Mode provider`) to generate the `android/` folder.
  - Open `Haustap_Application/HausTap/android` in Android Studio.
  - Build → Build APK(s). Artifacts appear under `android/app/build/outputs/apk/debug/`.
- Notes:
  - The script wires `EXPO_PUBLIC_API_BASE` during prebuild; no UI/UX changes.
  - If an emulator/device cannot reach `http://26.242.103.174:8001`, ensure same network or use a public HTTPS URL.

## Docker API & Database

- Start stack: `docker compose up -d`.
- The API container auto-initializes on first start:
  - Copies `backend/api/.env.docker.example` to `.env` if missing.
  - Runs `composer install`.
  - Generates `APP_KEY` if empty.
  - Runs `php artisan migrate --force`.
- Database credentials (inside Docker): host `db`, user `haustap`, pass `haustap`, db `haustap`.
- Adminer: `http://localhost:8080/` for inspecting tables and data.

## Notes

- This README is purely operational guidance. It does not modify any UI or UX.
