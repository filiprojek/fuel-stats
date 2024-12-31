<?php
class DashboardController extends Controller {
    public function index() {
        $vehicle = new Vehicle();
        $vehicles = $vehicle->getVehiclesByUser($_SESSION['user']['id']);

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'vehicles' => $vehicles,
        ]);
    }

    public function reroute(){
        $this->redirect('/dashboard');
    }
}
