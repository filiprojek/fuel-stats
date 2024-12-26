<section class="signin">
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
</section>
