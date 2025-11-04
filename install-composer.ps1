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
