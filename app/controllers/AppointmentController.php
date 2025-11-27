<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AppointmentController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->helper('url');
        $this->call->model('AppointmentModel');
        $this->call->model('ClientModel');
        $this->call->model('VeterinarianModel');
        $this->call->model('ServiceModel');
    }

    // =======================
    // 📅 LIST ALL APPOINTMENTS
    // =======================
    public function index() {
        $data['appointments'] = $this->AppointmentModel->getAll();
        $this->call->view('./admin/appointments', $data);
    }

    // =======================
    // ➕ ADD NEW APPOINTMENT
    // =======================
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // ✅ Combine date and time for validation
            $appointmentDateTime = $_POST['appointment_date'] . ' ' . $_POST['appointment_time'] . ':00';
            $appointmentTime = $_POST['appointment_time'] . ':00';

            // ✅ Gather form input - store date and time separately
            $data = [
                'user_id' => $_POST['user_id'],
                'vet_id' => $_POST['vet_id'],
                'service_id' => $_POST['service_id'],
                'appointment_date' => $_POST['appointment_date'],
                'appointment_time' => $appointmentTime,
                'status' => $_POST['status'] ?? 'Pending'
            ];

            // ✅ Check if time slot is already booked
            if ($this->AppointmentModel->isTimeSlotBooked($_POST['vet_id'], $appointmentDateTime)) {
                // Redirect back with error
                redirect('appointments/add?error=timeslot_booked');
                return;
            }

            // ✅ Insert appointment into database
            $this->AppointmentModel->insert($data);

            // =============================
            // 🗓️ Add to Google Calendar ONLY if status is "Approved"
            // =============================
            if ($data['status'] === 'Approved') {
                try {
                    require_once __DIR__ . '/../helpers/GoogleCalendarHelper.php';
                    $googleCalendar = new GoogleCalendarHelper();

                    // ✅ Safely fetch related names
                    $user = $this->ClientModel->find($_POST['user_id']);
                    $vet = $this->VeterinarianModel->find($_POST['vet_id']);
                    $service = $this->ServiceModel->find($_POST['service_id']);

                    $userName = $user['name'] ?? 'Unknown User';
                    $vetName = $vet['name'] ?? 'Unknown Vet';
                    $serviceName = $service['service_name'] ?? 'Service';

                    // ✅ Format Google Calendar event times
                    $appointmentDateTime = $appointmentDateTime;

                    // ✅ Add the event to Google Calendar
                    $googleCalendar->addAppointment(
                        "✅ $userName - $serviceName",
                        "Client: $userName\nVet: $vetName\nService: $serviceName\nStatus: Approved",
                        $appointmentDateTime
                    );
                } catch (Exception $e) {
                    // Log error but don't stop the flow
                    error_log("Google Calendar Error: " . $e->getMessage());
                }
            }

            // Redirect back to appointment list
            redirect('appointments');
        } else {
            // ✅ Load data for dropdowns
            $data['users'] = $this->ClientModel->getAll();
            $data['vets'] = $this->VeterinarianModel->getActive(); // Only active vets
            $data['services'] = $this->ServiceModel->getAll();

            $this->call->view('./admin/appointment_add', $data);
        }
    }

    // =======================
    // ✏️ EDIT APPOINTMENT
    // =======================
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get old appointment data
            $oldAppointment = $this->AppointmentModel->get($id);
            
            // ✅ Combine date and time for validation
            $appointmentDateTime = $_POST['appointment_date'] . ' ' . $_POST['appointment_time'] . ':00';
            $appointmentTime = $_POST['appointment_time'] . ':00';
            
            $data = [
                'user_id' => $_POST['user_id'],
                'vet_id' => $_POST['vet_id'],
                'service_id' => $_POST['service_id'],
                'appointment_date' => $_POST['appointment_date'],
                'appointment_time' => $appointmentTime,
                'status' => $_POST['status']
            ];
            
            // ✅ Check if time slot is already booked (excluding current appointment)
            if ($this->AppointmentModel->isTimeSlotBookedExcluding($_POST['vet_id'], $appointmentDateTime, $id)) {
                redirect('appointments/edit/' . $id . '?error=timeslot_booked');
                return;
            }
            
            // Update appointment in database
            $this->AppointmentModel->update($id, $data);
            
            // =============================
            // 🗓️ Add to Google Calendar ONLY if status changed to "Approved"
            // =============================
            if ($_POST['status'] === 'Approved' && $oldAppointment['status'] !== 'Approved') {
                try {
                    require_once __DIR__ . '/../helpers/GoogleCalendarHelper.php';
                    $googleCalendar = new GoogleCalendarHelper();

                    // Fetch related names
                    $user = $this->ClientModel->find($_POST['user_id']);
                    $vet = $this->VeterinarianModel->find($_POST['vet_id']);
                    $service = $this->ServiceModel->find($_POST['service_id']);

                    $userName = $user['name'] ?? 'Unknown User';
                    $vetName = $vet['name'] ?? 'Unknown Vet';
                    $serviceName = $service['service_name'] ?? 'Service';

                    // Format Google Calendar event times
                    $appointmentDateTime = $appointmentDateTime;

                    // Add the event to Google Calendar
                    $result = $googleCalendar->addAppointment(
                        "✅ $userName - $serviceName",
                        "Client: $userName\nVet: $vetName\nService: $serviceName\nStatus: Approved",
                        $appointmentDateTime
                    );
                    
                    // Success message
                    error_log("✅ Event added to Google Calendar successfully!");
                } catch (Exception $e) {
                    // Log detailed error
                    error_log("❌ Google Calendar Error: " . $e->getMessage());
                    error_log("Error Details: " . print_r($e, true));
                }
            }
            
            redirect('appointments');
        } else {
            $data['appointment'] = $this->AppointmentModel->get($id);
            $data['users'] = $this->ClientModel->getAll();
            $data['vets'] = $this->VeterinarianModel->getActive(); // Only active vets
            $data['services'] = $this->ServiceModel->getAll();
            $this->call->view('./admin/appointment_edit', $data);
        }
    }

    // =======================
    // 🗑️ DELETE APPOINTMENT
    // =======================
    public function delete($id) {
        $this->AppointmentModel->delete($id);
        redirect('appointments');
    }

    // =======================
    // 📆 JSON DATA FOR CALENDAR VIEW
    // =======================
    public function calendarData() {
        $appointments = $this->AppointmentModel->getAll();
        $events = [];

        foreach ($appointments as $a) {
            $events[] = [
                'title' => $a['service_name'] . ' with ' . $a['user_name'],
                'start' => $a['appointment_date'],
                'status' => $a['status']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($events);
    }

    // =======================
    // 🕐 GET BOOKED TIME SLOTS FOR A DATE & VET
    // =======================
    public function getBookedSlots() {
        $date = $_GET['date'] ?? '';
        $vetId = $_GET['vet_id'] ?? '';
        $excludeId = $_GET['exclude_id'] ?? null;

        if (empty($date) || empty($vetId)) {
            header('Content-Type: application/json');
            echo json_encode(['bookedSlots' => []]);
            return;
        }

        $bookedSlots = $this->AppointmentModel->getBookedTimeSlots($vetId, $date, $excludeId);
        
        header('Content-Type: application/json');
        echo json_encode(['bookedSlots' => $bookedSlots]);
    }
}
