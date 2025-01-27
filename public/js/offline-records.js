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

function showDashboard() {
	const offline = document.querySelector(".offline");
	offline.remove();
	document.querySelector(".dashboard").style.display = "flex";
}

const btnOffline = document.querySelector("#btn-offline-add");
const divActions = document.querySelector("#actions");
let visible = true;

setInterval(async () => {
	const isOnline = await checkOnline();
	//const isOnline = false; // REMOVE!!!
	if (!isOnline) {
		if (visible) {
			console.log("OFFLINE!!!");
			Array.from(divActions.children).forEach(
				(el) => (el.style.display = "none"),
			);
			visible = false;

			btnOffline.style.display = "block";

			document.querySelector(".hd-left").addEventListener("click", () => {
				showDashboard();
			});
		}

		if (localStorage.getItem("refuelOfflineData")) {
			btnOffline.textContent = "Sync data";
			btnOffline.setAttribute("disabled", "disabled");
		}
	}

	if (isOnline && !visible) {
		console.log("BACK ONLINE!!!");
		visible = true;
		btnOffline.removeAttribute("disabled", "disabled");
		// TODO: show buttons back, add sync button instead of record creation
		// If user is in a process of adding new offline refuel record, let him finish
		// Clear the local storage on each login
	}
	//}, 5000);
}, 1000);

window.onload = async () => {
	const rawData = await fetch("/api/v1/vehicles/get", {
		method: "GET",
		credentials: "include",
	});
	const data = await rawData.json();
	console.log("Fetched:", data);
	localStorage.setItem("vehicles", JSON.stringify(data));
	console.log(JSON.parse(localStorage.getItem("vehicles")));
};

btnOffline.addEventListener("click", async (e) => {
	e.preventDefault();

	if (btnOffline.textContent == "Sync data") {
		if (!visible) {
			alert("You're still offline. Try again later");
			return;
		}

		try {
			let data = localStorage.getItem("refuelOfflineData");
			if (!data) {
				console.error("No offline data found");
				alert("No offline data found");
				return;
			}

			data = JSON.parse(data);
			const formData = new FormData();

			for (const key in data) {
				if (data.hasOwnProperty(key)) {
					formData.append(key, data[key]);
				}
			}

			const res = await fetch("/refuel/create", {
				method: "POST",
				body: formData,
				credentials: "include",
			});

			if (!res.ok) {
				throw new Error(`Server error: ${res.statusText}`);
			}

			localStorage.removeItem("refuelOfflineData");
			location.reload();
		} catch (err) {
			console.error(err);
			alert("Something went wrong");
			location.reload();
		}
		return;
	}

	document.querySelector("section.dashboard").style.display = "none";

	try {
		vehicles = localStorage.getItem("vehicles");
		if (vehicles === null) throw new Error("No data was saved locally");
		vehicles = JSON.parse(vehicles);
	} catch (err) {
		console.error(err);
		const offline = document.createElement("div");
		offline.classList.add("offline");
		offline.innerHTML = `
            <div class="alert-danger">
                <b>You're Offline</b>
                <p>No data was saved locally, please try again later</p>
            </div>
        `;
		document.querySelector("main").appendChild(offline);
		// TODO: Add button to navigate back to offline dashboard
		return;
	}

	const offline = document.createElement("div");
	offline.classList.add("offline");
	offline.innerHTML = `
    <div class="alert-warning">
        <b>You're Offline</b>
        <p>You can create an fuel record locally on your device and sync it later</p>
    </div>
    <section class="form">
        <h1 class="header-form">Create offline record</h1>
        <!-- <?php if ($this->get('error')): ?> -->
        <!--     <div class="error" style="color: red; margin-bottom: 1rem;"> -->
        <!--         <?= htmlspecialchars($this->get('error')) ?> -->
        <!--     </div> -->
        <!-- <?php endif; ?> -->
        <form id="offline_refuel_add">
            <label for="vehicle">Vehicle</label>
            <select name="vehicle" id="vehicle">
            ${vehicles
							.map(
								(el) =>
									`<option value="${el.id}">${el.name} | ${el.registration_plate}</option>`,
							)
							.join("")}
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
            <input type="number" name="liters" id="liters" min="0" step=".01" value="0.0">
            <!-- <?php if (isset($this->get('validationErrors')['liters'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['liters'] ?></small> -->
            <!-- <?php endif; ?> -->

            <label for="price_per_liter">Price per liter</label>
            <input type="number" name="price_per_liter" id="price_per_liter" min="0" step=".01" value="0.0">
            <!-- <?php if (isset($this->get('validationErrors')['price_per_liter'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['price_per_liter'] ?></small> -->
            <!-- <?php endif; ?> -->

            <label for="total_price">Total price</label>
            <input type="number" name="total_price" id="total_price" min="0" step=".01" value="0.0">
            <!-- <?php if (isset($this->get('validationErrors')['total_price'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['total_price'] ?></small> -->
            <!-- <?php endif; ?> -->

        		<label for="mileage">Mileage</label>
        		<input type="number" name="mileage" id="mileage" min="0" step="1" value="0">
        		<!-- <?php if (isset($this->get('validationErrors')['mileage'])): ?> -->
         		<!--    	<small class="error"><?= $this->get('validationErrors')['mileage'] ?></small> -->
        		<!-- <?php endif; ?> -->

            <label for="note">Note</label>
            <input type="text" name="note" id="note">
            <!-- <?php if (isset($this->get('validationErrors')['note'])): ?> -->
            <!--     <small class="error"><?= $this->get('validationErrors')['note'] ?></small> -->
            <!-- <?php endif; ?> -->

            <input type="submit" id="btn-offline-submit" value="Create fuel record">
        </form>
    </section>
  `;
	document.querySelector("main").appendChild(offline);
	const btnSubmit = document.querySelector("#btn-offline-submit");
	btnSubmit.addEventListener("click", (e) => {
		e.preventDefault();
		const formData = {
			vehicle: document.querySelector("form#offline_refuel_add #vehicle").value,
			fuel_type: document.querySelector("form#offline_refuel_add #fuel_type")
				.value,
			liters: document.querySelector("form#offline_refuel_add #liters").value,
			price_per_liter: document.querySelector(
				"form#offline_refuel_add #price_per_liter",
			).value,
			total_price: document.querySelector(
				"form#offline_refuel_add #total_price",
			).value,
			mileage: document.querySelector("form#offline_refuel_add #mileage").value,
			note: document.querySelector("form#offline_refuel_add #note").value,
		};

		console.log("formData", formData);
		localStorage.setItem("refuelOfflineData", JSON.stringify(formData));
		alert("Data was locally saved. Sync it later!");
		showDashboard();
	});
});
