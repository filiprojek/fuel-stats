<?php
class DashboardController extends Controller {
    public function index() {
        $habit = new Habit();
        $habits = $habit->getHabitsByUser($_SESSION['user']['id']);

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'habits' => $habits,
        ]);
    }

    public function reroute(){
        $this->redirect('/dashboard');
    }
}
