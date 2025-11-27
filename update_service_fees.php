<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');

echo "=== UPDATING SERVICE FEES ===\n";

// Update fees for all services
$serviceFees = [
    1 => 500.00,   // Small Animal Care
    2 => 800.00,   // Large Animal Care
    4 => 650.00,   // Exotic Animal Care
    5 => 2500.00,  // General Surgery
    6 => 450.00,   // Dental Care
    7 => 1500.00,  // Emergency Care
    8 => 350.00,   // Vaccination
    9 => 600.00,   // Laboratory Services
    10 => 300.00   // Grooming & Wellness
];

foreach ($serviceFees as $id => $fee) {
    $stmt = $db->prepare("UPDATE services SET fee = ? WHERE id = ?");
    $stmt->execute([$fee, $id]);
    
    // Get service name
    $stmt = $db->prepare("SELECT service_name FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $name = $stmt->fetchColumn();
    
    echo "✓ Updated: $name - ₱" . number_format($fee, 2) . "\n";
}

echo "\n=== VERIFICATION ===\n";
$stmt = $db->query('SELECT id, service_name, fee FROM services ORDER BY id');
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo $row['id'] . ". " . $row['service_name'] . " - ₱" . number_format($row['fee'], 2) . "\n";
}

echo "\n✅ All service fees updated successfully!\n";
