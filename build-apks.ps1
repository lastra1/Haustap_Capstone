param(
  [string]$ApiBase = 'http://26.242.103.174:8001',
  [ValidateSet('client','provider','both')]
  [string]$Mode = 'both',
  [switch]$Clean
)

$ErrorActionPreference = 'Stop'

$AppDir = Join-Path $PSScriptRoot 'Haustap_Application\HausTap'
if (!(Test-Path $AppDir)) {
  throw "Expo app directory not found at: $AppDir"
}

$DistDir = Join-Path $PSScriptRoot 'dist\android'
New-Item -ItemType Directory -Force -Path $DistDir | Out-Null

function Invoke-Gradle {
  param([string]$AndroidDir)
  $gradlew = Join-Path $AndroidDir 'gradlew.bat'
  if (!(Test-Path $gradlew)) { throw "Gradle wrapper not found at: $gradlew" }
  & $gradlew assembleDebug
}

function Build-One {
  param([string]$m)

  Write-Host "\n=== Building $m APK ===" -ForegroundColor Cyan

  Push-Location $AppDir
  try {
    if (Test-Path (Join-Path $AppDir 'package-lock.json')) {
      Write-Host "Installing dependencies (npm ci)" -ForegroundColor DarkCyan
      npm ci
    } else {
      Write-Host "Installing dependencies (npm install)" -ForegroundColor DarkCyan
      npm install
    }

    $env:EXPO_PUBLIC_USER_MODE = $m
    $env:EXPO_PUBLIC_API_BASE = $ApiBase

    $args = @('prebuild','-p','android')
    if ($Clean) { $args += '--clean' }
    Write-Host "Running: npx expo $($args -join ' ')" -ForegroundColor DarkCyan
    npx expo $args

    $AndroidDir = Join-Path $AppDir 'android'
    Push-Location $AndroidDir
    try {
      Write-Host "Assembling debug APK with Gradle" -ForegroundColor DarkCyan
      Invoke-Gradle -AndroidDir $AndroidDir
      $apk = Join-Path $AndroidDir 'app\build\outputs\apk\debug\app-debug.apk'
      if (!(Test-Path $apk)) { throw "APK not found at: $apk" }
      $out = Join-Path $DistDir "haustap-$m-debug.apk"
      Copy-Item $apk $out -Force
      Write-Host "Saved: $out" -ForegroundColor Green
    } finally { Pop-Location }
  } finally { Pop-Location }
}

switch ($Mode) {
  'client'   { Build-One 'client' }
  'provider' { Build-One 'provider' }
  'both'     { Build-One 'client'; Build-One 'provider' }
}

Write-Host "\nDone. Find APKs in: $DistDir" -ForegroundColor Green