<link rel="stylesheet" href="/css/login.css">
<link rel="stylesheet" href="/css/form.css">
<section class="form signin">
    <div class="header-form">
        <img src="/img/logo.jpg" alt="Fuel Stats Logo">
        <h1>Sign in to Fuel Stats</h1>
    </div>

    <?php if ($this->get('error')): ?>
        <div class="error"><?= $this->get('error') ?></div>
    <?php endif; ?>

    <form action="/auth/signin" method="POST">
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

        <input type="submit" value="Sign In">
    </form>

    <div class="bordered">
        <p>New to Fuel Stats?</p>
        <a href="/auth/signup">Create an account</a>
    </div>
</section>
