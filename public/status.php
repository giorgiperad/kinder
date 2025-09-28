<?php
echo "<h1>Kinder Application Status</h1>";

// Test database connection
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=kinder_db', 'kinder_user', 'secret123');
    echo "<p>✅ Database connection: SUCCESS</p>";
    
    // Test if tables exist
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>✅ Database tables: " . implode(', ', $tables) . "</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Database connection: FAILED - " . $e->getMessage() . "</p>";
}

// Test PHP extensions
$extensions = ['mysql', 'pdo_mysql', 'zip', 'curl', 'mbstring', 'xml'];
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? '✅' : '❌';
    echo "<p>$status PHP Extension $ext</p>";
}

// Test file permissions
$dirs = ['../storage', '../bootstrap/cache'];
foreach ($dirs as $dir) {
    $writable = is_writable($dir) ? '✅' : '❌';
    echo "<p>$writable Directory $dir writable</p>";
}

echo "<p><strong>Environment:</strong> " . (file_exists('../.env') ? '✅ .env file exists' : '❌ .env file missing') . "</p>";
echo "<p><strong>Vendor:</strong> " . (file_exists('../vendor/autoload.php') ? '✅ Composer dependencies installed' : '❌ Composer dependencies missing') . "</p>";

echo "<hr>";
echo "<p>If all items show ✅, your Laravel application should work properly.</p>";
echo "<p>The main issue is PHP 8.3 compatibility with Laravel 7. Consider upgrading to Laravel 8+ or downgrading to PHP 8.0.</p>";
?>