<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('AppointmentModel');
        $this->call->database(); // ✅ Initialize DB
    }

 public function index()
{
    $data['totalAppointments'] = $this->db->table('appointments')->count();
    $data['totalServices'] = $this->db->table('services')->count();
    $data['totalVets'] = $this->db->table('veterinarians')->count();

    // 📅 Monthly appointment statistics
    $monthly = $this->AppointmentModel->getMonthlyCounts();
    $data['monthlyLabels'] = json_encode(array_map(fn($m) => date("F", mktime(0, 0, 0, $m['month'], 1)), $monthly));
    $data['monthlyValues'] = json_encode(array_column($monthly, 'total'));

    // 💆 Service Popularity
    $services = $this->db->table('services s')
        ->select('s.service_name AS name, COUNT(a.id) AS total')
        ->join('appointments a', 's.id = a.service_id', 'LEFT ')
        ->group_by('s.id')
        ->get_all();
    $data['serviceLabels'] = json_encode(array_column($services, 'name'));
    $data['serviceValues'] = json_encode(array_column($services, 'total'));

    // 👨‍⚕️ Appointments per veterinarian
    $vets = $this->AppointmentModel->getAppointmentsPerVet();
    $data['vetLabels'] = json_encode(array_column($vets, 'vet_name'));
    $data['vetValues'] = json_encode(array_column($vets, 'appointment_count'));

    // 🗓️ Pending and Approved appointments only for calendar
    $appointments = $this->AppointmentModel->getAll();
    $events = [];
    
    foreach ($appointments as $appt) {
        // Only show Pending and Approved appointments in calendar
        if ($appt['status'] !== 'Pending' && $appt['status'] !== 'Approved') {
            continue;
        }
        
        // Get the date portion from appointment_date
        $dateOnly = date('Y-m-d', strtotime($appt['appointment_date']));
        
        // Check if time is in appointment_time field or in appointment_date field
        if (!empty($appt['appointment_time']) && $appt['appointment_time'] !== null) {
            // Use appointment_time field
            $time = $appt['appointment_time'];
        } else {
            // Extract time from appointment_date if it exists
            $dateTime = strtotime($appt['appointment_date']);
            $timeFromDate = date('H:i:s', $dateTime);
            
            // If the time is 00:00:00, set a default time of 09:00:00
            if ($timeFromDate === '00:00:00') {
                $time = '09:00:00';
            } else {
                $time = $timeFromDate;
            }
        }
        
        // Combine date and time
        $appointmentDateTime = $dateOnly . ' ' . $time;
        $appointmentDate = date('Y-m-d\TH:i:s', strtotime($appointmentDateTime));
        
        // Color based on status
        switch($appt['status']) {
            case 'Approved':
                $bgColor = '#198754';
                $borderColor = '#157347';
                break;
            case 'Pending':
                $bgColor = '#ffc107';
                $borderColor = '#ffb300';
                break;
            case 'Completed':
                $bgColor = '#0d6efd';
                $borderColor = '#0a58ca';
                break;
            case 'Cancelled':
                $bgColor = '#dc3545';
                $borderColor = '#bb2d3b';
                break;
            default:
                $bgColor = '#6c757d';
                $borderColor = '#5c636a';
        }
        
        $events[] = [
            'title' => $appt['user_name'] . ' - ' . $appt['service_name'],
            'start' => $appointmentDate,
            'description' => 'Veterinarian: ' . $appt['vet_name'],
            'backgroundColor' => $bgColor,
            'borderColor' => $borderColor,
            'textColor' => '#fff',
            'extendedProps' => [
                'status' => $appt['status'],
                'vet_name' => $appt['vet_name'],
                'service_name' => $appt['service_name']
            ]
        ];
    }
    
    $data['calendarEvents'] = json_encode($events);

    $this->call->view('dashboard', $data);
}

}
