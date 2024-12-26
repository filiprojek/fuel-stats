<link rel="stylesheet" href="/css/login.css">
<section class="signin">
    <div class="header-form">
        <img src="/img/logo.jpg" alt="Habit Tracker Logo">
        <h1>Sign up to Habit Tracker</h1>
    </div>

    <?php if ($this->get('error')): ?>
        <div class="error"><?= $this->get('error') ?></div>
    <?php endif; ?>

    <form action="/auth/signup" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
        <?php if (isset($this->get('validationErrors')['username'])): ?>
            <small class="error"><?= $this->get('validationErrors')['username'] ?></small>
        <?php endif; ?>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        <?php if (isset($this->get('validationErrors')['email'])): ?>
            <small class="error"><?= $this->get('validationErrors')['email'] ?></small>
        <?php endif; ?>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <?php if (isset($this->get('validationErrors')['password'])): ?>
            <small class="error"><?= $this->get('validationErrors')['password'] ?></small>
        <?php endif; ?>

        <label for="password-2">Password again</label>
        <input type="password" name="password-2" id="password-2" required>
        <?php if (isset($this->get('validationErrors')['password_confirmation'])): ?>
            <small class="error"><?= $this->get('validationErrors')['password_confirmation'] ?></small>
        <?php endif; ?>

        <input type="submit" value="Sign Up">
    </form>
</section>
