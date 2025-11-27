<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');
$stmt = $db->query('DESCRIBE veterinarians');
echo "Veterinarians table structure:\n";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $col) {
    echo $col['Field'] . ' - ' . $col['Type'] . "\n";
}
