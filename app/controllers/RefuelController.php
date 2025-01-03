<?php

class RefuelController extends Controller {
    public function create() {
        $vehicle = new Vehicle();
        $vehicles = $vehicle->getVehiclesByUser($_SESSION['user']['id']);
        $this->view('refuel/create', ['title' => "New refuel record", 'vehicles' => $vehicles]);
    }
}
