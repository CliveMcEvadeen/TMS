download the following

1. composer
2. php
3. nodejs
4. git
5. visual studio code
6. xampp


directions for php installation

download the php installer from the php website
run the installer
follow the instructions

proceed to the c://php folder

replace the php.ini-development file to php.ini

uncomment the following in the php.ini file

extension=zip
extension=mysqli

start the xampp server
 go to  c://xampp and run the xampp-control.exe file

composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
