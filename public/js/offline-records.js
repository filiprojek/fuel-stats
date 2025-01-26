async function checkOnline() {
	if (!navigator.onLine) {
		console.log("Offline (no network connection)");
		return false;
	}

	try {
		const response = await fetch(
			"https://www.google.com/favicon.ico?" + new Date().getTime(),
			{
				mode: "no-cors",
			},
		);
		return true;
	} catch (error) {
		console.log("Connected to network but no internet access");
		return false;
	}
}

setInterval(async () => {
	const isOnline = await checkOnline();
	if (!isOnline) {
		console.log("OFFLINE!!!");
	}
}, 5000);

const offbtn = document.querySelector("#btn-offline-add");
offbtn.addEventListener("click", (e) => {
	e.preventDefault();
	document.querySelector("section.dashboard").style.display = "none";
	const offline = document.createElement("div");
	offline.classList.add("offline");
	offline.innerHTML = `
    <b>You're Offline</b>
    <p>You can create an fuel record locally on your device and sync it later</p>
    <section class="form">
        <h1 class="header-form"><?= $this->get('title') ?></h1>
        <!-- <?php if ($this->get('error')): ?> -->
        <!--     <div class="error" style="color: red; margin-bottom: 1rem;"> -->
        <!--         <?= htmlspecialchars($this->get('error')) ?> -->
        <!--     </div> -->
        <!-- <?php endif; ?> -->
        <form method="POST" action="/refuel/create">
            <label for="vehicle">Vehicle</label>
            <select name="vehicle" id="vehicle">
            <!-- <?php foreach ($this->get('vehicles') as $vehicle): ?> -->
            <!--     <option value="<?= $vehicle['id'] ?>"><?= $vehicle['name'] . " | " . $vehicle['registration_plate'] ?></option> -->
            <!-- <?php endforeach; ?> -->
            </select>
            <!-- <?php if (isset($this->get('validationErrors')['vehicle'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['vehicle'] ?></small> -->
            <!-- <?php endif; ?> -->

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
            <!-- <?php if (isset($this->get('validationErrors')['fuel_type'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['fuel_type'] ?></small> -->
            <!-- <?php endif; ?> -->

            <label for="liters">Liters</label>
            <input type="number" name="liters" id="liters" min="0" step=".01" value="<?= htmlspecialchars($_POST['liters'] ?? '0.0') ?>">
            <!-- <?php if (isset($this->get('validationErrors')['liters'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['liters'] ?></small> -->
            <!-- <?php endif; ?> -->

            <label for="price_per_liter">Price per liter</label>
            <input type="number" name="price_per_liter" id="price_per_liter" min="0" step=".01" value="<?= htmlspecialchars($_POST['price_per_liter'] ?? '0.0') ?>">
            <!-- <?php if (isset($this->get('validationErrors')['price_per_liter'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['price_per_liter'] ?></small> -->
            <!-- <?php endif; ?> -->

            <label for="total_price">Total price</label>
            <input type="number" name="total_price" id="total_price" min="0" step=".01" value="<?= htmlspecialchars($_POST['total_price'] ?? '0.0') ?>">
            <!-- <?php if (isset($this->get('validationErrors')['total_price'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['total_price'] ?></small> -->
            <!-- <?php endif; ?> -->

            <label for="note">Note</label>
            <input type="text" name="note" id="note" value="<?= htmlspecialchars($_POST['note'] ?? '') ?>">
            <!-- <?php if (isset($this->get('validationErrors')['note'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['note'] ?></small> -->
            <!-- <?php endif; ?> -->

            <input type="submit" value="Create fuel record">
        </form>
    </section>
  `;
	document.querySelector("main").appendChild(offline);
});
