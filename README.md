# Virtual Zoo API

## Overview
This project is a Virtual Zoo API built with Symfony and API Platform. The system simulates a zoo with various types of animals and provides functionalities such as brushing and feeding them via API endpoints.

## Features
- **Animal Management**: Add and manage different types of animals including Tigers, Elephants, Foxes, Rhinoceroses, Snow Leopards, and Rabbits.
- **Feeding**: Feed animals with specific types of food (e.g., meat or plants).
- **Brushing**: Brush animals that have fur or require grooming.
- **Inheritance Structure**: Uses `SINGLE_TABLE` inheritance in Doctrine to organize animal types under a common `Animal` class.
- **Custom Endpoints**: Specialized endpoints for brushing and feeding specific animals.

## Technologies Used
- **Symfony**: PHP framework used to build the core application.
- **API Platform**: Used to create RESTful APIs and provide auto-generated documentation.
- **Doctrine ORM**: Handles database interactions.
- **PHP**: Programming language for the application.
- **Composer**: Dependency management.

## Project Structure
```
project-root/
├── config/
│   ├── bundles.php
│   ├── packages/
│   ├── routes/
│   │   ├── api_platform.yaml
│   │   └── annotations.yaml
│   └── services.yaml
├── public/
│   ├── index.php
│   └── ...
├── src/
│   ├── Controller/
│   │   ├── Animals/
│   │   │   ├── TigerController.php
│   │   │   ├── ElephantController.php
│   │   │   └── ...
│   │   └── AnimalController.php
│   ├── Entity/
│   │   ├── Animals/
│   │   │   ├── Animal.php
│   │   │   ├── Tiger.php
│   │   │   ├── Elephant.php
│   │   │   ├── Rhinoceros.php
│   │   │   ├── Fox.php
│   │   │   ├── SnowLeopard.php
│   │   │   └── Rabbit.php
│   │   └── Food/
│   │       ├── Meat.php
│   │       └── Plant.php
│   ├── Interface/
│   │   ├── BrushableInterface.php
│   │   └── Food.php
│   └── Repository/
│       └── AnimalRepository.php
├── migrations/
│   ├── Version2024xxxxxx.php
│   └── ...
├── tests/
│   ├── Controller/
│   └── ...
├── var/
│   ├── cache/
│   ├── log/
│   └── ...
├── vendor/
│   └── ...
├── .env
├── composer.json
├── composer.lock
├── README.md
└── symfony.lock
```

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/virtual-zoo-api.git
   cd virtual-zoo-api

2. **Install dependencies**:

    ```bash
    composer install
    ```

3. **Set up the database**:

- Configure your .env file with your database connection settings.
- Run the migrations:

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

4. **Run the development server**:

    ```bash
    symfony serve
    ```

## Usage
### API Endpoints
1. **Add an Animal**:
   - POST /api/animals (Default API Platform POST endpoint)
   
2. **Brush a Tiger**:
   - POST /api/tiger/{id}/brush
   
2. **Feed a Tiger**:
   - POST /api/tiger/{id}/eat with JSON payload:
   ```json
   {
   "foodType": "meat"
   }
   ```
## Sample Requests
   ### Brush a Tiger
   ```bash
   curl -X POST http://localhost:8000/api/tiger/1/brush
   ```
   ### Feed a Tiger
   ```bash
   curl -X POST http://localhost:8000/api/tiger/1/eat -H "Content-Type: application/json" -d '{"foodType": "meat"}'
   ```