# Laravel BiblioTech - Guide d'Installation (Git Bash)

Ce guide documente toutes les étapes pour configurer et exécuter l'application Laravel sur Windows en utilisant **Git Bash**.

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

**Script Git Bash (install-php.sh) :**
```bash
#!/bin/bash

PHP_ZIP="/tmp/php.zip"
PHP_DIR="/c/php"

echo "Téléchargement de PHP..."
curl -L -o "$PHP_ZIP" "https://windows.php.net/downloads/releases/latest/php-8.3-Win32-vs16-x64-latest.zip"

echo "Extraction de PHP..."
mkdir -p "$PHP_DIR"
unzip -o "$PHP_ZIP" -d "$PHP_DIR"

echo "Nettoyage..."
rm -f "$PHP_ZIP"

echo "PHP installé avec succès!"
/c/php/php --version

echo ""
echo "Pour ajouter PHP à votre PATH de manière permanente, ajoutez cette ligne à votre ~/.bashrc:"
echo 'export PATH="/c/php:$PATH"'
```

**Script de Configuration PHP (configure-php.sh) :**
```bash
#!/bin/bash

PHP_DIR="/c/php"
PHP_INI="$PHP_DIR/php.ini"

if [ ! -f "$PHP_INI" ]; then
    echo "Création de php.ini..."
    cp "$PHP_DIR/php.ini-development" "$PHP_INI"
fi

echo "Activation des extensions PHP..."
sed -i 's/;extension=openssl/extension=openssl/' "$PHP_INI"
sed -i 's/;extension=curl/extension=curl/' "$PHP_INI"
sed -i 's/;extension=mbstring/extension=mbstring/' "$PHP_INI"
sed -i 's/;extension=fileinfo/extension=fileinfo/' "$PHP_INI"
sed -i 's/;extension_dir = "ext"/extension_dir = "ext"/' "$PHP_INI"

echo "PHP configuré avec succès!"
```

### 2. Installation de Composer

Composer a été installé pour gérer les dépendances PHP.

**Étapes :**
1. Téléchargement de l'installateur Composer depuis getcomposer.org
2. Installation vers `C:\php\composer.phar`
3. Création d'un script wrapper pour Git Bash

**Script Git Bash (install-composer.sh) :**
```bash
#!/bin/bash

COMPOSER_SETUP="/tmp/composer-setup.php"
PHP_DIR="/c/php"

echo "Téléchargement de l'installateur Composer..."
curl -sS https://getcomposer.org/installer -o "$COMPOSER_SETUP"

echo "Installation de Composer..."
/c/php/php "$COMPOSER_SETUP" --install-dir="$PHP_DIR" --filename=composer.phar

echo "Nettoyage..."
rm -f "$COMPOSER_SETUP"

echo "Composer installé avec succès!"
/c/php/php /c/php/composer.phar --version

echo ""
echo "Pour utiliser composer, exécutez: php /c/php/composer.phar [commande]"
echo "Ou créez un alias dans ~/.bashrc:"
echo 'alias composer="php /c/php/composer.phar"'
```

## Configuration de l'Application Laravel

### 3. Installation des Dépendances Laravel

Une fois PHP et Composer installés, les dépendances Laravel ont été installées.

**Commandes (Git Bash) :**
```bash
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio
php /c/php/composer.phar install
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

**Commandes (Git Bash) :**
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Démarrage du Serveur de Développement

Lancement du serveur de développement Laravel :

**Commande (Git Bash) :**
```bash
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio
php artisan serve
```

L'application sera disponible à : **http://127.0.0.1:8000**

## Démarrage Rapide (Pour Utilisation Future)

Si tout est déjà installé, vous pouvez démarrer l'application avec :

```bash
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio
php artisan serve
```

**Optionnel : Créer des Alias Bash**

Ajoutez ces lignes à votre `~/.bashrc` pour des commandes plus faciles :
```bash
export PATH="/c/php:$PATH"
alias composer="php /c/php/composer.phar"
alias artisan="php artisan"
```

Puis rechargez votre configuration :
```bash
source ~/.bashrc
```

Maintenant vous pouvez simplement exécuter :
```bash
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio
artisan serve
```

## Dépannage

### Problèmes Courants

**Problème : "PHP not found"**
- Solution : Ajoutez PHP au PATH ou utilisez le chemin complet `/c/php/php`
- Ajoutez à `~/.bashrc`: `export PATH="/c/php:$PATH"`

**Problème : "Composer not found"**
- Solution : Utilisez `php /c/php/composer.phar` au lieu de juste `composer`
- Ou créez un alias : `alias composer="php /c/php/composer.phar"`

**Problème : "No application encryption key"**
- Solution : Exécutez `php artisan key:generate`

**Problème : "500 Server Error"**
- Vérifiez les logs : `storage/logs/laravel.log`
- Assurez-vous que le fichier `.env` existe
- Vérifiez que APP_KEY est défini dans `.env`

**Problème : "Missing vendor folder"**
- Solution : Exécutez `composer install`

**Problème : "unzip command not found"**
- Git Bash devrait inclure unzip. Sinon, téléchargez PHP manuellement et extrayez avec l'Explorateur de fichiers

## Exigences Système Remplies

- ✅ PHP 8.3.26 (répond à l'exigence de Laravel 12 : PHP ^8.2)
- ✅ Composer 2.8.12
- ✅ Extensions PHP Requises :
  - OpenSSL
  - Curl
  - Mbstring
  - Fileinfo

## Notes Additionnelles

- PHP est installé à : `C:\php` (chemin Git Bash : `/c/php`)
- Composer est à : `C:\php\composer.phar` (chemin Git Bash : `/c/php/composer.phar`)
- Emplacement du projet : `C:\Users\m.radwan\PhpstormProjects\laravel-bts-sio`
- Chemin Git Bash du projet : `/c/Users/m.radwan/PhpstormProjects/laravel-bts-sio`
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

## Astuces Git Bash

### Conversions de Chemins
- Windows : `C:\Users\username` → Git Bash : `/c/Users/username`
- Utilisez toujours des barres obliques dans Git Bash
- Utilisez des guillemets pour les chemins avec des espaces : `"/c/Program Files/PHP"`

### Commandes Utiles
```bash
# Naviguer vers le projet
cd /c/Users/m.radwan/PhpstormProjects/laravel-bts-sio

# Exécuter des commandes artisan
php artisan list
php artisan serve
php artisan migrate

# Exécuter des commandes composer
php /c/php/composer.phar install
php /c/php/composer.phar update
```

---

## Crédits

Configuration et automatisation réalisées par **Mohammad Radwan**.

Tous les scripts d'installation, configurations et documentation ont été créés pour déployer avec succès l'application Laravel BiblioTech.
