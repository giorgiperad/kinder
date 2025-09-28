<?php

// Fix PHP 8.3 compatibility issues for Laravel 7
// Find all Laravel framework files that might have compatibility issues
$files = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('vendor/laravel/framework/src'));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (preg_match('/implements.*ArrayAccess|implements.*Countable|implements.*JsonSerializable|implements.*IteratorAggregate/', $content)) {
            $files[] = $file->getPathname();
        }
    }
}

$patterns = [
    '/public function offsetExists\(\$key\)/' => '#[\ReturnTypeWillChange]' . "\n    public function offsetExists(\$key)",
    '/public function offsetGet\(\$key\)/' => '#[\ReturnTypeWillChange]' . "\n    public function offsetGet(\$key)",
    '/public function offsetSet\(\$key, \$value\)/' => '#[\ReturnTypeWillChange]' . "\n    public function offsetSet(\$key, \$value)",
    '/public function offsetUnset\(\$key\)/' => '#[\ReturnTypeWillChange]' . "\n    public function offsetUnset(\$key)",
    '/public function count\(\)/' => '#[\ReturnTypeWillChange]' . "\n    public function count()",
    '/public function getIterator\(\)/' => '#[\ReturnTypeWillChange]' . "\n    public function getIterator()",
    '/public function jsonSerialize\(\)/' => '#[\ReturnTypeWillChange]' . "\n    public function jsonSerialize()",
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        foreach ($patterns as $pattern => $replacement) {
            // Only add attribute if not already present
            if (preg_match($pattern, $content) && !preg_match('/\#\[\\\\ReturnTypeWillChange\]/', $content)) {
                $content = preg_replace($pattern, $replacement, $content);
            }
        }
        
        file_put_contents($file, $content);
        echo "Fixed compatibility issues in: $file\n";
    }
}

echo "PHP 8.3 compatibility fixes applied!\n";