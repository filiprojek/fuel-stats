<link rel="stylesheet" href="/css/login.css">
<link rel="stylesheet" href="/css/form.css">
<section class="form signup">
    <div class="header-form">
        <img src="/img/logo.jpg" alt="Fuel Stats Logo">
        <h1>Sign up to Fuel Stats</h1>
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

    <div class="bordered">
        <p>Already have an account?</p>
        <a href="/auth/signin">Sign in</a>
    </div>
</section>
