<?php

class VehicleController extends Controller {
    public function index() {
        $vehicle = new Vehicle();
        $vehicles = $vehicle->getVehiclesByUser($_SESSION['user']['id']);
        $this->view('vehicles/index', ['title' => 'Vehicles', 'vehicles' => $vehicles]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $registration_plate = $_POST['registration_plate'] ?? '';
            $fuel_type = $_POST['fuel_type'] ?? '';
            $note = $_POST['note'] ?? '';

            $validator = new Validator();
            $validator->required('name', $name);
            $validator->required('registration_plate', $registration_plate);
            $validator->required('fuel_type', $fuel_type);

            if($note == "") $note = NULL;

            if (!$validator->passes()) {
                $this->view('vehicle/create', [
                    'error' => 'Please correct the errors below.',
                    'validationErrors' => $validator->errors() ?: [],
                ]);
                return;
            }

            $vehicle = new Vehicle();
            $result = $vehicle->create([
                'name' => $name,
                'registration_plate' => strtoupper($registration_plate),
                'fuel_type' => $fuel_type,
                'note' => $note,
                'user_id' => $_SESSION['user']['id'],
            ]);


            if ($result === true) {
                $this->redirect('/vehicles');
            } else {
                $this->view('vehicles/create', ['title' => 'Create vehicle', 'error' => $result, 'validationErrors' => []] );
            }

        } else {
            $this->view('vehicles/create', ['title' => 'Create Vehicle']);
        }
    }


    public function edit() {
        // Edit vehicle (to be implemented later)
    }

    public function delete() {
        // Delete vehicle (to be implemented later)
    }
}
