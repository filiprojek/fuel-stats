<link rel="stylesheet" href="/css/form.css">
<link rel="stylesheet" href="/css/habits_create.css">
<section class="form habit-create">
    <h1 class="header-form"><?= $this->get('title', 'Create Habit') ?></h1>

    <?php if ($this->get('error')): ?>
        <div class="error" style="color: red; margin-bottom: 1rem;">
            <?= htmlspecialchars($this->get('error')) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/habits/create">
        <label for="name">Habit Name</label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

        <label for="frequency">Frequency</label>
        <select name="frequency" id="frequency" onchange="toggleCustomFrequency(this.value)">
            <option value="Daily">Daily</option>
            <option value="Weekly">Weekly</option>
            <option value="Custom">Custom</option>
        </select>

        <div id="custom-frequency" style="display: none;">
            <label id="lbl_dow">Days of the Week</label>
            <div class="dow_chb_wrapper">
                <label for="dow_mon">Monday</label>
                <input type="checkbox" name="days_of_week[]" id="dow_mon" value="1">
            </div>
            <div class="dow_chb_wrapper">
                <label for="dow_tue">Tuesday</label>
                <input type="checkbox" name="days_of_week[]" id="dow_tue" value="2">
            </div>
            <div class="dow_chb_wrapper">
                <label for="dow_wed">Wednesday</label>
                <input type="checkbox" name="days_of_week[]" id="dow_wed" value="3">
            </div>
            <div class="dow_chb_wrapper">
                <label for="dow_thu">Thursday</label>
                <input type="checkbox" name="days_of_week[]" id="dow_thu" value="4">
            </div>
            <div class="dow_chb_wrapper">
                <label for="dow_fri">Friday</label>
                <input type="checkbox" name="days_of_week[]" id="dow_fri" value="5">
            </div>
            <div class="dow_chb_wrapper">
                <label for="dow_sat">Saturday</label>
                <input type="checkbox" name="days_of_week[]" id="dow_sat" value="6">
            </div>
            <div class="dow_chb_wrapper">
                <label for="dow_sun">Sunday</label>
                <input type="checkbox" name="days_of_week[]" id="dow_sun" value="7">
            </div>

            <label for="days_of_month" id="lbl_dom">Days of the Month</label>
            <input type="text" name="days_of_month" id="days_of_month" placeholder="1,15 (comma-separated)">

            <label for="months">Months</label>
            <input type="text" name="months" id="months" placeholder="1,7,12 (comma-separated)">
        </div>

        <input type="submit" value="Create Habit">
    </form>
</section>

<script>
function toggleCustomFrequency(value) {
    const customFrequencyDiv = document.getElementById('custom-frequency');
    customFrequencyDiv.style.display = value === 'Custom' ? 'flex' : 'none';
}
</script>
