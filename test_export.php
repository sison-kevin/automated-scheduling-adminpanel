<?php
$db = new PDO('mysql:host=localhost;dbname=vet_system', 'root', '');
$stmt = $db->query("SELECT a.*, u.name as user_name, u.email as user_email, s.service_name, v.name as vet_name 
    FROM appointments a 
    LEFT JOIN users u ON a.user_id = u.id 
    LEFT JOIN services s ON a.service_id = s.id 
    LEFT JOIN veterinarians v ON a.vet_id = v.id 
    WHERE a.appointment_date >= '2025-11-01' AND a.appointment_date <= '2025-11-30'
    ORDER BY a.appointment_date DESC");

echo "Appointments found: " . $stmt->rowCount() . "\n\n";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . $row['id'] . "\n";
    echo "Date: " . $row['appointment_date'] . "\n";
    echo "Time: " . $row['appointment_time'] . "\n";
    echo "Client: " . $row['user_name'] . "\n";
    echo "Email: " . $row['user_email'] . "\n";
    echo "Service: " . $row['service_name'] . "\n";
    echo "Vet: " . $row['vet_name'] . "\n";
    echo "Status: " . $row['status'] . "\n";
    echo "---\n";
}
