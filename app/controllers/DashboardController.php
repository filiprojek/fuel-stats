<?php
class DashboardController extends Controller {
    public function index() {
        $vehicle = new Vehicle();
        $vehicles = $vehicle->getVehiclesByUser($_SESSION['user']['id']);
        $default_car = $vehicle->getDefaultVehicle($_SESSION['user']['id']) ?? null;

        $refuel = new Refuel();
        $data = [
            "date" => [],
            "price" => [],
            "mileage" => [],
            "liters" => []
        ];
        $raw_data = $default_car ? $refuel->latest_data($default_car['id'], 5) : [];
        foreach($raw_data as $one) {
            array_push($data['date'], date('d. m.', strtotime($one['created_at'])));
            array_push($data['price'], $one['price_per_liter']);
            array_push($data['mileage'], $one['mileage']);
            array_push($data['liters'], $one['liters']);
        }

        $latest_data = $default_car ? $refuel->latest_one($default_car['id']) : [];
        $latest_record = !empty($latest_data) ? $latest_data[0] : null;

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'vehicles' => $vehicles,
            'date_price_data' => $data,
            'default_car' => $default_car,
            'latest_record' => $latest_record,
        ]);
    }

    public function reroute(){
        $this->redirect('/dashboard');
    }
}
