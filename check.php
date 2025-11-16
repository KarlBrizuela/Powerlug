<?php
echo "<h2>Laravel Deployment Diagnostics</h2>";

// Check if vendor exists
echo "<h3>1. Vendor Folder</h3>";
echo file_exists(__DIR__.'/vendor/autoload.php') ? '✅ vendor/autoload.php exists<br>' : '❌ vendor/autoload.php NOT FOUND<br>';

// Check if bootstrap exists
echo "<h3>2. Bootstrap Folder</h3>";
echo file_exists(__DIR__.'/bootstrap/app.php') ? '✅ bootstrap/app.php exists<br>' : '❌ bootstrap/app.php NOT FOUND<br>';

// Check if .env exists
echo "<h3>3. Environment File</h3>";
echo file_exists(__DIR__.'/.env') ? '✅ .env file exists<br>' : '❌ .env file NOT FOUND<br>';

// Check storage permissions
echo "<h3>4. Storage Permissions</h3>";
$storage = __DIR__.'/storage';
if (file_exists($storage)) {
    echo "Storage folder exists<br>";
    echo "Permissions: " . substr(sprintf('%o', fileperms($storage)), -4) . "<br>";
    echo is_writable($storage) ? '✅ Storage is writable<br>' : '❌ Storage is NOT writable<br>';
} else {
    echo '❌ Storage folder NOT FOUND<br>';
}

// Check bootstrap/cache permissions
echo "<h3>5. Bootstrap Cache Permissions</h3>";
$cache = __DIR__.'/bootstrap/cache';
if (file_exists($cache)) {
    echo "Bootstrap/cache folder exists<br>";
    echo "Permissions: " . substr(sprintf('%o', fileperms($cache)), -4) . "<br>";
    echo is_writable($cache) ? '✅ Bootstrap/cache is writable<br>' : '❌ Bootstrap/cache is NOT writable<br>';
} else {
    echo '❌ Bootstrap/cache folder NOT FOUND<br>';
}

// Try to load .env
echo "<h3>6. Environment Variables</h3>";
if (file_exists(__DIR__.'/.env')) {
    $env = file_get_contents(__DIR__.'/.env');
    echo strpos($env, 'APP_KEY=base64:') !== false ? '✅ APP_KEY is set<br>' : '❌ APP_KEY is NOT set<br>';
    echo strpos($env, 'APP_ENV=') !== false ? '✅ APP_ENV is set<br>' : '❌ APP_ENV is NOT set<br>';
} else {
    echo '❌ Cannot read .env file<br>';
}

// PHP Version
echo "<h3>7. PHP Version</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo version_compare(phpversion(), '7.3.0', '>=') ? '✅ PHP version is compatible<br>' : '❌ PHP version is too old<br>';

// Required extensions
echo "<h3>8. Required PHP Extensions</h3>";
$extensions = ['mbstring', 'openssl', 'pdo', 'tokenizer', 'xml', 'ctype', 'json'];
foreach ($extensions as $ext) {
    echo extension_loaded($ext) ? "✅ $ext loaded<br>" : "❌ $ext NOT loaded<br>";
}

echo "<h3>9. Error Log</h3>";
$logFile = __DIR__.'/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $log = file_get_contents($logFile);
    echo "<pre style='background:#f5f5f5;padding:10px;max-height:300px;overflow:auto;'>";
    echo htmlspecialchars(substr($log, -5000)); // Last 5000 chars
    echo "</pre>";
} else {
    echo "No log file found yet<br>";
}
?>
