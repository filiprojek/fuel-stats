<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Filip Rojek | http://filiprojek.cz">
    <meta name="email" content="webmaster(@)fofrweb.com">
    <meta name="copyright" content="(c) filiprojek.cz">
    <title>Fuel Stats<?= isset($data['title']) ? " | " . $data['title'] : "" ?></title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/vars.css">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
  </head>
  <body>
    <main class="content">
      <?= $content ?>
    </main>
  </body>
</html>
