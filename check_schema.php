<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');
$stmt = $db->query('DESCRIBE appointments');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Appointments table structure:\n";
foreach ($columns as $col) {
    echo $col['Field'] . ' - ' . $col['Type'] . "\n";
}
