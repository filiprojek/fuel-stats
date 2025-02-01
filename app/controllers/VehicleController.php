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
                $this->view('vehicles/create', [
                    'error' => 'Please correct the errors below.',
                    'validationErrors' => $validator->errors() ?: [],
                ]);
                return;
            }

            $vehicle = new Vehicle();
            $default_vehicle = $vehicle->getDefaultVehicle($_SESSION['user']['id']);
            $is_default = $default_vehicle ? 0 : 1;

            $result = $vehicle->create([
                'name' => $name,
                'registration_plate' => strtoupper($registration_plate),
                'fuel_type' => $fuel_type,
                'note' => $note,
                'user_id' => $_SESSION['user']['id'],
                'is_default' => $is_default
            ]);


            if ($result === true) {
                $this->redirect('/');
            } else {
                $this->view('vehicles/create', ['title' => 'Create vehicle', 'error' => $result, 'validationErrors' => []] );
            }

        } else {
            $this->view('vehicles/create', ['title' => 'Create Vehicle']);
        }
    }


    public function edit() {
        // TODO: Edit vehicle (to be implemented later)
    }

    public function delete() {
        if(!$_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "Wrong method";
            return;
        }

        // TODO: Validate the request
        $vehicle_id = $_POST['vehicle_id'];

        $vehicle = new Vehicle();
        $result = $vehicle->delete($vehicle_id, $_SESSION['user']['id']);

        if($result != true) {
            echo "Something went wrong";
            return;
        }

        header("Location: /vehicles");
    }

    public function setDefault() {
        $vehicle = new Vehicle();
        // TODO: Validate the request
        $result = $vehicle->setDefaultVehicle($_POST['vehicle_id'], $_SESSION['user']['id']);
        if($result != true) {
            echo "Something went wrong";
            return;
        }

        header("Location: /");
    }

    public function api_get() {
        if(!$_SERVER['REQUEST_METHOD'] === 'GET') {
            echo "Wrong method, use GET";
            return;
        }

        $vehicle = new Vehicle();
        $result = $vehicle->getVehiclesByUser($_SESSION['user']['id']);
        echo json_encode($result);
    }
}
