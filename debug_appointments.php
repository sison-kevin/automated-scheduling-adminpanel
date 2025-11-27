<?php
// Debug script to check appointments
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');
$stmt = $db->query('SELECT id, user_id, appointment_date, status FROM appointments ORDER BY id DESC LIMIT 10');
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total appointments found: " . count($appointments) . "\n\n";

foreach ($appointments as $appt) {
    echo "ID: " . $appt['id'] . "\n";
    echo "Date: " . $appt['appointment_date'] . "\n";
    echo "Status: " . $appt['status'] . "\n";
    echo "Formatted: " . date('Y-m-d\TH:i:s', strtotime($appt['appointment_date'])) . "\n";
    echo "---\n";
}

// Check if appointment_date column is DATETIME
$stmt = $db->query('DESCRIBE appointments');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "\nColumn info:\n";
foreach ($columns as $col) {
    if ($col['Field'] == 'appointment_date') {
        echo "appointment_date type: " . $col['Type'] . "\n";
    }
}
