<?php

class HabitController extends Controller {
    public function index() {
        $habit = new Habit();
        $habits = $habit->getHabitsByUser($_SESSION['user']['id']);
        $this->view('habits/index', ['title' => 'Habits', 'habits' => $habits]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $frequency = $_POST['frequency'] ?? 'Daily';
            $customFrequency = null;

            if (empty($name)) {
                $this->view('habits/create', ['error' => 'Habit name is required.']);
                return;
            }

            if ($frequency === 'Custom') {
                $daysOfWeek = $_POST['days_of_week'] ?? [];
                $daysOfMonth = $_POST['days_of_month'] ?? '*';
                $months = $_POST['months'] ?? '*';

                // Combine into crontab-like string
                $customFrequency = implode(',', $daysOfWeek) . " $daysOfMonth $months";
            }

            $habit = new Habit();
            $result = $habit->create([
                'name' => $name,
                'frequency' => $frequency,
                'custom_frequency' => $customFrequency,
                'reward_points' => intval($_POST['difficulty'] ?? 1),
                'user_id' => $_SESSION['user']['id'],
            ]);

            if ($result) {
                $this->redirect('/habits');
            } else {
                $this->view('habits/create', ['error' => 'Failed to create habit.']);
            }
        } else {
            $this->view('habits/create', ['title' => 'Create Habit']);
        }
    }


    public function edit() {
        // Edit habit (to be implemented later)
    }

    public function delete() {
        // Delete habit (to be implemented later)
    }
}
