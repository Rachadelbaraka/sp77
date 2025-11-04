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
