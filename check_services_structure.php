<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');
$stmt = $db->query('DESCRIBE services');
echo "Services table structure:\n";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $col) {
    echo $col['Field'] . ' - ' . $col['Type'] . ' - Null: ' . $col['Null'] . ' - Default: ' . ($col['Default'] ?? 'NULL') . "\n";
}

echo "\n\nCurrent services data:\n";
$stmt = $db->query('SELECT * FROM services');
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "ID: " . $row['id'] . " - Fee: " . ($row['fee'] ?? 'NULL') . "\n";
}
