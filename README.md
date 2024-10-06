# Codeigniter Survey

php-surveys is a PHP web application that lets you create and collect survey responses. The results can be viewed on charts and exported to PDF. The survey data is stored within a mysql database by default, and can also be stored in a sqlite3 or postgresql database. Edit app/config/Database.php to database of your choice.

## Installation
Require the package using composer.
```bash
composer install
composer update
```

Add this to your Routes
```
$routes->cli("/surveys", "Surveys::setup");
```

Run this bash command to create all the required tables.
```bash
php index.php surveys setup
```

## Troubleshooting
Be sure that your writable/ directory is writable by your web server.

Enjoy using the application