# Laravel GPT Project


This Laravel project uses artificial intelligence to populate database tables with automatically generated data. Additionally, it provides the option to fill the tables manually.

## Requirements
- PHP >= 8.1
- Laravel 9,10,11
- Composer
- MySQL / PostgreSQL / SQLite / SQL Server

Clone the project

```bash
  https://github.com/jhoncolocolo/laragpt.git
```

Go to the project directory

```bash
  cd laragpt
```

Install dependencies

```bash
  composer install
```

### Previously it is necessary to create a database for this case we will call it YOUR_DATABASE_NAME

## Environment Variables
For this example, the database name is: YOUR_DATABASE_NAME but if you want to change the name, put the name of your preference in the correct parameter of the .(env) file

In the environment (.env) file, update these variables, remember you need to rename the file in the root folder .env.example to .env

# After 

`DB_CONNECT=mysql`

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=YOUR_DATABASE_NAME`

`DB_USERNAME=YOUR_USER_NAME`

`DB_USERNAME=YOUR_PASSWORD`

After running these migrations:

## You Have Two Options

run migrations through Artificial Intelligence o run the basic way

# Run migration and a seeders through Artificial Intelligence

For this you need two steps

## First run migration
```bash
php artisan migrate:refresh
```
## Second run seeders through Artificial Intelligence

```bash
php artisan app:fill-data-with-gpt-command
```
(Important This command after exec php artisan migrate:refresh)
![Información Comando AI](https://github.com/jhoncolocolo/laragpt/assets/1965532/e10469b9-d59a-4c4c-a248-0bde61ad38e2)


#### On the other hand you can run migrations and seeders through basic way

```bash
php artisan migrate:refresh --seed
```

Start the server

```bash
  php artisan serve
```

# Exec TEST

To see that our system works well, execute this command

```bash
  php artisan test
```

![test](https://github.com/jhoncolocolo/laragpt/assets/1965532/86931afe-f2b3-470f-8d35-23326eaf84d8)

# For our Project we use the package GEMINI AI 

More info https://github.com/google-gemini-php/laravel?tab=readme-ov-file#installation

## Setup Gemini AI

### Installation

First, install Gemini via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require google-gemini-php/laravel
```

Next, execute the install command:

```bash
php artisan gemini:install
```

This will create a config/gemini.php configuration file in your project, which you can modify to your needs using environment variables. Blank environment variables for the Gemini API key is already appended to your .env file.

```
GEMINI_API_KEY=
```


### Setup your API key
To use the Gemini API, you'll need an API key. If you don't already have one, create a key in Google AI Studio.

[Get an API key](https://makersuite.google.com/app/apikey)

Prerequisites
Create a Google Cloud Platform account: https://cloud.google.com/.

Enable the Gemini API: https://support.gemini.com/hc/en-us/articles/204732875-How-can-I-use-the-Gemini-API.

Create an API key: https://cloud.google.com/docs/authentication/api-keys?hl=en.
Install the Gemini API PHP package: composer require gemini-api-php/laravel

