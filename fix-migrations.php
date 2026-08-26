<?php

$dirs = ['database/migrations', 'database/migrations/tenant'];

foreach ($dirs as $dir) {
    if (!is_dir($dir))
        continue;

    $files = glob($dir . '/*.php');
    foreach ($files as $file) {
        $content = file_get_contents($file);

        // Match ->index('some_name') or ->unique('some_name')
        // We only want to replace scalar string arguments.
        // It could be ->index('product_id')
        $content = preg_replace("/->index\(\s*['\"][a-zA-Z0-9_]+['\"]\s*\)/", '->index()', $content);
        $content = preg_replace("/->unique\(\s*['\"][a-zA-Z0-9_]+['\"]\s*\)/", '->unique()', $content);

        // For array arguments with custom names: ->index(['a', 'b'], 'custom_name')
        $content = preg_replace("/->index\(\s*(\[[^\]]+\])\s*,\s*['\"][a-zA-Z0-9_]+['\"]\s*\)/", '->index($1)', $content);
        $content = preg_replace("/->unique\(\s*(\[[^\]]+\])\s*,\s*['\"][a-zA-Z0-9_]+['\"]\s*\)/", '->unique($1)', $content);

        file_put_contents($file, $content);
    }
}

echo "Migrations patched.\n";
