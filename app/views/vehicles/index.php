<link rel="stylesheet" href="/css/vehicles.css">
<section class="vehicles">
    <?php if (empty($this->get('vehicles'))): ?>
        <p>No vehicles yet. <a href="/vehicles/create">Add your first vehicle</a>.</p>
    <?php else: ?>
        <div class="btn-wrapper">
            <a href="/vehicles/create" class="btn-green">Add new vehicle</a>
        </div>
        <div class="vehicle-wrapper">
        <?php foreach ($this->get('vehicles') as $vehicle): ?>
            <div class="vehicle bordered">
                <b><?= htmlspecialchars($vehicle['name']) ?></b>
                <p><?= htmlspecialchars($vehicle['registration_plate']) ?></p>
                <p><?= htmlspecialchars($vehicle['fuel_type']) ?></p>
                <p><?= htmlspecialchars($vehicle['note'] ?? "") ?></p>

                <div class="vehicle-actions">
                    <br>
                    <form method="POST" action="/vehicles/delete">
                        <input type="number" name="vehicle_id" value="<?= $vehicle['id'] ?>" style="display: none">
                        <input type="submit" value="Delete vehicle" class="btn-danger">
                    </form>

                    <?php if(!$vehicle['is_default']): ?>
                    <br>
                    <form method="POST" action="/vehicles/default">
                        <input type="number" name="vehicle_id" value="<?= $vehicle['id'] ?>" style="display: none">
                        <input type="submit" value="Set as default" class="btn-primary">
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
