<section class="habit-create">
    <h1><?= $this->get('title', 'Create Habit') ?></h1>

    <?php if ($this->get('error')): ?>
        <div class="error" style="color: red; margin-bottom: 1rem;">
            <?= htmlspecialchars($this->get('error')) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/habits/create">
        <label for="name">Habit Name:</label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

        <label for="frequency">Frequency:</label>
        <select name="frequency" id="frequency" onchange="toggleCustomFrequency(this.value)">
            <option value="Daily">Daily</option>
            <option value="Weekly">Weekly</option>
            <option value="Custom">Custom</option>
        </select>

        <div id="custom-frequency" style="display: none;">
            <label>Days of the Week:</label>
            <input type="checkbox" name="days_of_week[]" value="1"> Monday
            <input type="checkbox" name="days_of_week[]" value="2"> Tuesday
            <input type="checkbox" name="days_of_week[]" value="3"> Wednesday
            <input type="checkbox" name="days_of_week[]" value="4"> Thursday
            <input type="checkbox" name="days_of_week[]" value="5"> Friday
            <input type="checkbox" name="days_of_week[]" value="6"> Saturday
            <input type="checkbox" name="days_of_week[]" value="7"> Sunday

            <label for="days_of_month">Days of the Month:</label>
            <input type="text" name="days_of_month" id="days_of_month" placeholder="1,15 (comma-separated)">

            <label for="months">Months:</label>
            <input type="text" name="months" id="months" placeholder="1,7,12 (comma-separated)">
        </div>

        <button type="submit">Create Habit</button>
    </form>
</section>

<script>
function toggleCustomFrequency(value) {
    const customFrequencyDiv = document.getElementById('custom-frequency');
    customFrequencyDiv.style.display = value === 'Custom' ? 'block' : 'none';
}
</script>
