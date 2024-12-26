<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Habit Tracker | <?= $data['title'] ?></title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/vars.css">
  </head>
  <body>
    <header>
      <a href="/auth/signin">Log In</a>
      <a href="/auth/signup">Sign Up</a>
      <a href="/auth/logout">Log Out</a>
    </header>
    <main class="content">
      <?= $content ?>
    </main>
  </body>
</html>
