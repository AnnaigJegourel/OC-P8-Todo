# OC-P8-Todo

Training program "Back-end Developer: PHP/Symfony" (OpenClassrooms)  
Project 8: Upgrade an existing project (study project)

- Improving the MVP of a start-up: upgrade &amp; fix code, implement authorizations &amp; automated tests
- The mission: <https://openclassrooms.com/projects/ameliorer-un-projet-existant-1>
- The MVP: <https://github.com/saro0h/projet8-TodoList>

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/2dfaed95a71c41d2b28f30ee90e5453d)](https://app.codacy.com/gh/AnnaigJegourel/OC-P8-Todo/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)
[![Maintainability](https://api.codeclimate.com/v1/badges/f876dca7e2dfaa874266/maintainability)](https://codeclimate.com/github/AnnaigJegourel/OC-P8-Todo/maintainability)

## Configuration / Technologies ⚙️

xamppserver  
MySQL / MariaDB  
PHP 8.1  
Symfony 5.4

## Installation 🧑🏻‍🔧

### Importing the repository

1. Clone the repository to work on your localhost.
2. To install the dependencies, run the following command at the root of the project:

    ````text
    composer intall
    ````

### Configuring the database

3. Launch xamppserver, configure your php version.
4. Create the database running:

    ````text
    php bin/console doctrine:database:create
    ````

5. Import its structure using this command:

    ````text
    php bin/console doctrine:schema:update --force
    ````

6. You can also load the fixtures as initial set of data:

    ````text
    php bin/console doctrine:fixtures:load
    ````

### Launching the project

7. Launch the Symfony server running:

    ````text
    symfony server:start
    ````

🎉 Congrats! You can now watch at the project in your navigator following the link given in your terminal, mostly:
<https://localhost:8000/>

## Working on tests 🧑🏽‍🔬

### Set up the environment

1. Once your project is installed as described above, you should have PHPUnit, phpunit-bridge (in the project, running composer) & x-debug (in Xampp) ready.
2. Configure your .env.test file to access the test data in your database.
3. Create the test database & its tables running:

    ````text
    php bin/console doctrine:database:create
    ````

    ````text
    php bin/console doctrine:schema:update --force
    ````

4. Then load the test fixtures:

    ````text
    php bin/console doctrine:fixtures:load
    ````

### Review the existing tests

- their classes & methods in the repository /tests/
- their results in /public/test-coverage/
- read it easily in a navigator: <https://localhost:8000/test-coverage/index.html>

### Create and modify tests

- Write your code in tests/
- To execute all tests, run the following command:
  
    ````text
    php vendor/bin/phpunit
    ````

- Generate the test coverage report running:
  
    ````text
    php vendor/bin/phpunit --coverage-html public/test-coverage
    ````
