<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model
{
    protected $table = 'users';

    public function insertUser($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function getUserByPhone($phone)
    {
        return $this->db->table($this->table)
            ->where('phone', $phone)
            ->get();
    }

    public function getUserByUsername($username)
    {
        return $this->db->table($this->table)
            ->where('username', $username)
            ->get();
    }

    public function updateQrCode($userId, $qrPath)
{
    return $this->db->table($this->table)
        ->where('id', $userId)
        ->update(['qr_code' => $qrPath]);
}

 public function registerUser($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function getUserByEmail($email)
    {
        return $this->db->table($this->table)
                        ->where('email', $email)
                        ->get()
                        ->getRowArray();
    }
}
