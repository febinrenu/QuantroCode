<?php
echo "========================================\n";
echo "       CENTRAL APPLICATION (SUPERADMINS)\n";
echo "========================================\n";
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=quantrocousr_dbx7", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($users)) {
        echo "No central users found.\n";
    } else {
        foreach ($users as $u) {
            echo "- Email: {$u['email']} | Name: {$u['name']}\n";
        }
    }
} catch (Exception $e) {
    echo "Error querying dbx7 users: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "           TENANTS & ADMINS\n";
echo "========================================\n";
try {
    $stmt = $pdo->query("SELECT * FROM tenants");
    $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($tenants)) {
        echo "No tenants found.\n";
    } else {
        foreach ($tenants as $t) {
            $data = json_decode($t['data'], true);
            $dbName = $data['tenancy_db_name'] ?? 'Unknown';
            echo "Tenant ID: {$t['id']}\n";
            echo "DB Name:   {$dbName}\n";

            try {
                $pdo2 = new PDO("mysql:host=127.0.0.1;dbname=$dbName", "root", "");
                $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt2 = $pdo2->query("SELECT * FROM users");
                $tenantUsers = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                if (empty($tenantUsers)) {
                    echo "--> No users found in this tenant database.\n";
                } else {
                    echo "--> Tenant Users:\n";
                    foreach ($tenantUsers as $tu) {
                        $name = $tu['name'] ?? trim(($tu['first_name'] ?? '') . ' ' . ($tu['last_name'] ?? ''));
                        $email = $tu['email'] ?? 'UNKNOWN';
                        $uid = $tu['id'] ?? '?';
                        echo "      - ID: {$uid} | Name: {$name} | Email: {$email}\n";
                    }
                }
            } catch (Exception $e) {
                echo "--> Error connecting to tenant database: " . $e->getMessage() . "\n";
            }
            echo "--------------------------\n";
        }
    }
} catch (Exception $e) {
    echo "Error querying tenants: " . $e->getMessage() . "\n";
}
echo "\n(Note: Passwords in SaaS templates are typically '123456' by default!)\n";
