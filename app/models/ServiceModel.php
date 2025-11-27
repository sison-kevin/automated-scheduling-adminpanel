<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ServiceModel extends Model {
    protected $table = 'services';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->call->database(); // ✅ Initialize the database connection
    }

    // 🟢 Get all services
    public function getAll() {
        return $this->db->table($this->table)->get_all();
    }

    // 🟢 Get a single service by ID
    public function getById($id) {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->get();
    }

    // 🟢 Insert new service
    public function insertService($data) {
        return $this->db->table($this->table)->insert($data);
    }

    // 🟢 Update existing service
    public function updateService($id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->update($data);
    }

    // 🟢 Delete service
    public function deleteService($id) {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->delete();
    }

    public function countAll() {
        return $this->db->table('services')->count();
    }

 public function getServiceStats()
{
    return $this->db->table('appointments a')
        ->select('s.service_name AS service_name, COUNT(a.service_id) AS total')
        ->join('services s', 's.id = a.service_id', 'LEFT ') // ✅ Correct
        ->group_by('s.service_name')
        ->get_all();
}



}
