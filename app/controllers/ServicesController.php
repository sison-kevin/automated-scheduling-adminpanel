<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ServicesController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('ServiceModel');
    }

    // 🟢 Display all services
    public function index() {
        $data['services'] = $this->ServiceModel->getAll();
        $this->call->view('./services/index', $data);
    }

    // 🟢 Add new service
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'service_name' => $_POST['service_name'],
                'description'  => $_POST['description'],
                'fee'        => $_POST['fee']
            ];
            $this->ServiceModel->insert($data);
            redirect('services');
        } else {
            $this->call->view('./services/add');
        }
    }

    // 🟢 Edit service
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'service_name' => $_POST['service_name'],
                'description'  => $_POST['description'],
                'fee'        => $_POST['fee']
            ];
            $this->ServiceModel->update($id, $data);
            redirect('services');
        } else {
            $data['service'] = $this->ServiceModel->getById($id);
            $this->call->view('./services/edit', $data);
        }
    }

    // 🟢 Delete service
    public function delete($id) {
        $this->ServiceModel->delete($id);
        redirect('services');
    }
}
