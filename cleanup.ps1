# PowerShell cleanup script for Powerlug project
# This script removes unnecessary files and optimizes the project size

Write-Host "Starting project cleanup..." -ForegroundColor Green
Write-Host ""

# Remove node_modules if it exists
if (Test-Path "node_modules") {
    Write-Host "Removing node_modules..." -ForegroundColor Yellow
    Remove-Item -Path "node_modules" -Recurse -Force -ErrorAction SilentlyContinue
    Write-Host "node_modules removed" -ForegroundColor Green
}

# Remove vendor if needed (only for development cleanup, reinstall with composer)
# Uncomment the following if you want to remove vendor:
# if (Test-Path "vendor") {
#     Write-Host "❌ Removing vendor..." -ForegroundColor Yellow
#     Remove-Item -Path "vendor" -Recurse -Force -ErrorAction SilentlyContinue
#     Write-Host "✅ vendor removed"
# }

# Remove log files
Write-Host "Cleaning up logs..." -ForegroundColor Yellow
Remove-Item -Path "storage/logs/*.log" -Force -ErrorAction SilentlyContinue
Write-Host "Logs cleaned" -ForegroundColor Green

# Remove Laravel cache
if (Test-Path "storage/framework/cache") {
    Write-Host "❌ Clearing framework cache..." -ForegroundColor Yellow
    Remove-Item -Path "storage/framework/cache/*" -Force -ErrorAction SilentlyContinue
    Write-Host "✅ Cache cleared"
}

# Remove Laravel views cache
if (Test-Path "storage/framework/views") {
    Write-Host "❌ Clearing view cache..." -ForegroundColor Yellow
    Remove-Item -Path "storage/framework/views/*.php" -Force -ErrorAction SilentlyContinue
    Write-Host "✅ View cache cleared"
}

# Remove build artifacts
if (Test-Path "public/js") {
    Write-Host "❌ Removing compiled JS..." -ForegroundColor Yellow
    Remove-Item -Path "public/js" -Recurse -Force -ErrorAction SilentlyContinue
}

if (Test-Path "public/css") {
    Write-Host "❌ Removing compiled CSS..." -ForegroundColor Yellow
    Remove-Item -Path "public/css" -Recurse -Force -ErrorAction SilentlyContinue
}

if (Test-Path "public/mix-manifest.json") {
    Write-Host "❌ Removing mix manifest..." -ForegroundColor Yellow
    Remove-Item -Path "public/mix-manifest.json" -Force -ErrorAction SilentlyContinue
}

# Optimize Git repository
Write-Host ""
Write-Host "🗑️ Optimizing Git repository..." -ForegroundColor Yellow
git gc --aggressive --prune=now
Write-Host "✅ Git repository optimized"

Write-Host ""
Write-Host "Cleanup complete!" -ForegroundColor Green

# Calculate new project size
$projectSize = (Get-ChildItem -Path "." -Recurse -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum / 1MB
Write-Host "Project size: $([math]::Round($projectSize, 2)) MB" -ForegroundColor Cyan
