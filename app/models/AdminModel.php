<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AdminModel extends Model {
    protected $table = 'admins'; // change if your table name is different

    public function check_login($username, $password)
    {
        $this->call->database();

        $result = $this->db->table($this->table)
                           ->where('username', $username)
                           ->where('password', $password)
                           ->get();

        // LavaLust returns an array or null — not an object
        if (!empty($result)) {
            return $result; // Found user
        } else {
            return false;   // Invalid login
        }
    }
}
