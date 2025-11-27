<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VeterinarianModel extends Model {
    protected $table = 'veterinarians';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
        $this->call->database(); // connect to DB
    }

    public function getAll() {
        return $this->db->table($this->table)->get_all();
    }

    public function getActive() {
        return $this->db->table($this->table)
                        ->where('is_active', 1)
                        ->get_all();
    }

    public function getById($id) {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->get();
    }

    public function insertVet($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateVet($id, $data) {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->update($data);
    }

    public function deleteVet($id) {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->delete();
    }

     public function countAll() {
        return $this->db->table('veterinarians')->count();
    }
}
