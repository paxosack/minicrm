<h1>Simple MiniCRM example using Laravel 7 + InfyOm Scaffolding</h1>
<br>
<h2>Installation</h2>
<br>
<ul>
<li>Check out code base</li>
<li>Run <code>composer install</code> from root of project</li>
<li>Copy .env.example to .env (note, default environment assumes mysql running on localhost with a scema name of minicrm and username + password of "root" - you may use sqlite instead if required, see .env.dusk for an example)</li>
<li>Run <code>php artisan migrate:fresh --seed</code> from the root of project to create the default admin user to be able to log in</li>
<li>Run <code>php artisan serve</code> from root of project to start the simple php servlet</li>
<li>Visit "127.0.0.1:8000" to use it.</li>
</ul>
<br>
For some demo data, you may use the test seeder to populate the system<br>
Run <code>php artisan db:seed --class=TestDataSeeder</code> to add 50 companies and 200 employees. Note the first set of data in each model set is programatically named and is is used during the automated dusk test runs.
<br>
<h2>Testing</h2> 
<ul>
<li>Run <code>php artisan serve --env=dusk --port=8123</code> from root to start the simple php servlet on port 8123 (note, this port is defined in the .env.dusk and is different from the standard .env setup).</li>
<li>Run </code>php artisan dusk</code> to cycle through the browser tests</li>
</ul>
<br>
The Testing environment uses a sqlite database file located at <code>/tmp/mini_crm_testing.sqlite</code>. This will need to be accessable by the current user or can be changed to another file in the <code>.env.dusk</code> file.
