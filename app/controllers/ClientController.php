<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ClientController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('ClientModel');
    }

    // Handle client sign up
    public function signup()
    {
        $name = $this->io->post('name');
        $email = $this->io->post('email');
        $phone = $this->io->post('phone');
        $password = password_hash($this->io->post('password'), PASSWORD_DEFAULT);

        // Check if already exists
        $existing = $this->ClientModel->getClientByEmail($email);
        if ($existing) {
            flash('error', 'Email already registered.');
            redirect('login');
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password
        ];

        $this->ClientModel->registerClient($data);
        flash('success', 'Account created successfully! Please log in.');
        redirect('login');
    }

    // Handle client login
    public function login()
    {
        $email = $this->io->post('email');
        $password = $this->io->post('password');

        $client = $this->ClientModel->getClientByEmail($email);

        if ($client && password_verify($password, $client['password'])) {
            $_SESSION['client'] = $client['name'];
            redirect('client/dashboard');
        } else {
            flash('error', 'Invalid credentials.');
            redirect('login');
        }
    }
}
