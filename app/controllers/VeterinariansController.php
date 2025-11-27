<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class VeterinariansController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('VeterinarianModel');
    }

    // 🟢 Show all veterinarians
    public function index() {
        $data['vets'] = $this->VeterinarianModel->getAll();
        $this->call->view('./veterinarians/index', $data);
    }

    // 🟢 Add veterinarian
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'           => $_POST['name'],
                'specialization' => $_POST['specialization'],
                'contact'        => $_POST['contact'],
                'is_active'      => $_POST['is_active'] ?? 1
            ];
            $this->VeterinarianModel->insertVet($data);
            redirect('veterinarians');
        } else {
            $this->call->view('./veterinarians/add');
        }
    }

    // 🟢 Edit veterinarian
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'           => $_POST['name'],
                'specialization' => $_POST['specialization'],
                'contact'        => $_POST['contact'],
                'is_active'      => $_POST['is_active'] ?? 1
            ];
            $this->VeterinarianModel->updateVet($id, $data);
            redirect('veterinarians');
        } else {
            $data['vet'] = $this->VeterinarianModel->getById($id);
            $this->call->view('./veterinarians/edit', $data);
        }
    }

    // 🟢 Delete veterinarian
    public function delete($id) {
        $this->VeterinarianModel->deleteVet($id);
        redirect('veterinarians');
    }

    // 🔄 Toggle veterinarian active status
    public function toggleStatus($id) {
        $vet = $this->VeterinarianModel->getById($id);
        if ($vet) {
            $newStatus = $vet['is_active'] == 1 ? 0 : 1;
            $this->VeterinarianModel->updateVet($id, ['is_active' => $newStatus]);
        }
        redirect('veterinarians');
    }
}
