<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');

echo "=== ADDING GROOMING VETERINARIAN ===\n";

// Add a veterinarian specialized in Grooming & Wellness
$stmt = $db->prepare("INSERT INTO veterinarians (name, specialization, contact, is_active) VALUES (?, ?, ?, ?)");
$stmt->execute(['Dr. Patricia Mendoza', 'Grooming & Wellness', '09251234567', 1]);

echo "✓ Added: Dr. Patricia Mendoza - Grooming & Wellness\n";

echo "\n=== ALL VETERINARIANS ===\n";
$stmt = $db->query('SELECT id, name, specialization, is_active FROM veterinarians ORDER BY id');
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $status = $row['is_active'] ? 'Active' : 'Inactive';
    echo "ID: " . $row['id'] . " - " . $row['name'] . " (" . $row['specialization'] . ") - $status\n";
}

echo "\n✅ Database updated successfully!\n";
