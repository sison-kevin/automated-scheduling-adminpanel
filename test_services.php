<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');

// Test the exact query used in export
$sql = "SELECT s.*, COUNT(a.id) as total_appointments, 
               SUM(CASE WHEN a.status = 'Completed' THEN 1 ELSE 0 END) as completed_count,
               SUM(CASE WHEN a.status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_count
        FROM services s
        LEFT JOIN appointments a ON s.id = a.service_id
        WHERE a.appointment_date >= '2025-11-01' AND a.appointment_date <= '2025-11-30'
        GROUP BY s.id";

$stmt = $db->query($sql);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Services found with date filter: " . count($services) . "\n\n";

foreach ($services as $service) {
    echo "Service: " . $service['service_name'] . "\n";
    echo "Description: " . $service['description'] . "\n";
    echo "Total Appointments: " . $service['total_appointments'] . "\n";
    echo "Completed: " . $service['completed_count'] . "\n";
    echo "Cancelled: " . $service['cancelled_count'] . "\n";
    echo "---\n";
}

// Test without date filter
echo "\n\n=== WITHOUT DATE FILTER ===\n\n";

$sql2 = "SELECT s.*, COUNT(a.id) as total_appointments, 
               SUM(CASE WHEN a.status = 'Completed' THEN 1 ELSE 0 END) as completed_count,
               SUM(CASE WHEN a.status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_count
        FROM services s
        LEFT JOIN appointments a ON s.id = a.service_id
        GROUP BY s.id";

$stmt2 = $db->query($sql2);
$services2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo "Services found without date filter: " . count($services2) . "\n\n";

foreach ($services2 as $service) {
    echo "Service: " . $service['service_name'] . "\n";
    echo "Total Appointments: " . $service['total_appointments'] . "\n";
    echo "---\n";
}
