# Laravel BiblioTech - Guide d'Installation

Ce guide documente toutes les étapes prises pour configurer et exécuter l'application Laravel sur Windows.

## Installation des Prérequis

### 1. Installation de PHP

PHP a été installé manuellement car il n'était pas disponible sur le système.

**Étapes :**
1. Téléchargement de PHP 8.3.26 (Windows x64 Thread Safe)
2. Extraction vers `C:\php`
3. Création de `php.ini` depuis `php.ini-development`
4. Activation des extensions requises dans `php.ini` :
   - `extension=openssl`
   - `extension=curl`
   - `extension=mbstring`
   - `extension=fileinfo`
   - `extension_dir = "ext"`

**Script PowerShell Utilisé (install-php.ps1) :**
```powershell
$phpZip = "$env:TEMP\php.zip"
$phpDir = "C:\php"

Write-Host "Téléchargement de PHP..."
Invoke-WebRequest -Uri 'https://windows.php.net/downloads/releases/latest/php-8.3-Win32-vs16-x64-latest.zip' -OutFile $phpZip -UseBasicParsing

Write-Host "Extraction de PHP..."
Expand-Archive -Path $phpZip -DestinationPath $phpDir -Force

Write-Host "Ajout de PHP au PATH..."
$currentPath = [Environment]::GetEnvironmentVariable('Path', 'Machine')
if ($currentPath -notlike "*$phpDir*") {
    [Environment]::SetEnvironmentVariable('Path', "$currentPath;$phpDir", 'Machine')
}

$env:Path += ";$phpDir"

Write-Host "Nettoyage..."
Remove-Item $phpZip

Write-Host "PHP installé avec succès!"
php --version
```

**Script de Configuration PHP (configure-php.ps1) :**
```powershell
$phpDir = "C:\php"
$phpIni = "$phpDir\php.ini"

if (!(Test-Path $phpIni)) {
    Write-Host "Création de php.ini..."
    Copy-Item "$phpDir\php.ini-development" $phpIni
}

Write-Host "Activation des extensions PHP..."
$content = Get-Content $phpIni
$content = $content -replace ';extension=openssl', 'extension=openssl'
$content = $content -replace ';extension=curl', 'extension=curl'
$content = $content -replace ';extension=mbstring', 'extension=mbstring'
$content = $content -replace ';extension=fileinfo', 'extension=fileinfo'
$content = $content -replace ';extension_dir = "ext"', 'extension_dir = "ext"'
Set-Content -Path $phpIni -Value $content

Write-Host "PHP configuré avec succès!"
```

### 2. Installation de Composer

Composer a été installé pour gérer les dépendances PHP.

**Étapes :**
1. Téléchargement de l'installateur Composer depuis getcomposer.org
2. Installation vers `C:\php\composer.phar`
3. Création du fichier batch wrapper `C:\php\composer.bat`

**Script PowerShell Utilisé (install-composer.ps1) :**
```powershell
$composerSetup = "$env:TEMP\composer-setup.php"

Write-Host "Téléchargement de l'installateur Composer..."
Invoke-WebRequest -Uri 'https://getcomposer.org/installer' -OutFile $composerSetup -UseBasicParsing

Write-Host "Installation de Composer..."
& C:\php\php $composerSetup --install-dir=C:\php --filename=composer.phar

Write-Host "Création du wrapper composer.bat..."
$composerBat = @"
@echo off
C:\php\php C:\php\composer.phar %*
"@
Set-Content -Path "C:\php\composer.bat" -Value $composerBat

Write-Host "Nettoyage..."
Remove-Item $composerSetup

Write-Host "Composer installé avec succès!"
& C:\php\composer.bat --version
```

## Configuration de l'Application Laravel

### 3. Installation des Dépendances Laravel

Une fois PHP et Composer installés, les dépendances Laravel ont été installées.

**Commande :**
```bash
cd C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio
C:\php\composer.bat install
```

Cela a installé tous les 113 packages requis par Laravel, incluant :
- Laravel Framework 12.31.1
- Composants Symfony
- PHPUnit pour les tests
- Outils de développement

### 4. Configuration de l'Environnement

L'application nécessite un fichier `.env` avec une clé de chiffrement.

**Étapes :**
1. Copier `.env.example` vers `.env`
2. Générer la clé d'application

**Commandes :**
```bash
copy .env.example .env
C:\php\php artisan key:generate
```

### 5. Démarrage du Serveur de Développement

Lancement du serveur de développement Laravel :

**Commande :**
```bash
cd C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio
C:\php\php artisan serve
```

L'application sera disponible à : **http://127.0.0.1:8000**

## Démarrage Rapide (Pour Utilisation Future)

Si tout est déjà installé, vous pouvez démarrer l'application avec :

```bash
cd C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio
C:\php\php artisan serve
```

Ou utiliser les scripts batch fournis :
```bash
cd C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio
.\scripts\start.bat
```

## Dépannage

### Problèmes Courants

**Problème : "PHP not found"**
- Solution : Assurez-vous que `C:\php` est dans votre PATH système
- Ou utilisez le chemin complet : `C:\php\php`

**Problème : "Composer not found"**
- Solution : Utilisez `C:\php\composer.bat` au lieu de juste `composer`

**Problème : "No application encryption key"**
- Solution : Exécutez `php artisan key:generate`

**Problème : "500 Server Error"**
- Vérifiez les logs : `storage\logs\laravel.log`
- Assurez-vous que le fichier `.env` existe
- Vérifiez que APP_KEY est défini dans `.env`

**Problème : "Missing vendor folder"**
- Solution : Exécutez `composer install`

## Exigences Système Remplies

- ✅ PHP 8.3.26 (répond à l'exigence de Laravel 12 : PHP ^8.2)
- ✅ Composer 2.8.12
- ✅ Extensions PHP Requises :
  - OpenSSL
  - Curl
  - Mbstring
  - Fileinfo

## Notes Additionnelles

- PHP est installé à : `C:\php`
- Composer est à : `C:\php\composer.bat`
- Emplacement du projet : `C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio`
- Serveur par défaut : `http://127.0.0.1:8000`

## Outils de Développement Inclus

Le projet inclut ces outils de développement (depuis composer.json) :
- **Laravel Sail** - Environnement de développement Docker
- **Laravel Pail** - Visualisation des logs
- **Laravel Pint** - Correcteur de style de code
- **PHPUnit** - Framework de tests
- **Laravel Tinker** - REPL interactif

## Prochaines Étapes

1. Configurez votre base de données dans `.env`
2. Exécutez les migrations : `php artisan migrate`
3. Alimentez la base de données (si nécessaire) : `php artisan db:seed`
4. Installez les dépendances frontend : `npm install`
5. Compilez les assets frontend : `npm run dev` ou `npm run build`

---

**Configuration terminée avec succès le :** 2025-10-07

**Versions installées :**
- PHP : 8.3.26
- Composer : 2.8.12
- Laravel : 12.31.1

---

## Crédits

Configuration et automatisation réalisées par **Mohammad Radwan**.

Tous les scripts d'installation, configurations et documentation ont été créés pour déployer avec succès l'application Laravel BiblioTech.
