## Soccer League Simulation

Soccer league simulater app developed using stacks: Laravel, Twitter Bootstrap, VueJS.

To run app locally:

1. ```Clone repo```
2. ```Navigate to project folder```
3. ```composer install```
4. ```cp .env.example .env```
5. Update database credentials in .env file
6. ```php artisan key:generate```
7. ```php artisan migrate:fresh --seed```
8. ```php artisan serve```
9. Open browser and navigate to ```https://localhost:8000/```

To run app inside docker:
1. ```Navigate to project folder```
2. ```./vendor/bin/sail up -d```
3. ```./vendor/bin/sail migrate:fresh --seed```
4. Open browser and navigate to ```https://0.0.0.0/```
5. If container does not start because of port issues, add APP_PORT to variable with free port value in your machine to .env file

To stop docker container run command:

```./vendor/bin/sail down```

To run tests:

```php artisan test```


To add more teams open teams.txt file which located at the base folder of project and write down new teams (Note: teams must me separated by new line).  
