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
            <option value="<?= $vehicle['id'] ?>"><?= $vehicle['name'] . " | " . $vehicle['registration_plate'] ?></option>
        <?php endforeach; ?>
        </select>
        <?php if (isset($this->get('validationErrors')['vehicle'])): ?>
            <small class="error"><?= $this->get('validationErrors')['vehicle'] ?></small>
        <?php endif; ?>

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
        <?php if (isset($this->get('validationErrors')['fuel_type'])): ?>
            <small class="error"><?= $this->get('validationErrors')['fuel_type'] ?></small>
        <?php endif; ?>

        <label for="liters">Liters</label>
        <input type="number" name="liters" id="liters" min="0" step=".01" value="<?= htmlspecialchars($_POST['liters'] ?? '0.0') ?>">
        <?php if (isset($this->get('validationErrors')['liters'])): ?>
            <small class="error"><?= $this->get('validationErrors')['liters'] ?></small>
        <?php endif; ?>

        <label for="price_per_liter">Price per liter</label>
        <input type="number" name="price_per_liter" id="price_per_liter" min="0" step=".01" value="<?= htmlspecialchars($_POST['price_per_liter'] ?? '0.0') ?>">
        <?php if (isset($this->get('validationErrors')['price_per_liter'])): ?>
            <small class="error"><?= $this->get('validationErrors')['price_per_liter'] ?></small>
        <?php endif; ?>

        <label for="total_price">Total price</label>
        <input type="number" name="total_price" id="total_price" min="0" step=".01" value="<?= htmlspecialchars($_POST['total_price'] ?? '0.0') ?>">
        <?php if (isset($this->get('validationErrors')['total_price'])): ?>
            <small class="error"><?= $this->get('validationErrors')['total_price'] ?></small>
        <?php endif; ?>

        <label for="mileage">Mileage</label>
        <input type="number" name="mileage" id="mileage" min="0" step="1" value="<?= htmlspecialchars($_POST['mileage'] ?? '0') ?>">
        <?php if (isset($this->get('validationErrors')['mileage'])): ?>
            <small class="error"><?= $this->get('validationErrors')['mileage'] ?></small>
        <?php endif; ?>

        <label for="note">Note</label>
        <input type="text" name="note" id="note" value="<?= htmlspecialchars($_POST['note'] ?? '') ?>">
        <?php if (isset($this->get('validationErrors')['note'])): ?>
            <small class="error"><?= $this->get('validationErrors')['note'] ?></small>
        <?php endif; ?>

        <input type="submit" value="Create fuel record">
    </form>
</section>

<script>
    const inp_lit = document.querySelector("input#liters") 
    const inp_ppl = document.querySelector("input#price_per_liter")
    const inp_tot = document.querySelector("input#total_price")

    const rnd = (num) => Math.round((num + Number.EPSILON) * 100) / 100

    function calculate(){
        let liters = Number(inp_lit.value)
        let price_per_liter = Number(inp_ppl.value)
        let total_price = Number(inp_tot.value)

        if(price_per_liter > 0 && liters > 0) {
            total_price = rnd(liters * price_per_liter)
        }

        if(price_per_liter > 0 && total_price > 0) {
            liters = rnd(total_price / price_per_liter)
        }

        if(liters > 0 && total_price > 0) {
            price_per_liter = rnd(total_price / liters)
        }

        inp_lit.value = liters
        inp_ppl.value = price_per_liter
        inp_tot.value = total_price
    }

    [inp_lit, inp_ppl, inp_tot].forEach(inp => {
        inp.addEventListener("change", () => {
            calculate()
        })
    })

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
</script>
