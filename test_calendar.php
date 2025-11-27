<?php
require_once __DIR__ . '/../vendor/autoload.php';

echo "Testing Google Calendar Integration...\n\n";

try {
    $client = new Google_Client();
    $client->setAuthConfig(__DIR__ . '/credentials/web.json');
    $client->addScope(Google_Service_Calendar::CALENDAR);

    $service = new Google_Service_Calendar($client);
    $calendarId = 'cacaoquennie@gmail.com';

    echo "✅ Client authenticated successfully!\n\n";

    // Create a test event
    $event = new Google_Service_Calendar_Event([
        'summary' => 'Test Appointment - ' . date('Y-m-d H:i:s'),
        'description' => 'This is a test event from the veterinary system',
        'start' => [
            'dateTime' => '2025-11-10T14:00:00',
            'timeZone' => 'Asia/Manila',
        ],
        'end' => [
            'dateTime' => '2025-11-10T15:00:00',
            'timeZone' => 'Asia/Manila',
        ],
    ]);

    echo "Attempting to insert event into calendar: $calendarId\n\n";
    
    $result = $service->events->insert($calendarId, $event);
    
    echo "✅ SUCCESS! Event created:\n";
    echo "Event ID: " . $result->getId() . "\n";
    echo "Event Link: " . $result->getHtmlLink() . "\n";
    echo "\nCheck your Google Calendar now!\n";

} catch (Exception $e) {
    echo "❌ ERROR:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
    echo "\nFull error:\n";
    print_r($e);
}
