<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Habit Tracker | <?= $data['title'] ?></title>
  </head>
  <body>
    <header>
      <a href="/auth/signin">Log In</a>
      <a href="/auth/signup">Sign Up</a>
    </header>
    <section class="content">
      <?= $content ?>
    </section>
  </body>
</html>
