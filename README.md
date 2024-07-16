# apiPlatform_bar

This is a student project to learn about api using symfony. <br>
The Subject of this exercice is available here: https://docs.yoanncoualan.com/api-platform/evaluations/iim-A3-1

## Authors

This project was made by: 

- ZHANG Tony

## Prerequisites

- PHP >= 8.2
- Composer 2.5
- Symfony CLI
- MySQL database

## Installation

1. Run this command to clone the repository:
   git clone https://github.com/AznTufu/apiPlatform_bar.git

2. Run this command to navigate to the project directory:
   cd apiPlatform_bar

3. Run this command to install dependencies:
   composer install

4. Set up the environment variables in by creating an `.env.local` file, copy this command line into this file and edit it with your personal data:
```
   DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?charset=utf8mb4"
```
You will also need to add this into this file: 
```
APP_SECRET=b67d909e38b6442d5462b224ad509ace

###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=050fbf5c2374cab1febea99838f0aa7459137635b8427914fcb43057d4efb2d7
###< lexik/jwt-authentication-bundle ###
```

5. Run this command to create the database:
   `php bin/console doctrine:database:create`
   
6. Run this command to create a migration
   `php bin/console make:migration`
   
7. And finnaly this command to apply the migration
   `php bin/console d:m:m`

## Running the Project

1. Start the Symfony development server:
   `symfony serve`

2. Access to the routes definition in your web browser at `https://127.0.0.1:8000/api`.

3. Import the postman collection from the repo to test the queries.