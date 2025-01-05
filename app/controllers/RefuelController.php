<?php

class RefuelController extends Controller {
    public function create() {
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $vehicle = new Vehicle();
            $vehicles = $vehicle->getVehiclesByUser($_SESSION['user']['id']);
            $this->view('refuel/create', [
                'title' => "New refuel record",
                'vehicles' => $vehicles,
            ]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vehicle_id = $_POST['vehicle'] ?? '';
            $fuel_type = $_POST['fuel_type'] ?? '';
            $liters = $_POST['liters'] ?? '';
            $price_per_liter = $_POST['price_per_liter'] ?? '';
            $total_price = $_POST['total_price'] ?? '';
            $note = $_POST['note'] ?? '';

            $validator = new Validator();
            $validator->required('vehicle', $vehicle_id);
            $validator->required('fuel_type', $fuel_type);
            $validator->required('liters', $liters);
            $validator->required('price_per_liter', $price_per_liter);
            $validator->required('total_price', $total_price);
            $validator->number('liters', $liters);
            $validator->number('price_per_liter', $price_per_liter);
            $validator->number('total_price', $total_price);

            if (round($liters * $price_per_liter, 2) != $total_price) {
                $validator->setErrors(["total_price" => "Price calculation is wrong"]);
            }
 
            if($note == "") $note = NULL;

            if (!$validator->passes()) {
                $vehicle = new Vehicle();
                $vehicles = $vehicle->getVehiclesByUser($_SESSION['user']['id']);
                $this->view('refuel/create', [
                    'error' => 'Please correct the errors below.',
                    'validationErrors' => $validator->errors() ?: [],
                    'vehicles' => $vehicles,
                    'title' => 'New refuel record',
                ]);
                return;
            }

            $record = new Refuel();
            $result = $record->create([
                'user_id' => $_SESSION['user']['id'],
                'vehicle_id' => $vehicle_id,
                'fuel_type' => $fuel_type,
                'note' => $note,
                'liters' => $liters,
                'price_per_liter' => $price_per_liter,
                'total_price' => $total_price,
            ]);

            if ($result === true) {
                $this->redirect('/');
            } else {
                $vehicle = new Vehicle();
                $vehicles = $vehicle->getVehiclesByUser($_SESSION['user']['id']);
                $this->view('refuel/create', [
                    'title' => 'New refuel record',
                    'error' => $result,
                    'validationErrors' => [],
                    'vehicles' => $vehicles,
                ]);
            }
            return;
        }
    }

    public function edit() {
        // Edit refuel record (to be implemented later)
    }

    public function delete() {
        // Delete refuel record (to be implemented later)
    }
}
