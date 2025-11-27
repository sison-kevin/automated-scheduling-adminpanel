<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');

echo "=== CURRENT SERVICES ===\n";
$stmt = $db->query('SELECT * FROM services');
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "ID: " . $row['id'] . " - " . $row['service_name'] . "\n";
}

echo "\n=== CURRENT VETERINARIANS ===\n";
$stmt = $db->query('SELECT * FROM veterinarians');
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "ID: " . $row['id'] . " - " . $row['name'] . " (" . $row['specialization'] . ") - Active: " . $row['is_active'] . "\n";
}
