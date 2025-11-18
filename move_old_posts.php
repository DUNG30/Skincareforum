<?php
$oldPath = __DIR__ . '/storage/app/private/public/posts';
$newPath = __DIR__ . '/storage/app/public/posts';

if (!file_exists($newPath)) mkdir($newPath, 0777, true);

$files = scandir($oldPath);
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    rename($oldPath.'/'.$file, $newPath.'/'.$file);
    echo "Đã di chuyển: $file\n";
}
