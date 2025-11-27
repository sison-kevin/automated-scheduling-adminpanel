<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AppointmentModel extends Model {
    protected $table = 'appointments';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->call->database();
    }

    public function getAll() {
        return $this->db->table('appointments a')
            ->select('a.id, a.user_id, a.vet_id, a.service_id, a.appointment_date, a.appointment_time, a.status, a.remarks, u.name AS user_name, v.name AS vet_name, s.service_name')
            ->join('users u', 'a.user_id = u.id', 'LEFT ')
            ->join('veterinarians v', 'a.vet_id = v.id', 'LEFT ')
            ->join('services s', 'a.service_id = s.id', 'LEFT ')
            ->order_by('a.appointment_date', 'DESC')
            ->get_all();
    }

    public function get($id) {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->get();
    }

    public function insert($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update($id, $data) {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function delete($id) {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->delete();
    }

    public function countAll() {
        return $this->db->table('appointments')->count();
    }

    public function getMonthlyCounts() {
        return $this->db->table('appointments')
            ->select('MONTH(appointment_date) AS month, COUNT(*) AS total')
            ->group_by('MONTH(appointment_date)')
            ->get_all();
    }

    public function getAppointmentsPerVet() {
        return $this->db->table('appointments a')
            ->select('v.name AS vet_name, COUNT(a.id) AS appointment_count')
            ->join('veterinarians v', 'v.id = a.vet_id', 'LEFT ')
            ->group_by('v.name')
            ->get_all();
    }

    public function createAppointment($data) {
        $this->db->insert('appointments', $data);
        return $this->db->insert_id();
    }

    // =======================
    // 🕐 CHECK IF TIME SLOT IS BOOKED
    // =======================
    public function isTimeSlotBooked($vetId, $appointmentDateTime) {
        // Get the date and time portions
        $date = date('Y-m-d', strtotime($appointmentDateTime));
        $time = date('H:i:s', strtotime($appointmentDateTime));
        
        // Get all appointments for this vet on this date (not cancelled)
        $appointments = $this->db->table($this->table)
            ->where('vet_id', $vetId)
            ->where('appointment_date', $date)
            ->where('status', '!=', 'Cancelled')
            ->get_all();
        
        // Check if any appointment has the same time
        foreach ($appointments as $appointment) {
            $existingTime = isset($appointment['appointment_time']) ? substr($appointment['appointment_time'], 0, 5) : '00:00';
            $checkTime = substr($time, 0, 5);
            
            if ($existingTime == $checkTime) {
                return true;
            }
        }
        
        return false;
    }

    // =======================
    // 📋 GET BOOKED TIME SLOTS FOR A SPECIFIC DATE & VET
    // =======================
    public function getBookedTimeSlots($vetId, $date, $excludeId = null) {
        $query = $this->db->table($this->table)
            ->where('vet_id', $vetId)
            ->where('appointment_date', $date)
            ->where('status', '!=', 'Cancelled');
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $appointments = $query->get_all();

        $bookedSlots = [];
        foreach ($appointments as $appointment) {
            // Extract time in HH:MM format
            $time = isset($appointment['appointment_time']) ? substr($appointment['appointment_time'], 0, 5) : '00:00';
            $bookedSlots[] = $time;
            
            // Don't block the next slot - each appointment is 30 mins
            // so if 8:00 is booked (8:00-8:30), 8:30 is still available
        }

        // Remove duplicates and reindex
        $bookedSlots = array_unique($bookedSlots);
        return array_values($bookedSlots);
    }

    // =======================
    // 🕐 CHECK IF TIME SLOT IS BOOKED (EXCLUDING SPECIFIC ID)
    // =======================
    public function isTimeSlotBookedExcluding($vetId, $appointmentDateTime, $excludeId) {
        // Get the date and time portions
        $date = date('Y-m-d', strtotime($appointmentDateTime));
        $time = date('H:i:s', strtotime($appointmentDateTime));
        
        // Get all appointments for this vet on this date (not cancelled, not the current one)
        $appointments = $this->db->table($this->table)
            ->where('vet_id', $vetId)
            ->where('appointment_date', $date)
            ->where('status', '!=', 'Cancelled')
            ->where('id', '!=', $excludeId)
            ->get_all();
        
        // Check if any appointment has the same time
        foreach ($appointments as $appointment) {
            $existingTime = isset($appointment['appointment_time']) ? substr($appointment['appointment_time'], 0, 5) : '00:00';
            $checkTime = substr($time, 0, 5);
            
            if ($existingTime == $checkTime) {
                return true;
            }
        }
        
        return false;
    }
}
