<link rel="stylesheet" href="/css/dashboard.css">

<section class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h1>
    <div>
        <a href="/refuel/add" class="btn-green">Add new refuel record!</a>
        <a href="/vehicles" class="btn-primary">List all vehicles</a>
    </div>
    <div class="card-wrapper">
        <section class="card upcoming">
            <h2>Upcoming</h2>
            <div class="habit">
                <b>Habit Title</b>
                <p>Frequency</p>
                <p>Reward points</p>
            </div>
        </section>

        <section class="card recent">
            <h2>Recent</h2>
            <div class="habit">
                <b>Habit Title</b>
                <p>Frequency</p>
                <p>Reward points</p>
            </div>
        </section>

        <section class="card missed">
            <h2>Missed</h2>
            <div class="habit">
                <b>Habit Title</b>
                <p>Frequency</p>
                <p>Reward points</p>
            </div>
        </section>

        <section class="card history-graph">
            <h2>Graph of History</h2>
        </section>

        <section class="card streak">
            <h2>Streak</h2>
            <p>You're current streak is 123 days</p>
            <p>Good job!</p>
        </section>
    </div>
</section>
