# Laravel Twitter Reach Calculator

### Setup

Installs all the needed packages
```$xslt
composer install
```

Copy the environment variables
```$xslt
cp .env.example .env
```
Make sure to add your Twitter API credentials to the .env!

Generate an app key
```$xslt
php artisan key:generate
```

Check to see if the tests are A OK!
```$xslt
phpunit
```

And run
```$xslt
php artisan serve
```

### If you have problems running the tests

Make sure to run these every time after you run: 
```
php artisan optimize
```

Clears the caches
```$xslt
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

and try again!!!
```$xslt
phpunit
```

#### Notes
The calculation is limited to 100 retweeter results due to API restrictions
