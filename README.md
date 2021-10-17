# Web based system

This is the web based system, built in Laravel and blade.

## Installation

Clone the repository locally. Make sure you have a working LAMP/WAMP/MAMP stack. You can use Homestead, Valet or localhost
too. Install composer, nodejs and npm. Make sure you have mysql installed and a database ready to use.

Set update an `.env` file:


## To run

Assuming you've set up the site to be available on localhost or (using Laravel Valet on Mac, for instance):

```bash
npm run watch 
```

Then open http://user-management-system.test/ in a browser.

Else 

```bash
npm run watch  && on next tab  php artisan serve
```

Then open http://localhost:8000/ in a browser.


Next you'll need to run migrations and seeder for creating admin user :

```bash 
    php artisan migrate
    
```

Now you can login with the following credential:
After you ran php artisan db:seed

```bash
    Email: admin@gmail.com
    Password: 123456
```
