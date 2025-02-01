<link rel="stylesheet" href="/css/dashboard.css">

<link rel="stylesheet" href="/css/form.css">
<link rel="stylesheet" href="/css/vehicle_create.css">

<section class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h1>
    <?php if(!isset($data['default_car'])): ?>
    
    <div id="intro">
        <a href="/vehicles/create">Create your first vehicle</a>
    </div>
    <?php elseif (isset($data['latest_record'])): ?>

    <div id="actions">
        <a href="/refuel/create" class="btn-green">Add new refuel record</a>
        <a href="/vehicles" class="btn-primary">List all vehicles</a>
        <a class="btn-warning" id="btn-offline-add">Add new offline refuel record</a>
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
                <b>Mileage:</b>
                <p><?= $data['latest_record']['mileage'] ?> km</p>
                <?php if (isset($data['latest_record']['note'])): ?>
                <b>Note:</b>
                <p><?= $data['latest_record']['note'] ?></p>
                <?php endif; ?>
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

        <section class="card history-graph">
            <h2>Average fuel consumption</h2>
            <hr>
            <p><?= $data['default_car']['name'] . " | " . $data['default_car']['registration_plate']?></p>
            <b id="avg-fl-cnsmp"></b>
        </section>
    </div>
    <?php else: ?>
    <div id="actions">
        <a href="/refuel/create" class="btn-green">Add new refuel record</a>
        <a href="/vehicles" class="btn-primary">List all vehicles</a>
        <a class="btn-warning" id="btn-offline-add">Add new offline refuel record</a>
    </div>
    <div class="alert-warning">
        <p>Default vehicle <b><i><?= $data['default_car']['name'] ?></i></b> doesn't have any refuel record yet.</p>
        <p>Select another vehicle or create first refuel record.</p>
    </div>
    <?php endif; ?>
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

<script>
    const data2 = <?= json_encode($data['date_price_data']); ?>;
    let cnt_ltr = 0
    let cnt_km = 0
    let first_km = 0

    console.log(data2)

    for(let i = 0; i < data2['liters'].length; i++) {
        if(i == 0) {
            first_km = data2['mileage'][i]
        }
        cnt_ltr += data2['liters'][i]
        cnt_km =+ data2['mileage'][i]
    }

    console.log("Liters", cnt_ltr, cnt_km, first_km)
    console.log("Avg", (cnt_km - first_km) / cnt_ltr)

    document.querySelector("#avg-fl-cnsmp").textContent = Math.floor((cnt_km - first_km) / cnt_ltr) + " l/100km"
</script>


<script defer src="/js/offline-records.js"></script>
