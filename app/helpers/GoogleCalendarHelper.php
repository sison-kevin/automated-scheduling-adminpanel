<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

class GoogleCalendarHelper {
    private $client;
    private $service;
    private $calendarId = 'cacaoquennie@gmail.com'; // Your Google Calendar ID

    public function __construct() {
        $this->client = new Google_Client();
        
        // Use service account authentication
        $this->client->setAuthConfig(__DIR__ . '/../../credentials/web.json');
        $this->client->addScope(Google_Service_Calendar::CALENDAR);

        $this->service = new Google_Service_Calendar($this->client);
    }

    public function addAppointment($summary, $description, $startDateTime) {
        try {
            $event = new Google_Service_Calendar_Event([
                'summary' => $summary,
                'description' => $description,
                'start' => [
                    'dateTime' => $startDateTime, 
                    'timeZone' => 'Asia/Manila'
                ],
                'end' => [
                    'dateTime' => date('Y-m-d\TH:i:s', strtotime($startDateTime . ' +1 hour')), 
                    'timeZone' => 'Asia/Manila'
                ],
                'reminders' => [
                    'useDefault' => false,
                    'overrides' => [
                        ['method' => 'email', 'minutes' => 24 * 60],
                        ['method' => 'popup', 'minutes' => 30],
                    ],
                ],
            ]);

            // Add event to the specified calendar
            return $this->service->events->insert($this->calendarId, $event);
        } catch (Exception $e) {
            error_log("Google Calendar API Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getCalendarId() {
        return $this->calendarId;
    }
}
