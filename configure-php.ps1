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
