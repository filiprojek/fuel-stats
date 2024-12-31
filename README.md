# Fuel Stats

An app for tracking your fuel consumption and optimizing your driving efficiency.

## Used Technologies
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP (OOP)
- **Database:** MariaDB

## How to Build

### Build Using Docker
Run the container using docker-compose:
```bash
docker-compose --profile <dev|prod> up -d
```

The app should be available at http://localhost:8000.

PhpMyAdmin should be available at http://localhost:8080.

### Build Manually
1. Clone the repository:
```bash
   git clone https://git.filiprojek.cz/fr/fuel-stats.git
```

2. Create `config/environment.php`:
- It should have the following structure:
```php
<?php

define('DB_HOST', 'your db host');
define('DB_USER', 'your db username'); 
define('DB_PASS', 'your db password');
define('DB_NAME', 'your db name'); 
```
- For the database, you can use the included `docker-compose.yaml` which includes both MariaDB and PhpMyAdmin.

3. Start a local web server:
- You can use PHP's integrated server by running this:
```bash
php -S localhost:8000 -t ./public
```
- You can use any host and any port you prefer.

## Usage
1. Register and log in to the app.
2. Add your vehicles with their details (fuel type, registration, etc.).
3. Record each refueling:
   - Select your vehicle.
   - Input the number of liters, price per liter, and total cost.
4. Track your fuel consumption and spending through the dashboard.
5. View detailed stats and graphs to analyze your driving habits.

## License
This project is licensed under GPL3.0 and later. More information is available in the `LICENSE` file.
