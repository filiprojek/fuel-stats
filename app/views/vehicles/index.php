<link rel="stylesheet" href="/css/vehicles.css">
<section class="vehicles">
    <?php if (empty($this->get('vehicles'))): ?>
        <p>No vehicles yet. <a href="/vehicles/create">Add your first vehicle</a>.</p>
    <?php else: ?>
        <div class="vehicle-wrapper">
        <?php foreach ($this->get('vehicles') as $vehicle): ?>
            <div class="vehicle bordered">
                <b><?= htmlspecialchars($vehicle['name']) ?></b>
                <a href="/vehicles/edit?id=<?= $vehicle['id'] ?>">Edit</a> |
                <a href="/vehicles/delete?id=<?= $vehicle['id'] ?>" onclick="return confirm('Are you sure you want to delete this habit?')">Delete</a>
            </div>
        <?php endforeach; ?>
        </div>

        <br>
        <a href="/vehicles/create" class="btn-green">Add new vehicle!</a>
    <?php endif; ?>
</section>
