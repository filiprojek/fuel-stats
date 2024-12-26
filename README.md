# Habit Tracker

An app for tracking habits and motivation to achieve personal goals

## Used technologies
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP (OOP)
- **Database:** MariaDB

## How to build
1. Clone the repo
```bash
   git clone https://git.filiprojek.cz/fr/habit-tracker.git
```

2. Create `config/environment.php`
- It should have following structure:
```php
<?php

define('DB_HOST', 'your db host');
define('DB_USER', 'your db username'); 
define('DB_PASS', 'your db password');
define('DB_NAME', 'your db name'); 
```
- For the database, you can use included `docker-compose.yaml` which have both MariaDB and PhpMyAdmin

3. Start an local web server
- You can use php's integrated server by running this:
```bash
php -S localhost:8000
```
- You can use any host and any port you want.

## Usage
1. Register and Login to the app.
2. Add your habits.
3. Mark your habits when you're done doing them.
4. Earn point and unlock achievements by completing you're habits!

## Licence
This project is licensed under GPL3.0 and later. More information is availabe in `LICENSE` file.

