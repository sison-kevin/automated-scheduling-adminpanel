<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');

echo "=== UPDATING SERVICES ===\n";

// Update existing services and add new ones
$services = [
    [1, 'Small Animal Care', 'Comprehensive care for dogs, cats, and small pets'],
    [2, 'Large Animal Care', 'Treatment and care for livestock and horses'],
    [4, 'Exotic Animal Care', 'Specialized care for reptiles, birds, and exotic pets'],
    [5, 'General Surgery', 'Surgical procedures and operations'],
    [6, 'Dental Care', 'Dental cleaning, extractions, and oral health'],
    [7, 'Emergency Care', '24/7 emergency veterinary services'],
    [8, 'Vaccination', 'Preventive vaccination programs'],
    [9, 'Laboratory Services', 'Blood tests, urinalysis, and diagnostics'],
    [10, 'Grooming & Wellness', 'Pet grooming and wellness checks']
];

foreach ($services as $service) {
    // Check if service exists
    $stmt = $db->prepare("SELECT id FROM services WHERE id = ?");
    $stmt->execute([$service[0]]);
    
    if ($stmt->fetch()) {
        // Update existing
        $stmt = $db->prepare("UPDATE services SET service_name = ?, description = ? WHERE id = ?");
        $stmt->execute([$service[1], $service[2], $service[0]]);
        echo "✓ Updated: " . $service[1] . "\n";
    } else {
        // Insert new
        $stmt = $db->prepare("INSERT INTO services (id, service_name, description) VALUES (?, ?, ?)");
        $stmt->execute($service);
        echo "✓ Added: " . $service[1] . "\n";
    }
}

echo "\n=== UPDATING VETERINARIANS ===\n";

// Update existing veterinarians and add new ones
$vets = [
    [1, 'Dr. Maria Santos', 'Small Animal Care', '09171234567', 1],
    [2, 'Dr. Juan dela Cruz', 'Large Animal Care', '09181234567', 1],
    [3, 'Dr. Sofia Reyes', 'Exotic Animal Care', '09191234567', 1],
    [5, 'Dr. Carlos Martinez', 'General Surgery', '09201234567', 1],
    [6, 'Dr. Ana Lim', 'Dental Care', '09211234567', 1],
    [7, 'Dr. Miguel Torres', 'Emergency Care', '09221234567', 1],
    [8, 'Dr. Elena Garcia', 'Laboratory Services', '09231234567', 1],
    [9, 'Dr. Roberto Cruz', 'Small Animal Care', '09241234567', 1]
];

foreach ($vets as $vet) {
    // Check if vet exists
    $stmt = $db->prepare("SELECT id FROM veterinarians WHERE id = ?");
    $stmt->execute([$vet[0]]);
    
    if ($stmt->fetch()) {
        // Update existing
        $stmt = $db->prepare("UPDATE veterinarians SET name = ?, specialization = ?, contact = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$vet[1], $vet[2], $vet[3], $vet[4], $vet[0]]);
        echo "✓ Updated: " . $vet[1] . " - Specialization: " . $vet[2] . "\n";
    } else {
        // Insert new
        $stmt = $db->prepare("INSERT INTO veterinarians (id, name, specialization, contact, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute($vet);
        echo "✓ Added: " . $vet[1] . " - Specialization: " . $vet[2] . "\n";
    }
}

echo "\n=== VERIFICATION ===\n";
echo "Total Services: " . $db->query("SELECT COUNT(*) FROM services")->fetchColumn() . "\n";
echo "Total Active Veterinarians: " . $db->query("SELECT COUNT(*) FROM veterinarians WHERE is_active = 1")->fetchColumn() . "\n";
echo "\n✅ Database updated successfully!\n";

