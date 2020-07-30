Simple MiniCRM example using Laravel 7 + InfyOm Scaffolding

<h1>Installation</h1>

<ul>
<li>Check out code base</li>
Run "composer install" from root of project
Copy .env.example to .env (note, default environment assumes mysql running on localhost with a scema name of minicrm and username + password of "root" - you may use sqlite instead if required, see .env.dusk for an example)
Run "php artisan migrate:fresh --seed" from root fo project to create the default admin user to be able to log in
Run "php artisan serve" from root of project to start the simple php servlet
Visit "127.0.0.1:8000" to use it.

For some demo data, you may use the test seeder to populate the system
Run "php artisan db:seed --class=TestDataSeeder" to add 50 companeis and 200 employees. Note the first set of data in each model set is programatically named and is is used during the autoated dusk test runs.

Testing - 
Run "php artisan serve --env=dusk --port=8123" from root to start the simple php servlet on port 8123 (note, this port is defined in the .env.dusk and is different from the standard .env setup).
Run "php artisan dusk" to cycle through the browser tests
