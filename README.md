# Laravel GPT Project



## [DEMO EXECUTION API](https://laragpt.cljws.com/api/documentation)


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

`GEMINI_API_KEY="YOUR__API_KEY"   ##Value needed to connect to the GEMINI API (For connection with GEMINI AI GPT)`

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

![Información Comando AI](https://github.com/jhoncolocolo/laragpt/assets/1965532/e10469b9-d59a-4c4c-a248-0bde61ad38e2)

## Important that you need to configure the value of the connection key towards the Gemini API in the file.env (you see in the section ## Setup Gemini AI
 )
![image](https://github.com/jhoncolocolo/laragpt/assets/1965532/2f196952-3a29-4ad1-a899-c0fd6bcdc286)

## (This command after exec php artisan migrate:refresh)

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
# API Guide

## Users

#### Get all users
- Method: GET
- URL: `https://laragpt.cljws.com/api/users`

#### Get a specific user
- Method: GET
- URL: `https://laragpt.cljws.com/api/users/{id}`
  - Replace `{id}` with the desired user ID.

#### Create a new user
- Method: POST
- URL: `https://laragpt.cljws.com/api/users`
- Request body structure:

```json
  {
      "name": "string",
      "email": "string",
      "image_path": "string"
  }
```
### Update an existing user
Method: PUT
URL: https://laragpt.cljws.com/api/users/{id}
Replace {id} with the ID of the user you want to update.
Request body structure:

```json
Copy code
{
    "name": "string",
    "email": "string",
    "image_path": "string"
}
```
### Delete a user
Method: DELETE
URL: https://laragpt.cljws.com/api/users/{id}
Replace {id} with the ID of the user you want to delete.

## Challenge

#### Get all challenges
- Method: GET
- URL: `https://laragpt.cljws.com/api/challenges`

#### Get a specific challenge
- Method: GET
- URL: `https://laragpt.cljws.com/api/challenges/{id}`
  - Replace `{id}` with the desired challenge ID.

#### Create a new challenge
- Method: POST
- URL: `https://laragpt.cljws.com/api/challenges`
- Request body structure:

```json
  {
     "title": "string",
     "description": "string",
     "difficulty": "integer between 1 and 3",
     "user_id": "integer"
  }
```
### Update an existing challenge
Method: PUT
URL: https://laragpt.cljws.com/api/challenges/{id}
Replace {id} with the ID of the challenge you want to update.
Request body structure:

```json
  {
     "title": "string",
     "description": "string",
     "difficulty": "integer between 1 and 3",
     "user_id": "integer"
  }
```
### Delete a challenge
Method: DELETE
URL: https://laragpt.cljws.com/api/challenges/{id}
Replace {id} with the ID of the challenge you want to delete.



## Company

#### Get all companies
- Method: GET
- URL: `https://laragpt.cljws.com/api/companies`

#### Get a specific company
- Method: GET
- URL: `https://laragpt.cljws.com/api/companies/{id}`
  - Replace `{id}` with the desired company ID.

#### Create a new company
- Method: POST
- URL: `https://laragpt.cljws.com/api/companies`
- Request body structure:

```json
  {
    'name':'string',
    'image_path':string,
    'location':string,
    'industry':string,
    'user_id':'integer'
  }
```
### Update an existing company
Method: PUT
URL: https://laragpt.cljws.com/api/companies/{id}
Replace {id} with the ID of the company you want to update.
Request body structure:

```json
  {
    'name':'string',
    'image_path':string,
    'location':string,
    'industry':string,
    'user_id':'integer'
  }
```
### Delete a company
Method: DELETE
URL: https://laragpt.cljws.com/api/companies/{id}
Replace {id} with the ID of the company you want to delete.

## Program

#### Get all programs
- Method: GET
- URL: `https://laragpt.cljws.com/api/programs`

#### Get a specific program
- Method: GET
- URL: `https://laragpt.cljws.com/api/programs/{id}`
  - Replace `{id}` with the desired program ID.

#### Create a new program
- Method: POST
- URL: `https://laragpt.cljws.com/api/programs`
- Request body structure:

```json
  {
    'title':'string',
    'description':'string',
    'start_date':'date('Y-M-D')',
    'end_date':'date('Y-M-D')',
    'user_id':integer
  }
```
### Update an existing program
Method: PUT
URL: https://laragpt.cljws.com/api/programs/{id}
Replace {id} with the ID of the program you want to update.
Request body structure:

```json
  {
    'title':'string',
    'description':'string',
    'start_date':'date('Y-M-D')',
    'end_date':'date('Y-M-D')',
    'user_id':integer
  }
```
### Delete a program
Method: DELETE
URL: https://laragpt.cljws.com/api/programs/{id}
Replace {id} with the ID of the program you want to delete.

## Program

#### Get all program_participants
- Method: GET
- URL: `https://laragpt.cljws.com/api/program_participants`

#### Get a specific program_participant
- Method: GET
- URL: `https://laragpt.cljws.com/api/program_participants/{id}`
  - Replace `{id}` with the desired program_participants ID.

#### Create a new program_participant
- Method: POST
- URL: `https://laragpt.cljws.com/api/program_participants`
- Request body structure:

```json
  {
        'program_participant_id':random(integer between 1 and 14),
        'entity_type':random(any string of this ['App\\Models\User','App\Models\Challenge', 'App\Models\Company']),
        'entity_id':random(integer)
  }
```
### Update an existing program_participant
Method: PUT
URL: https://laragpt.cljws.com/api/program_participants/{id}
Replace {id} with the ID of the program_participant you want to update.
Request body structure:

```json
  {
        'program_participant_id':random(integer between 1 and 14),
        'entity_type':random(any string of this ['App\\Models\User','App\Models\Challenge', 'App\Models\Company']),
        'entity_id':random(integer)
  }
```
### Delete a program_participant
Method: DELETE
URL: https://laragpt.cljws.com/api/program_participants/{id}
Replace {id} with the ID of the program_participants you want to delete.


# Setup your API key
To use the Gemini API, you'll need an API key. If you don't already have one, create a key in Google AI Studio.

[Get an API key](https://makersuite.google.com/app/apikey)

Prerequisites
Create a Google Cloud Platform account: https://cloud.google.com/.

Enable the Gemini API: https://support.gemini.com/hc/en-us/articles/204732875-How-can-I-use-the-Gemini-API.

Create an API key: https://cloud.google.com/docs/authentication/api-keys?hl=en.
Install the Gemini API PHP package: composer require gemini-api-php/laravel

# Other Considerations in the way of programming code for this project we have this methodology
```bash
  +---------------------+
  | routes/api.php      |
  |                     |
  | Define routes and  |
  | direct requests to |
  | the controller.     |
  +---------------------+
              |
              v
  +---------------------+
  | Controller          |
  |                     |
  | Receives the request|
  | and directs the flow|
  | to the appropriate  |
  | components.         |
  +---------------------+
              |
              v
  +---------------------+
  | HTTP Request        |
  | and Request         |
  | Validation          |
  |                     |
  | Handles input       |
  | validation. If not  |
  | valid, returns a    |
  | 405 error.          |
  +---------------------+
             |
             v
  +---------------------+
  | Service             |
  |                     |
  | Coordinates and     |
  | executes business   |
  | logic.              |
  +---------------------+
             |
             v
  +---------------------+
  | Repository          |
  |                     |
  | Interacts with the  |
  | model and performs  |
  | database operations.|
  +---------------------+
             |
             v
  +---------------------+
  | Model               |
  |                     |
  | Represents data and |
  | business rules.     |
  +---------------------+
             |
             v
  +---------------------+
  | Database            |
  |                     |
  | Stores and retrieves|
  | data based on model |
  | operations.         |
  +---------------------+
             |
             v
  +---------------------+
  | Response (View)     |
  |                     |
  | Formats and sends   |
  | the response to the |
  | client.             |
  +---------------------+

```


/***********************************************************************************/
# Spanish Version

## Proyecto Laravel GPT

## [DEMO EJECUCIÓN DE LA API](https://laragpt.cljws.com/api/documentation)

Este proyecto de Laravel utiliza inteligencia artificial para poblar las tablas de la base de datos con datos generados automáticamente. Además, proporciona la opción de llenar las tablas manualmente.

Requisitos
PHP >= 8.1

Laravel 9,10,11

Composer

MySQL / PostgreSQL / SQLite / SQL Server

Clona el proyecto

```bash
 git clone  https://github.com/jhoncolocolo/laragpt.git
```

Ve al directorio del proyecto

```bash
  cd laragpt
```
Instala las dependencias

```bash
  composer install
```

Antes, es necesario crear una base de datos. En este caso, la llamaremos YOUR_DATABASE_NAME.

Variables de Entorno

Para este ejemplo, el nombre de la base de datos es: YOUR_DATABASE_NAME, pero si deseas cambiar el nombre, pon el nombre que prefieras en el parámetro correcto del archivo .env

En el archivo de entorno (.env), actualiza estas variables, recuerda que necesitas renombrar el archivo en la carpeta raíz de .env.example a .env

Después
`DB_CONNECT=mysql`

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=YOUR_DATABASE_NAME`

`DB_USERNAME=YOUR_USER_NAME`

`DB_USERNAME=YOUR_PASSWORD`

`GEMINI_API_KEY="YOUR__API_KEY" ##Valor necesario para conectarse a la Api de GEMINI API (Para la conexión con GPT AI)`

#Después podemos ejecutar las migraciones:

## Tienes Dos Opciones
Ejecutar migraciones a través de Inteligencia Artificial o ejecutar de manera básica.

### Ejecutar migraciones y seeders a través de Inteligencia Artificial
#### Para esto necesitas dos pasos

##### Primero ejecuta la migración
```bash
php artisan migrate:refresh
```

##### Segundo ejecuta los seeders a través de Inteligencia Artificial
```bash
php artisan app:fill-data-with-gpt-command
```

![Información Comando AI](https://github.com/jhoncolocolo/laragpt/assets/1965532/e10469b9-d59a-4c4c-a248-0bde61ad38e2)

## Importante que necesitas configurar el valor de la llave de conexión hacia la API de Gemini en el archivo .env file  (Lo verá en la sección Configuración de Gemini AI)

![image](https://github.com/jhoncolocolo/laragpt/assets/1965532/2f196952-3a29-4ad1-a899-c0fd6bcdc286)
## (Importante Este comando después de ejecutar php artisan migrate:refresh)

##### Por otro lado, puedes ejecutar migraciones y seeders de manera básica
```bash
php artisan migrate:refresh --seed
```
Inicia el servidor

```bash
  php artisan serve
```

## Ejecutar TEST
Para comprobar que nuestro sistema funciona bien, ejecuta este comando

```bash
  php artisan test
```
![test](https://github.com/jhoncolocolo/laragpt/assets/1965532/86931afe-f2b3-470f-8d35-23326eaf84d8)

Para nuestro Proyecto utilizamos el paquete GEMINI AI
Más información https://github.com/google-gemini-php/laravel?tab=readme-ov-file#installation

## Configuración de Gemini AI
Instalación
Primero, instala Gemini a través del administrador de paquetes Composer:

```bash
composer require google-gemini-php/laravel
```

A continuación, ejecuta el comando de instalación:

```bash
php artisan gemini:install
```

Esto creará un archivo de configuración config/gemini.php en tu proyecto, que puedes modificar según tus necesidades usando variables de entorno. Las variables de entorno en blanco para la clave de API de Gemini ya están agregadas a tu archivo .env.

```bash
GEMINI_API_KEY=
```

Configurar tu clave de API
Para usar la API de Gemini, necesitarás una clave de API. Si aún no tienes una, crea una clave en Google AI Studio.

Obtener una clave de API

Prerrequisitos
Crea una cuenta en Google Cloud Platform: https://cloud.google.com/.

Habilita la API de Gemini: https://support.gemini.com/hc/en-us/articles/204732875-How-can-I-use-the-Gemini-API.

Crea una clave de API: https://cloud.google.com/docs/authentication/api-keys?hl=en.
Instala el paquete de PHP de la API de Gemini: composer require gemini-api-php/laravel

## Guía de API

### Usuarios

#### Obtener todos los usuarios
- Método: GET
- URL: `https://laragpt.cljws.com/api/users`

#### Obtener un usuario específico
- Método: GET
- URL: `https://laragpt.cljws.com/api/users/{id}`
  - Reemplazar `{id}` con el ID del usuario deseado.

#### Crear un nuevo usuario
- Método: POST
- URL: `https://laragpt.cljws.com/api/users`
- Estructura del cuerpo de la solicitud:
```json
  {
      "name": "string",
      "email": "string",
      "image_path": "string"
  }
```

### Actualizar un usuario existente
- Método: PUT
- URL: https://laragpt.cljws.com/api/users/{id}
- Reemplazar {id} con el ID del usuario que deseas actualizar.
- Estructura del cuerpo de la solicitud:
```json
{
    "name": "string",
    "email": "string",
    "image_path": "string"
}
```

### Eliminar un usuario
Método: DELETE
URL: https://laragpt.cljws.com/api/users/{id}
Reemplazar {id} con el ID del usuario que deseas eliminar.

## Challenge

#### Obtener todo los Challenges
- Método: GET
- URL: `https://laragpt.cljws.com/api/challenges`

#### Obtener un challenge Especifio
- Método: GET
- URL: `https://laragpt.cljws.com/api/challenges/{id}`
  - Reemplazar {id} con el ID del challenge que deseas buscar.
Estructura del cuerpo de la solicitud:

#### Create a new challenge
- Método: POST
- URL: `https://laragpt.cljws.com/api/challenges`
- Request body structure:

```json
  {
     "title": "string",
     "description": "string",
     "difficulty": "integer between 1 and 3",
     "user_id": "integer"
  }
```
### Update an existing challenge
Método: PUT
URL: https://laragpt.cljws.com/api/challenges/{id}
Reemplazar {id} con el ID del challenge que deseas actualizar.
Estructura del cuerpo de la solicitud:

```json
  {
     "title": "string",
     "description": "string",
     "difficulty": "integer between 1 and 3",
     "user_id": "integer"
  }
```
### Delete a challenge
Method: DELETE
URL: https://laragpt.cljws.com/api/challenges/{id}
Reemplazar {id} con el ID del challenge que deseas eliminar.

## Company

#### Obtener todas las companies
- Method: GET
- URL: `https://laragpt.cljws.com/api/companies`

#### Get a specific company
- Method: GET
- URL: `https://laragpt.cljws.com/api/companies/{id}`
  - Replace `{id}` with the desired company ID.

#### Create a new company
- Method: POST
- URL: `https://laragpt.cljws.com/api/companies`
- Request body structure:

```json
  {
    'name':'string',
    'image_path':string,
    'location':string,
    'industry':string,
    'user_id':'integer'
  }
```
### Update an existing company
Method: PUT
URL: https://laragpt.cljws.com/api/companies/{id}
Replace {id} with the ID of the company you want to update.
Request body structure:

```json
  {
    'name':'string',
    'image_path':string,
    'location':string,
    'industry':string,
    'user_id':'integer'
  }
```
### Delete a company
Method: DELETE
URL: https://laragpt.cljws.com/api/companies/{id}
Replace {id} with the ID of the company you want to delete.

## Program

#### Get all programs
- Method: GET
- URL: `https://laragpt.cljws.com/api/programs`

#### Get a specific program
- Method: GET
- URL: `https://laragpt.cljws.com/api/programs/{id}`
  - Replace `{id}` with the desired program ID.

#### Create a new program
- Method: POST
- URL: `https://laragpt.cljws.com/api/programs`
- Request body structure:

```json
  {
    'title':'string',
    'description':'string',
    'start_date':'date('Y-M-D')',
    'end_date':'date('Y-M-D')',
    'user_id':integer
  }
```
### Update an existing program
Method: PUT
URL: https://laragpt.cljws.com/api/programs/{id}
Replace {id} with the ID of the program you want to update.
Request body structure:

```json
  {
    'title':'string',
    'description':'string',
    'start_date':'date('Y-M-D')',
    'end_date':'date('Y-M-D')',
    'user_id':integer
  }
```
### Delete a program
Method: DELETE
URL: https://laragpt.cljws.com/api/programs/{id}
Replace {id} with the ID of the program you want to delete.

## Program

#### Get all program_participants
- Method: GET
- URL: `https://laragpt.cljws.com/api/program_participants`

#### Get a specific program_participant
- Method: GET
- URL: `https://laragpt.cljws.com/api/program_participants/{id}`
  - Replace `{id}` with the desired program_participants ID.

#### Create a new program_participant
- Method: POST
- URL: `https://laragpt.cljws.com/api/program_participants`
- Request body structure:

```json
  {
        'program_participant_id':random(integer between 1 and 14),
        'entity_type':random(any string of this ['App\\Models\User','App\Models\Challenge', 'App\Models\Company']),
        'entity_id':random(integer)
  }
```
### Update an existing program_participant
Method: PUT
URL: https://laragpt.cljws.com/api/program_participants/{id}
Replace {id} with the ID of the program_participant you want to update.
Request body structure:

```json
  {
        'program_participant_id':random(integer between 1 and 14),
        'entity_type':random(any string of this ['App\\Models\User','App\Models\Challenge', 'App\Models\Company']),
        'entity_id':random(integer)
  }
```
### Delete a program_participant
Method: DELETE
URL: https://laragpt.cljws.com/api/program_participants/{id}
Replace {id} with the ID of the program_participants you want to delete.



# Otras Consideraciones en la forma de programar código para este proyecto tenemos esta metodología

```bash
  +---------------------+
  | routes/api.php      |
  |                     |
  | Define las rutas   |
  | y dirige las       |
  | solicitudes al     |
  | controlador        |
  +---------------------+
              |
              v
  +---------------------+
  | Controller          |
  |                     |
  | Recibe la solicitud|
  | y dirige el flujo  |
  | hacia los          |
  | componentes        |
  | adecuados.         |
  +---------------------+
              |
              v
  +---------------------+
  | HTTP Request        |
  | y Validación       |
  | de la petición      |
  |                     |
  | Maneja la           |
  | validación de los  |
  | datos de entrada.   |
  | Si no es válida,   |
  | devuelve un error  |
  | 405.                |
  +---------------------+
             |
             v
  +---------------------+
  | Servicio            |
  |                     |
  | Coordina y ejecuta  |
  | la lógica de        |
  | negocio.            |
  +---------------------+
             |
             v
  +---------------------+
  | Repositorio         |
  |                     |
  | Interactúa con el   |
  | modelo y realiza    |
  | operaciones de base |
  | de datos.           |
  +---------------------+
             |
             v
  +---------------------+
  | Modelo              |
  |                     |
  | Representa los datos|
  | y las reglas de     |
  | negocio.            |
  +---------------------+
             |
             v
  +---------------------+
  | Base de Datos       |
  |                     |
  | Almacena y recupera |
  | datos según las      |
  | operaciones del     |
  | modelo.             |
  +---------------------+
             |
             v
  +---------------------+
  | Respuesta (Vista)   |
  |                     |
  | Formatea y envía la |
  | respuesta al cliente|
  +---------------------+

```
