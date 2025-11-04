# Laravel BiblioTech - Setup Guide

This guide documents all the steps taken to set up and run the Laravel application on Windows.

## Prerequisites Installation

### 1. PHP Installation

PHP was installed manually since it wasn't available on the system.

**Steps:**
1. Downloaded PHP 8.3.26 (Windows x64 Thread Safe)
2. Extracted to `C:\php`
3. Created `php.ini` from `php.ini-development`
4. Enabled required extensions in `php.ini`:
   - `extension=openssl`
   - `extension=curl`
   - `extension=mbstring`
   - `extension=fileinfo`
   - `extension_dir = "ext"`

**PowerShell Script Used (install-php.ps1):**
```powershell
$phpZip = "$env:TEMP\php.zip"
$phpDir = "C:\php"

Write-Host "Downloading PHP..."
Invoke-WebRequest -Uri 'https://windows.php.net/downloads/releases/latest/php-8.3-Win32-vs16-x64-latest.zip' -OutFile $phpZip -UseBasicParsing

Write-Host "Extracting PHP..."
Expand-Archive -Path $phpZip -DestinationPath $phpDir -Force

Write-Host "Adding PHP to PATH..."
$currentPath = [Environment]::GetEnvironmentVariable('Path', 'Machine')
if ($currentPath -notlike "*$phpDir*") {
    [Environment]::SetEnvironmentVariable('Path', "$currentPath;$phpDir", 'Machine')
}

$env:Path += ";$phpDir"

Write-Host "Cleaning up..."
Remove-Item $phpZip

Write-Host "PHP installed successfully!"
php --version
```

**PHP Configuration Script (configure-php.ps1):**
```powershell
$phpDir = "C:\php"
$phpIni = "$phpDir\php.ini"

if (!(Test-Path $phpIni)) {
    Write-Host "Creating php.ini..."
    Copy-Item "$phpDir\php.ini-development" $phpIni
}

Write-Host "Enabling PHP extensions..."
$content = Get-Content $phpIni
$content = $content -replace ';extension=openssl', 'extension=openssl'
$content = $content -replace ';extension=curl', 'extension=curl'
$content = $content -replace ';extension=mbstring', 'extension=mbstring'
$content = $content -replace ';extension=fileinfo', 'extension=fileinfo'
$content = $content -replace ';extension_dir = "ext"', 'extension_dir = "ext"'
Set-Content -Path $phpIni -Value $content

Write-Host "PHP configured successfully!"
```

### 2. Composer Installation

Composer was installed to manage PHP dependencies.

**Steps:**
1. Downloaded Composer installer from getcomposer.org
2. Installed to `C:\php\composer.phar`
3. Created wrapper batch file `C:\php\composer.bat`

**PowerShell Script Used (install-composer.ps1):**
```powershell
$composerSetup = "$env:TEMP\composer-setup.php"

Write-Host "Downloading Composer installer..."
Invoke-WebRequest -Uri 'https://getcomposer.org/installer' -OutFile $composerSetup -UseBasicParsing

Write-Host "Installing Composer..."
& C:\php\php $composerSetup --install-dir=C:\php --filename=composer.phar

Write-Host "Creating composer.bat wrapper..."
$composerBat = @"
@echo off
C:\php\php C:\php\composer.phar %*
"@
Set-Content -Path "C:\php\composer.bat" -Value $composerBat

Write-Host "Cleaning up..."
Remove-Item $composerSetup

Write-Host "Composer installed successfully!"
& C:\php\composer.bat --version
```

## Laravel Application Setup

### 3. Install Laravel Dependencies

Once PHP and Composer were installed, Laravel dependencies were installed.

**Command:**
```bash
cd C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio
C:\php\composer.bat install
```

This installed all 113 packages required by Laravel, including:
- Laravel Framework 12.31.1
- Symfony components
- PHPUnit for testing
- Development tools

### 4. Environment Configuration

The application requires a `.env` file with an encryption key.

**Steps:**
1. Copy `.env.example` to `.env`
2. Generate application key

**Commands:**
```bash
copy .env.example .env
C:\php\php artisan key:generate
```

### 5. Start the Development Server

Launch the Laravel development server:

**Command:**
```bash
cd C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio
C:\php\php artisan serve
```

The application will be available at: **http://127.0.0.1:8000**

## Quick Start (For Future Use)

If everything is already installed, you can start the app with:

```bash
cd C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio
C:\php\php artisan serve
```

Or use the provided batch scripts:
```bash
cd C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio
.\scripts\start.bat
```

## Troubleshooting

### Common Issues

**Issue: "PHP not found"**
- Solution: Make sure `C:\php` is in your system PATH
- Or use the full path: `C:\php\php`

**Issue: "Composer not found"**
- Solution: Use `C:\php\composer.bat` instead of just `composer`

**Issue: "No application encryption key"**
- Solution: Run `php artisan key:generate`

**Issue: "500 Server Error"**
- Check logs: `storage\logs\laravel.log`
- Make sure `.env` file exists
- Ensure APP_KEY is set in `.env`

**Issue: "Missing vendor folder"**
- Solution: Run `composer install`

## System Requirements Met

- ✅ PHP 8.3.26 (meets Laravel 12 requirement of PHP ^8.2)
- ✅ Composer 2.8.12
- ✅ Required PHP Extensions:
  - OpenSSL
  - Curl
  - Mbstring
  - Fileinfo

## Additional Notes

- PHP is installed at: `C:\php`
- Composer is at: `C:\php\composer.bat`
- Project location: `C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio`
- Default server: `http://127.0.0.1:8000`

## Development Tools Included

The project includes these development tools (from composer.json):
- **Laravel Sail** - Docker development environment
- **Laravel Pail** - Log viewing
- **Laravel Pint** - Code style fixer
- **PHPUnit** - Testing framework
- **Laravel Tinker** - Interactive REPL

## Next Steps

1. Configure your database in `.env`
2. Run migrations: `php artisan migrate`
3. Seed database (if needed): `php artisan db:seed`
4. Install frontend dependencies: `npm install`
5. Build frontend assets: `npm run dev` or `npm run build`

---

**Setup completed successfully on:** 2025-10-07

**Installed versions:**
- PHP: 8.3.26
- Composer: 2.8.12
- Laravel: 12.31.1

---

## Credits

Setup automation and configuration performed by **Mohammad Radwan**.

All installation scripts, configurations, and documentation were created to successfully deploy the Laravel BiblioTech application.
