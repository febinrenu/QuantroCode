<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=quantrocousr_db3', 'root', '');
    $stmt = $pdo->query('SELECT id, firstname, lastname, email, role_id, statut FROM users');
    echo "Tenant Users in quantrocousr_db3 (newstock):\n\n";
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $u) {
        $name = trim($u['firstname'] . ' ' . $u['lastname']);
        echo "- Email: " . $u['email'] . "\n";
        echo "  Name:  " . $name . "\n";
        echo "  Role:  " . $u['role_id'] . " (Active: " . $u['statut'] . ")\n\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
