<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->helper('url');
        $this->call->library('session');
    }

    // Verify reCAPTCHA response with Google
    private function verifyRecaptcha($response)
    {
        $secret = config_item('recaptcha_secret_key');
        if (empty($secret) || empty($response)) {
            return false;
        }

        $remoteip = $_SERVER['REMOTE_ADDR'] ?? '';
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret) . '&response=' . urlencode($response) . '&remoteip=' . urlencode($remoteip);

        $verifyResponse = @file_get_contents($verifyUrl);
        if ($verifyResponse === false) {
            return false;
        }

        $result = json_decode($verifyResponse, true);
        return isset($result['success']) && $result['success'] === true;
    }

    // Show login form
    public function loginForm()
    {
        $this->call->view('login');
    }

    // Handle login submission
    public function loginSubmit()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Verify reCAPTCHA
        $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
        if (!$this->verifyRecaptcha($recaptchaResponse)) {
            echo "<script>alert('reCAPTCHA verification failed. Please try again.');window.location.href='".site_url('login')."';</script>";
            return;
        }

        // Fixed credentials
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = 'admin';
            redirect('appointments');
        } else {
            echo "<script>alert('Invalid credentials');window.location.href='".site_url('login')."';</script>";
        }
    }

    // Logout
    public function logout()
    {
        session_destroy();
        redirect('login');
    }

    public function userLogin()
    {
        $email = $this->io->post('email');
        $password = $this->io->post('password');

        // Verify reCAPTCHA for user login (if present)
        $recaptchaResponse = $this->io->post('g-recaptcha-response') ?? ($_POST['g-recaptcha-response'] ?? '');
        if (!empty($recaptchaResponse) && !$this->verifyRecaptcha($recaptchaResponse)) {
            flash('error', 'reCAPTCHA verification failed.');
            redirect('login');
            return;
        }

        $user = $this->UserModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['name'];
            redirect('user/dashboard');
        } else {
            flash('error', 'Invalid email or password.');
            redirect('login');
        }
    }

    /** ---------------------------
     * USER SIGN UP
     * --------------------------- */
    public function userSignup()
    {
        $name = $this->io->post('name');
        $email = $this->io->post('email');
        $phone = $this->io->post('phone');
        $password = password_hash($this->io->post('password'), PASSWORD_DEFAULT);

        // Check if user already exists
        $existingUser = $this->UserModel->getUserByEmail($email);
        if ($existingUser) {
            flash('error', 'Email already registered.');
            redirect('login');
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password
        ];

        $this->UserModel->registerUser($data);
        flash('success', 'Account created! Please login.');
        redirect('login');
    }
}
