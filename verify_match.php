<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');

echo "=== CHECKING GROOMING & WELLNESS MATCH ===\n\n";

$s = $db->query("SELECT service_name FROM services WHERE id=10")->fetch();
echo "Service name: [" . $s['service_name'] . "]\n";

$v = $db->query("SELECT specialization FROM veterinarians WHERE id=10")->fetch();
echo "Vet specialization: [" . $v['specialization'] . "]\n";

echo "\nMatch: " . ($s['service_name'] === $v['specialization'] ? "✓ YES" : "✗ NO") . "\n";

echo "\n=== ALL GROOMING & WELLNESS VETS ===\n";
$stmt = $db->query("SELECT id, name, specialization FROM veterinarians WHERE specialization LIKE '%Grooming%'");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "ID: " . $row['id'] . " - " . $row['name'] . " - [" . $row['specialization'] . "]\n";
}
