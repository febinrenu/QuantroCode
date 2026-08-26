<?php
echo "===================================================\n";
echo "      Aureum Enterprise Local Database Setup\n";
echo "===================================================\n\n";

function importSqlFile($pdo, $sqlFile)
{
    if (!file_exists($sqlFile)) {
        die("❌ ERROR: Database dump '$sqlFile' not found in the root directory!\n");
    }
    $query = file_get_contents($sqlFile);
    try {
        $pdo->exec($query);
        echo "✅ Successfully imported $sqlFile\n";
    } catch (PDOException $e) {
        echo "❌ Error importing $sqlFile: " . $e->getMessage() . "\n";
    }
}

try {
    echo "1. Connecting to Local MySQL (XAMPP/WAMP/Laragon)...\n";
    $pdo = new PDO("mysql:host=127.0.0.1", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
    ]);

    echo "2. Provisioning databases...\n";
    $pdo->exec("DROP DATABASE IF EXISTS quantrocousr_dbx7");
    $pdo->exec("CREATE DATABASE quantrocousr_dbx7");

    $pdo->exec("DROP DATABASE IF EXISTS quantrocousr_db3");
    $pdo->exec("CREATE DATABASE quantrocousr_db3");

    // Import Central
    $pdo_central = new PDO("mysql:host=127.0.0.1;dbname=quantrocousr_dbx7", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
    ]);
    importSqlFile($pdo_central, 'quantrocousr_dbx7.sql');

    // Import Tenant
    $pdo_tenant = new PDO("mysql:host=127.0.0.1;dbname=quantrocousr_db3", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
    ]);
    importSqlFile($pdo_tenant, 'quantrocousr_db3.sql');

    echo "3. Patching Tenant Configurations for Local Development...\n";
    $stmt = $pdo_central->query("SELECT id, data FROM tenants");

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $t) {
        $id = $t['id'];
        $data = json_decode($t['data'], true);

        // Force local root credentials
        $data['tenancy_db_username'] = 'root';
        $data['tenancy_db_password'] = '';

        $newData = json_encode($data);

        $updateStmt = $pdo_central->prepare("UPDATE tenants SET data = :data WHERE id = :id");
        $updateStmt->execute([':data' => $newData, ':id' => $id]);
    }
    echo "✅ Tenant DB authentications normalized to 'root'.\n";

    echo "4. Upgrading 'newstock' Tenant to Enterprise Tier...\n";
    $tenant_id = '21f7a839-4846-4839-8938-d9fcfc0ab086'; // newstock 
    $plan_id = 3; // Enterprise

    $stmt = $pdo_central->prepare("SELECT id FROM tenant_subscriptions WHERE tenant_id = :tid");
    $stmt->execute([':tid' => $tenant_id]);

    if ($stmt->fetch()) {
        $update = $pdo_central->prepare("UPDATE tenant_subscriptions SET plan_id = :pid WHERE tenant_id = :tid");
        $update->execute([':pid' => $plan_id, ':tid' => $tenant_id]);
        echo "✅ Upgraded newstock to Enterprise (Plan ID: 3)!\n";
    }

    echo "\n===================================================\n";
    echo " SETUP COMPLETE! Your databases are exact replicas. \n";
    echo "===================================================\n";

} catch (Exception $e) {
    die("❌ Fatal Setup Error: " . $e->getMessage() . "\n");
}
