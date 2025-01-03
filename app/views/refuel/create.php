<link rel="stylesheet" href="/css/form.css">
<link rel="stylesheet" href="/css/vehicle_create.css">
<section class="form">
    <h1 class="header-form"><?= $this->get('title') ?></h1>

    <?php if ($this->get('error')): ?>
        <div class="error" style="color: red; margin-bottom: 1rem;">
            <?= htmlspecialchars($this->get('error')) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/refuel/create">
        <label for="vehicle">Vehicle</label>
        <select name="vehicle" id="vehicle">
        <?php foreach ($this->get('vehicles') as $vehicle): ?>
            <option value="<?= $vehicle['id'] ?>"><?= $vehicle['name'] . " | " . $vehicle['registration_plate'] ?> </option>
        <?php endforeach; ?>
        </select>

        <label for="fuel_type">Fuel type</label>
        <select name="fuel_type" id="fuel_type">
            <option value="Diesel">Diesel</option>
            <option value="Gasoline 95">Gasoline 95</option>
            <option value="Gasoline 98">Gasoline 98</option>
            <option value="Premium Diesel">Premium Diesel</option>
            <option value="Premium Gasoline 95">Premium Gasoline 95</option>
            <option value="Premium Gasoline 98">Premium Gasoline 98</option>
            <option value="Other">Other</option>
        </select>

        <label for="liters">Liters</label>
        <input type="number" name="liters" id="liters" value="<?= htmlspecialchars($_POST['liters'] ?? '') ?>">

        <!-- TODO: name and id -->

        <label for="liters">Price per liter</label>
        <input type="number" name="price_per_liter" id="price_per_liter" value="<?= htmlspecialchars($_POST['liters'] ?? '') ?>">

        <label for="liters">Total price</label>
        <input type="number" name="liters" id="liters" value="<?= htmlspecialchars($_POST['liters'] ?? '') ?>">

        <label for="note">Note</label>
        <input type="text" name="note" id="note" value="<?= htmlspecialchars($_POST['note'] ?? '') ?>">

        <input type="submit" value="Create fuel record">
    </form>
</section>

<script>
    const vehicles = <?= json_encode($data['vehicles']); ?>;
    const fuel_sel = document.querySelector("#fuel_type")
    const vehic_sel = document.querySelector("#vehicle")

    function selectFuel() {
        const veh_id = vehic_sel.value
        vehicles.forEach(el => {
            if(el.id == veh_id) {
                fuel_sel.value = el.fuel_type
                return
            }
        })
    }

    selectFuel()

    vehic_sel.addEventListener("change", () => {
        selectFuel()
    })

    // TODO: function for auto calculation price/price_per_liter/liters
</script>
