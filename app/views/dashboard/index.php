<link rel="stylesheet" href="/css/dashboard.css">

<section class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h1>
    <div>
        <a href="/refuel/create" class="btn-green">Add new refuel record!</a>
        <a href="/vehicles" class="btn-primary">List all vehicles</a>
    </div>
    <div class="card-wrapper">
        <section class="card latest">
            <h2>Latest fuel record</h2>
            <hr>
            <div>
                <b>Car:</b>
                <p><?= $data['latest_record']['vehicle_name'] ?></p>
                <b>Liters:</b>
                <p><?= $data['latest_record']['liters'] ?> liters</p>
                <b>Price per liter:</b>
                <p><?= $data['latest_record']['price_per_liter'] ?>,-/liter</p>
                <b>Total price:</b>
                <p><?= $data['latest_record']['total_price'] ?>,-</p>
            </div>
        </section>

        <section class="card">
            <h2>Default car</h2>
            <hr>
            <b>Car</b>
            <p><?= $data['default_car']['name'] ?></p>
            <b>Registration plate</b>
            <p><?= $data['default_car']['registration_plate'] ?></p>
            <b>Fuel type</b>
            <p><?= $data['default_car']['fuel_type'] ?></p>
            <b>Note</b>
            <p><?= $data['default_car']['note'] ?></p>
        </section>

        <section class="card history-graph">
            <h2>Chart of Gas price</h2>
            <hr>
            <p><?= $data['default_car']['name'] . " | " . $data['default_car']['registration_plate']?></p>
            <canvas id="chart-gas-price"></canvas>
        </section>
    </div>
</section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('chart-gas-price');
    const data = <?= json_encode($data['date_price_data']); ?>;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [...data['date']],
            datasets: [{
                label: 'Gas price history',
                data: data['price'],
                borderWidth: 1,
            }]
        },
    });
</script>
