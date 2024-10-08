# PHP Survey Builder

php-surveys is a PHP web application that lets you create and collect survey responses. The results can be viewed on charts and exported to PDF. The survey data is stored within a mysql database by default, and can also be stored in a sqlite3 or postgresql database. Edit app/config/Database.php to database of your choice.

<img width="1265" alt="Screenshot 2024-10-06 at 12 41 49 PM" src="https://github.com/user-attachments/assets/5a103eab-7e1c-4f3b-90ae-0b724861dd93">

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

### MacOS: Make the writable/cache directory writable by your web server user
```bash
sudo dscl . -append /Groups/_www GroupMembership username
sudo dscl . -append /Groups/_www GroupMembership daemon
sudo chown -R :_www writable/cache
sudo chmod -R 775 writable/cache
sudo chmod g+s writable/cache
```

Change the 'username' to your username.

### Linux: Make the writable/cache directory writable by your web server user
```bash
sudo chown -R www-data:www-data writable/cache
sudo chmod -R 775 writable/cache
sudo chmod g+s writable/cache
```

Change 'www-data' to your web server user if it's different (e.g., 'apache' on some systems).

Enjoy using the application
