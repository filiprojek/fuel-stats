<link rel="stylesheet" href="/css/habits_dashboard.css">
<section class="habits">
    <?php if (empty($this->get('habits'))): ?>
        <p>No habits yet. <a href="/habits/create">Create your first habit</a>.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Frequency</th>
                    <th>Custom Schedule</th>
                    <th>Points</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->get('habits') as $habit): ?>
                    <tr>
                        <td><?= htmlspecialchars($habit['title']) ?></td>
                        <td><?= htmlspecialchars($habit['frequency']) ?></td>
                        <td><?= htmlspecialchars($habit['custom_frequency'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($habit['reward_points']) ?></td>
                        <td><?= htmlspecialchars($habit['created_at']) ?></td>
                        <td>
                            <a href="/habits/edit?id=<?= $habit['id'] ?>">Edit</a> |
                            <a href="/habits/delete?id=<?= $habit['id'] ?>" onclick="return confirm('Are you sure you want to delete this habit?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/habits/create">Create new habit!</a>
    <?php endif; ?>
</section>
