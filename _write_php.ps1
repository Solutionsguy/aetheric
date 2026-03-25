# PowerShell Helper Script for Writing PHP Files
# Avoids JSON escaping issues by using direct file operations
#
# Usage:
#   .\_write_php.ps1 -File "path\to\file.php" -Content @"
#   <?php
#   // Your PHP code here
#   "@

param(
    [Parameter(Mandatory=$true)]
    [string]$File,
    
    [Parameter(ValueFromPipeline=$true)]
    [string]$Content
)

if ($input) {
    $Content = ($input -join "`n")
}

if (-not $Content) {
    Write-Error "No content provided"
    exit 1
}

$dir = Split-Path -Parent $File
if ($dir -and -not (Test-Path $dir)) {
    New-Item -ItemType Directory -Path $dir -Force | Out-Null
}

[System.IO.File]::WriteAllText($File, $Content, [System.Text.Encoding]::UTF8)

if (Test-Path $File) {
    $size = (Get-Item $File).Length
    Write-Host "SUCCESS: Written $size bytes to $File" -ForegroundColor Green
} else {
    Write-Error "Failed to write file"
    exit 1
}
