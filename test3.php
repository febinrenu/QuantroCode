<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tenant = App\Tenant::find('demo');
    if (!$tenant) {
        $tenant = App\Tenant::create(['id' => 'demo']);
        $tenant->domains()->create(['domain' => 'demo']);
    }
    $job = new App\Jobs\ProvisionTenantWorkspace('demo');
    $job->handle();
    echo "Success!\n";
} catch (\Throwable $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
