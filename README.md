# Spotify Api

<li>Set your spotify account in .env file</li>

        SPOTIFY_CLIENT_ID=your_client_id
        SPOTIFY_CLIENT_SECRET=your_client_secret

<li>Getting Started</li>

        composer update
    
        php artisan key:generate
    
        php artisan migrate
        
        php artisan passport:install

<br>

<li>Swagger can be available:</li>
    
        url      : /api/documentation
        email    : test@test.com
        password : 12345678

</li>

<li>After receiving your token log in via Swagger.

        Bearer TOKEN_ADRESS

</li>

<hr>

<li>How to run cron job?

        php artisan schedule:work

</li>

<br>

<li>How to run manuel cron job?

        php artisan app:api-cron-job

</li>
