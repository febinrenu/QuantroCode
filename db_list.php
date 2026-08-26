<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $stmt = $pdo->query('SHOW DATABASES');
    echo "Available MySQL Databases:\n";
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo "- " . $row[0] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
