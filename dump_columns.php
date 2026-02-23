<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = \Illuminate\Support\Facades\Schema::getColumnListing('products');
file_put_contents('product_columns.json', json_encode($columns, JSON_PRETTY_PRINT));
echo "Columns dumped to product_columns.json" . PHP_EOL;
