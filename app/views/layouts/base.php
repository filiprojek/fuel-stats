<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Filip Rojek | http://filiprojek.cz">
    <meta name="email" content="webmaster(@)fofrweb.com">
    <meta name="copyright" content="(c) filiprojek.cz">
    <title>Habit Tracker | <?= $data['title'] ?></title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/vars.css">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
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
