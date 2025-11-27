<?php
class ClientModel extends Model {
    protected $table = 'users';
    protected $primary_key = 'id';



     public function getAll() 
    {
        return $this->db->table($this->table)
                        ->order_by('name', 'ASC')
                        ->get_all();
    }

    /** 
     * Register a new client
     * $data should contain: name, email, phone, password
     */
    public function registerClient($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    /**
     * Get client by email (for login or validation)
     */
    public function getClientByEmail($email)
    {
        return $this->db->table($this->table)
                        ->where('email', $email)
                        ->get()
                        ->getRowArray();
    }

    /**
     * Get client by phone number (optional, if your login allows phone)
     */
    public function getClientByPhone($phone)
    {
        return $this->db->table($this->table)
                        ->where('phone', $phone)
                        ->get()
                        ->getRowArray();
    }
}
