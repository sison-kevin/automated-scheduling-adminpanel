<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('AppointmentModel');
        $this->call->model('ServiceModel');
        $this->call->model('VeterinarianModel');
        $this->call->model('ClientModel');
        $this->call->database();
    }

    public function index()
    {
        $data['page_title'] = 'Reports';
        $this->call->view('./reports/index', $data);
    }

    // Generate Appointment Report
    public function appointments()
    {
        $startDate = $this->io->post('start_date');
        $endDate = $this->io->post('end_date');
        $status = $this->io->post('status');
        $veterinarianId = $this->io->post('veterinarian_id');

        // Build query
        $query = $this->db->table('appointments a')
            ->select('a.*, u.name as user_name, s.service_name, v.name as vet_name')
            ->join('users u', 'a.user_id = u.id', 'LEFT ')
            ->join('services s', 'a.service_id = s.id', 'LEFT ')
            ->join('veterinarians v', 'a.vet_id = v.id', 'LEFT ');

        // Apply filters
        // Temporarily disabled to test
        /*
        if ($startDate && $endDate) {
            $query->where('a.appointment_date', $startDate . ' 00:00:00', '>=')
                  ->where('a.appointment_date', $endDate . ' 23:59:59', '<=');
        } elseif ($startDate) {
            $query->where('a.appointment_date', $startDate . ' 00:00:00', '>=');
        } elseif ($endDate) {
            $query->where('a.appointment_date', $endDate . ' 23:59:59', '<=');
        }

        if ($status && $status !== 'all') {
            $query->where('a.status', $status);
        }

        if ($veterinarianId && $veterinarianId !== 'all') {
            $query->where('a.vet_id', $veterinarianId);
        }
        */

        $appointments = $query->order_by('a.appointment_date', 'DESC')->get_all();

        // Debug - check if query is working
        // echo "SQL: " . $this->db->getSQL . "<br>";
        // echo "Start: $startDate, End: $endDate<br>";
        // echo "Count: " . count($appointments) . "<br>";

        // Get summary statistics
        $data['appointments'] = $appointments;
        $data['total_appointments'] = count($appointments);
        $data['status_counts'] = $this->getStatusCounts($appointments);
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $data['filter_status'] = $status;
        $data['filter_vet'] = $veterinarianId;

        $this->call->view('./reports/appointment_report', $data);
    }

    // Generate Service Report
    public function services()
    {
        $startDate = $this->io->post('start_date');
        $endDate = $this->io->post('end_date');

        // Get service statistics
        $query = $this->db->table('services s')
            ->select('s.*, COUNT(a.id) as total_appointments, 
                     SUM(CASE WHEN a.status = "Completed" THEN 1 ELSE 0 END) as completed_count,
                     SUM(CASE WHEN a.status = "Cancelled" THEN 1 ELSE 0 END) as cancelled_count,
                     SUM(CASE WHEN a.status = "Pending" THEN 1 ELSE 0 END) as pending_count')
            ->join('appointments a', 's.id = a.service_id', 'LEFT ');

        if ($startDate && $endDate) {
            $query->where('a.appointment_date', $startDate . ' 00:00:00', '>=')
                  ->where('a.appointment_date', $endDate . ' 23:59:59', '<=');
        }

        $services = $query->group_by('s.id')->get_all();

        $data['services'] = $services;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        $this->call->view('./reports/service_report', $data);
    }

    // Generate Veterinarian Report
    public function veterinarians()
    {
        $startDate = $this->io->post('start_date');
        $endDate = $this->io->post('end_date');

        // Get veterinarian statistics
        $query = $this->db->table('veterinarians v')
            ->select('v.*, COUNT(a.id) as total_appointments,
                     SUM(CASE WHEN a.status = "Completed" THEN 1 ELSE 0 END) as completed_count,
                     SUM(CASE WHEN a.status = "Cancelled" THEN 1 ELSE 0 END) as cancelled_count,
                     SUM(CASE WHEN a.status = "Pending" THEN 1 ELSE 0 END) as pending_count,
                     SUM(CASE WHEN a.status = "Approved" THEN 1 ELSE 0 END) as approved_count')
            ->join('appointments a', 'v.id = a.vet_id', 'LEFT ');

        if ($startDate && $endDate) {
            $query->where('a.appointment_date', $startDate . ' 00:00:00', '>=')
                  ->where('a.appointment_date', $endDate . ' 23:59:59', '<=');
        }

        $veterinarians = $query->group_by('v.id')->get_all();

        $data['veterinarians'] = $veterinarians;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        $this->call->view('./reports/veterinarian_report', $data);
    }

    // Generate Client Report
    public function clients()
    {
        $startDate = $this->io->post('start_date');
        $endDate = $this->io->post('end_date');

        // Get client statistics
        $query = $this->db->table('users u')
            ->select('u.*, COUNT(a.id) as total_appointments,
                     SUM(CASE WHEN a.status = "Completed" THEN 1 ELSE 0 END) as completed_count,
                     SUM(CASE WHEN a.status = "Cancelled" THEN 1 ELSE 0 END) as cancelled_count,
                     SUM(CASE WHEN a.status = "Pending" THEN 1 ELSE 0 END) as pending_count')
            ->join('appointments a', 'u.id = a.user_id', 'LEFT ');

        if ($startDate && $endDate) {
            $query->where('a.appointment_date', $startDate . ' 00:00:00', '>=')
                  ->where('a.appointment_date', $endDate . ' 23:59:59', '<=');
        }

        $clients = $query->group_by('u.id')
                        ->having('total_appointments', 0, '>')
                        ->order_by('total_appointments', 'DESC')
                        ->get_all();

        $data['clients'] = $clients;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        $this->call->view('./reports/client_report', $data);
    }

    // Export reports to CSV
    public function export()
    {
        $reportType = $this->io->get('type');
        $startDate = $this->io->get('start_date');
        $endDate = $this->io->get('end_date');

        switch ($reportType) {
            case 'appointments':
                $this->exportAppointments($startDate, $endDate);
                break;
            case 'services':
                $this->exportServices($startDate, $endDate);
                break;
            case 'veterinarians':
                $this->exportVeterinarians($startDate, $endDate);
                break;
            case 'clients':
                $this->exportClients($startDate, $endDate);
                break;
            default:
                redirect('reports');
        }
    }

    private function exportAppointments($startDate, $endDate)
    {
        // Use raw query since query builder might not handle DATE comparisons correctly
        $sql = "SELECT a.*, u.name as user_name, u.email as user_email, 
                       s.service_name, v.name as vet_name
                FROM appointments a
                LEFT JOIN users u ON a.user_id = u.id
                LEFT JOIN services s ON a.service_id = s.id
                LEFT JOIN veterinarians v ON a.vet_id = v.id";
        
        if ($startDate && $endDate) {
            $sql .= " WHERE a.appointment_date >= ? AND a.appointment_date <= ?";
        }
        
        $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        
        if ($startDate && $endDate) {
            $stmt = $this->db->raw($sql, [$startDate, $endDate]);
        } else {
            $stmt = $this->db->raw($sql);
        }
        
        // Fetch all results from PDOStatement
        $appointments = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Debug: Log the query and results
        error_log("CSV Export - Start: $startDate, End: $endDate, Found: " . count($appointments) . " appointments");

        // Create CSV
        $filename = 'appointments_report_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8 Excel compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Date', 'Time', 'Client', 'Email', 'Service', 'Veterinarian', 'Status']);

        foreach ($appointments as $appt) {
            // Handle both DATE and DATETIME formats
            $date = date('Y-m-d', strtotime($appt['appointment_date']));
            $time = date('h:i A', strtotime($appt['appointment_time']));
            fputcsv($output, [
                $appt['id'],
                $date,
                $time,
                $appt['user_name'] ?? '',
                $appt['user_email'] ?? '',
                $appt['service_name'] ?? '',
                $appt['vet_name'] ?? '',
                $appt['status'] ?? ''
            ]);
        }

        fclose($output);
        exit;
    }

    private function exportServices($startDate, $endDate)
    {
        $sql = "SELECT s.*, COUNT(a.id) as total_appointments, 
                       SUM(CASE WHEN a.status = 'Completed' THEN 1 ELSE 0 END) as completed_count,
                       SUM(CASE WHEN a.status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_count
                FROM services s
                LEFT JOIN appointments a ON s.id = a.service_id";
        
        if ($startDate && $endDate) {
            $sql .= " AND a.appointment_date >= ? AND a.appointment_date <= ?";
        }
        
        $sql .= " GROUP BY s.id";
        
        if ($startDate && $endDate) {
            $stmt = $this->db->raw($sql, [$startDate, $endDate]);
        } else {
            $stmt = $this->db->raw($sql);
        }
        
        $services = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $filename = 'services_report_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['Service Name', 'Description', 'Total Appointments', 'Completed', 'Cancelled']);

        foreach ($services as $service) {
            fputcsv($output, [
                $service['service_name'] ?? '',
                $service['description'] ?? '',
                $service['total_appointments'] ?? 0,
                $service['completed_count'] ?? 0,
                $service['cancelled_count'] ?? 0
            ]);
        }

        fclose($output);
        exit;
    }

    private function exportVeterinarians($startDate, $endDate)
    {
        $sql = "SELECT v.*, COUNT(a.id) as total_appointments,
                       SUM(CASE WHEN a.status = 'Completed' THEN 1 ELSE 0 END) as completed_count
                FROM veterinarians v
                LEFT JOIN appointments a ON v.id = a.vet_id";
        
        if ($startDate && $endDate) {
            $sql .= " AND a.appointment_date >= ? AND a.appointment_date <= ?";
        }
        
        $sql .= " GROUP BY v.id";
        
        if ($startDate && $endDate) {
            $stmt = $this->db->raw($sql, [$startDate, $endDate]);
        } else {
            $stmt = $this->db->raw($sql);
        }
        
        $veterinarians = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $filename = 'veterinarians_report_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['Veterinarian', 'Specialization', 'Contact', 'Status', 'Total Appointments', 'Completed']);

        foreach ($veterinarians as $vet) {
            fputcsv($output, [
                $vet['name'] ?? '',
                $vet['specialization'] ?? '',
                $vet['contact'] ?? 'N/A',
                ($vet['is_active'] ?? 0) == 1 ? 'Active' : 'Inactive',
                $vet['total_appointments'] ?? 0,
                $vet['completed_count'] ?? 0
            ]);
        }

        fclose($output);
        exit;
    }

    private function exportClients($startDate, $endDate)
    {
        $sql = "SELECT u.*, COUNT(a.id) as total_appointments,
                       SUM(CASE WHEN a.status = 'Completed' THEN 1 ELSE 0 END) as completed_count
                FROM users u
                LEFT JOIN appointments a ON u.id = a.user_id";
        
        if ($startDate && $endDate) {
            $sql .= " AND a.appointment_date >= ? AND a.appointment_date <= ?";
        }
        
        $sql .= " GROUP BY u.id HAVING total_appointments > 0";
        
        if ($startDate && $endDate) {
            $stmt = $this->db->raw($sql, [$startDate, $endDate]);
        } else {
            $stmt = $this->db->raw($sql);
        }
        
        $clients = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $filename = 'clients_report_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['Client Name', 'Email', 'Phone', 'Total Appointments', 'Completed']);

        foreach ($clients as $client) {
            fputcsv($output, [
                $client['name'] ?? '',
                $client['email'] ?? '',
                $client['phone'] ?? 'N/A',
                $client['total_appointments'] ?? 0,
                $client['completed_count'] ?? 0
            ]);
        }

        fclose($output);
        exit;
    }

    private function getStatusCounts($appointments)
    {
        $counts = [
            'Pending' => 0,
            'Approved' => 0,
            'Completed' => 0,
            'Cancelled' => 0
        ];

        foreach ($appointments as $appt) {
            if (isset($counts[$appt['status']])) {
                $counts[$appt['status']]++;
            }
        }

        return $counts;
    }
}
