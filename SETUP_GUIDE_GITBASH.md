# Laravel BiblioTech - Setup Guide (Git Bash)

This guide documents all the steps to set up and run the Laravel application on Windows using **Git Bash**.

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

**Git Bash Script (install-php.sh):**
```bash
#!/bin/bash

PHP_ZIP="/tmp/php.zip"
PHP_DIR="/c/php"

echo "Downloading PHP..."
curl -L -o "$PHP_ZIP" "https://windows.php.net/downloads/releases/latest/php-8.3-Win32-vs16-x64-latest.zip"

echo "Extracting PHP..."
mkdir -p "$PHP_DIR"
unzip -o "$PHP_ZIP" -d "$PHP_DIR"

echo "Cleaning up..."
rm -f "$PHP_ZIP"

echo "PHP installed successfully!"
/c/php/php --version

echo ""
echo "To add PHP to your PATH permanently, add this line to your ~/.bashrc:"
echo 'export PATH="/c/php:$PATH"'
```

**PHP Configuration Script (configure-php.sh):**
```bash
#!/bin/bash

PHP_DIR="/c/php"
PHP_INI="$PHP_DIR/php.ini"

if [ ! -f "$PHP_INI" ]; then
    echo "Creating php.ini..."
    cp "$PHP_DIR/php.ini-development" "$PHP_INI"
fi

echo "Enabling PHP extensions..."
sed -i 's/;extension=openssl/extension=openssl/' "$PHP_INI"
sed -i 's/;extension=curl/extension=curl/' "$PHP_INI"
sed -i 's/;extension=mbstring/extension=mbstring/' "$PHP_INI"
sed -i 's/;extension=fileinfo/extension=fileinfo/' "$PHP_INI"
sed -i 's/;extension_dir = "ext"/extension_dir = "ext"/' "$PHP_INI"

echo "PHP configured successfully!"
```

### 2. Composer Installation

Composer was installed to manage PHP dependencies.

**Steps:**
1. Downloaded Composer installer from getcomposer.org
2. Installed to `C:\php\composer.phar`
3. Created wrapper script for Git Bash

**Git Bash Script (install-composer.sh):**
```bash
#!/bin/bash

COMPOSER_SETUP="/tmp/composer-setup.php"
PHP_DIR="/c/php"

echo "Downloading Composer installer..."
curl -sS https://getcomposer.org/installer -o "$COMPOSER_SETUP"

echo "Installing Composer..."
/c/php/php "$COMPOSER_SETUP" --install-dir="$PHP_DIR" --filename=composer.phar

echo "Cleaning up..."
rm -f "$COMPOSER_SETUP"

echo "Composer installed successfully!"
/c/php/php /c/php/composer.phar --version

echo ""
echo "To use composer, run: php /c/php/composer.phar [command]"
echo "Or create an alias in ~/.bashrc:"
echo 'alias composer="php /c/php/composer.phar"'
```

## Laravel Application Setup

### 3. Install Laravel Dependencies

Once PHP and Composer were installed, Laravel dependencies were installed.

**Commands (Git Bash):**
```bash
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio
php /c/php/composer.phar install
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

**Commands (Git Bash):**
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Start the Development Server

Launch the Laravel development server:

**Command (Git Bash):**
```bash
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio
php artisan serve
```

The application will be available at: **http://127.0.0.1:8000**

## Quick Start (For Future Use)

If everything is already installed, you can start the app with:

```bash
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio
php artisan serve
```

**Optional: Create Bash Aliases**

Add these to your `~/.bashrc` for easier commands:
```bash
export PATH="/c/php:$PATH"
alias composer="php /c/php/composer.phar"
alias artisan="php artisan"
```

Then reload your config:
```bash
source ~/.bashrc
```

Now you can simply run:
```bash
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio
artisan serve
```

## Troubleshooting

### Common Issues

**Issue: "PHP not found"**
- Solution: Add PHP to PATH or use full path `/c/php/php`
- Add to `~/.bashrc`: `export PATH="/c/php:$PATH"`

**Issue: "Composer not found"**
- Solution: Use `php /c/php/composer.phar` instead of just `composer`
- Or create alias: `alias composer="php /c/php/composer.phar"`

**Issue: "No application encryption key"**
- Solution: Run `php artisan key:generate`

**Issue: "500 Server Error"**
- Check logs: `storage/logs/laravel.log`
- Make sure `.env` file exists
- Ensure APP_KEY is set in `.env`

**Issue: "Missing vendor folder"**
- Solution: Run `composer install`

**Issue: "unzip command not found"**
- Git Bash should include unzip. If not, download PHP manually and extract using File Explorer

## System Requirements Met

- ✅ PHP 8.3.26 (meets Laravel 12 requirement of PHP ^8.2)
- ✅ Composer 2.8.12
- ✅ Required PHP Extensions:
  - OpenSSL
  - Curl
  - Mbstring
  - Fileinfo

## Additional Notes

- PHP is installed at: `C:\php` (Git Bash path: `/c/php`)
- Composer is at: `C:\php\composer.phar` (Git Bash path: `/c/php/composer.phar`)
- Project location: `C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio`
- Git Bash project path: `/c/Users/m.radwan/PhpstormProjects/laravel-bts-sio`
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

## Git Bash Tips

### Path Conversions
- Windows: `C:\Users\username` → Git Bash: `/c/Users/username`
- Always use forward slashes in Git Bash
- Use quotes for paths with spaces: `"/c/Program Files/PHP"`

### Useful Commands
```bash
# Navigate to project
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio

# Run artisan commands
php artisan list
php artisan serve
php artisan migrate

# Run composer commands
php /c/php/composer.phar install
php /c/php/composer.phar update
```

---

## Credits

Setup automation and documentation performed by **Mohammad Radwan**.

All installation scripts, configurations, and documentation were created to successfully deploy the Laravel BiblioTech application.
