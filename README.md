# Event Management System

## Installation instructions
To set up the project locally follow the instructions.

### Laravel Sail (Docker) installation
Install Docker and Docker Compose for the operating system of your choice.

Clone the repository and get into the project directory

Set up the docker containers using the following command:
```
docker run --rm \
-u "$(id -u):$(id -g)" \
-v $(pwd):/var/www/html \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs
```

Run the containers in daemon mode using `vendor/bin/sail up -d`.

Access the PHP container using `vendor/bin/sail shell`.

Run `composer install` to install of the composer dependencies.

Rename the example .env.example file using `cp .env.example .env`.

Run php artisan `key:generate` to generate an application key (`APP_KEY`).

Run `php artisan migrate` to run all migrations and database seeders.

To run the tests, run the following command:
```shell
php artisan test
```

Going to `localhost` should open the application.

### Installation without docker

Follow the Laravel documentation about the requirements and install the required software.

Clone the repository and get into the project directory.

Run `composer install` to install of the composer dependencies.

Rename the example .env.example file using `cp .env.example .env`.

Run php artisan `key:generate` to generate an application key (`APP_KEY`).

Run `php artisan migrate` to run all migrations and database seeders.

You may need to create a database called `testing` in order to run the tests.

To run the tests, run the following command:
```shell
php artisan test
```

Open the application in your browser.

## Usage

First, you have to register, so go to the top right corner and register a new account.

Once you are in, sign up as a speaker from the top navigation menu.

Now that that's successful, you can submit a talk proposal by visiting the talk proposal submission form.

To view the talk proposals API go to:
```
GET http://localhost:8000/api/v1/talk-proposals
```

If you have any trouble running this project or using it, feel free to contact me.
