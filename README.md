# PHP Survey Builder

php-surveys is a PHP web application that lets you create and collect survey responses. The results can be viewed on charts and exported to PDF. The survey data is stored within a mysql database by default, and can also be stored in a sqlite3 or postgresql database. Edit app/config/Database.php to database of your choice.

## Installation
Require the package using composer.
```bash
composer install
composer update
```

Update the database credentials in app/config/Database.php

Run this bash command to create all the required tables and insert the default data.
```bash
php index.php root system setup
```

## Default login
The default login is 'admin@localhost.com' with a password of '12345678'. You can update login credentials from the Account page.

Load from the users table
```bash
php index.php root selecttable users
php index.php root selecttable users "id = 1"
```

Load from the users table
```bash
php index.php root selecttable surveys
php index.php root selecttable surveys "slug LIKE '%dolor%'""
```

## Troubleshooting
Be sure that your writable/ directory is writable by your web server.

Enjoy using the application