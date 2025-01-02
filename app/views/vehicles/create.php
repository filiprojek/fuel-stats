<link rel="stylesheet" href="/css/form.css">
<link rel="stylesheet" href="/css/vehicle_create.css">
<section class="form">
    <h1 class="header-form"><?= $this->get('title', 'Create Vehicle') ?></h1>

    <?php if ($this->get('error')): ?>
        <div class="error" style="color: red; margin-bottom: 1rem;">
            <?= htmlspecialchars($this->get('error')) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/vehicles/create">
        <label for="name">Vehicle name</label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

        <label for="registration_plate">Registration plate</label>
        <input type="text" name="registration_plate" id="registration_plate" maxlength="10" onkeypress="return event.charCode != 32" required value="<?= htmlspecialchars($_POST['registration_plate'] ?? '') ?>">

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

        <label for="note">Note</label>
        <input type="text" name="note" id="note" value="<?= htmlspecialchars($_POST['note'] ?? '') ?>">

        <input type="submit" value="Create vehicle">
    </form>
</section>
