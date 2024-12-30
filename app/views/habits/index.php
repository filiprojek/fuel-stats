<link rel="stylesheet" href="/css/habits_dashboard.css">
<section class="habits">
    <?php if (empty($this->get('habits'))): ?>
        <p>No habits yet. <a href="/habits/create">Create your first habit</a>.</p>
    <?php else: ?>
        <div class="habits-wrapper">
        <?php foreach ($this->get('habits') as $habit): ?>
            <div class="habit bordered">
                <b><?= htmlspecialchars($habit['title']) ?></b>
                <p>Frequency: <?= htmlspecialchars($habit['frequency']) ?></p>
                <?php if (isset($habit['custom_frequency'])): ?>
                    <p><?= htmlspecialchars($habit['custom_frequency'] ?? 'N/A') ?></p>
                <?php endif; ?>
                    <p><?= htmlspecialchars($habit['reward_points']) ?></p>
                    <p><?= htmlspecialchars($habit['created_at']) ?></p>
                    <a href="/habits/done">Mark as done</a> |
                    <a href="/habits/edit?id=<?= $habit['id'] ?>">Edit</a> |
                    <a href="/habits/delete?id=<?= $habit['id'] ?>" onclick="return confirm('Are you sure you want to delete this habit?')">Delete</a>
            </div>
        <?php endforeach; ?>
        </div>
        <a href="/habits/create" class="btn-green">Create new habit!</a>
    <?php endif; ?>
</section>
