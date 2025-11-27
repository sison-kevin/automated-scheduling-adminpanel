<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');
$stmt = $db->query('SELECT id, appointment_date, appointment_time, status FROM appointments ORDER BY id DESC LIMIT 10');
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Checking appointment_time field:\n\n";
foreach ($appointments as $appt) {
    echo "ID: " . $appt['id'] . "\n";
    echo "Date: " . $appt['appointment_date'] . "\n";
    echo "Time: " . ($appt['appointment_time'] ?? 'NULL') . "\n";
    echo "Status: " . $appt['status'] . "\n";
    echo "---\n";
}
