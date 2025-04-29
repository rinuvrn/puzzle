Puzzle

Puzzle  is a backend application built with Symfony 6.4, designed to manage student submissions for word puzzles. 
Description:

Puzzle  provides a robust RESTful API that is easily readable and helps to manage students word puzzle submissions, evaluate , grade and show a leader board on completion of puzzle.

Technologies used:

•	Symfony 6.4

•	PHP 8.2.12 

•	Doctrine ORM/DBAL

•	Various symfony bundles

Dependencies:

The project utilizes the following key dependencies managed by Composer:

•	Symfony Components:  symfony/framework-bundle,  symfony/console,  symfony/doctrine-messenger, symfony/http-client and many more (See composer.json for a complete list)

•	Doctrine: doctrine/orm, doctrine/doctrine-bundle,doctrine/doctrine-migrations-bundle…

Installation:

1.	Create project directory (I used xampp for  setting up local server, so the project directory was created inside xampp/htdocs ).
2.	Clone the repository to project directory.
3.	Start  Apache , MySql  from xampp control panel.
4.	Start the development server by running following command in from project root folder - php -S 127.0.0.1:8000 -t public
5.	Configure environment variables like database connection in env.php 
6.	Run composer install to install all dependencies.
7.	Set up database by running the migrations with php bin/console doctrine:migrations:migrate from project root folder.
8.	Now the application will be accessible at http://127.0.0.1:8000/
9.	I have used symfony messenger with doctrine for doing asynchronous job, so it is advisable to run php bin/console messenger:consume async --time-limit=60  from project root folder so that the asynchronous queue get consumed. The time limit can be set appropriately.

List of API's


/api/puzzle/start - API to start the puzzle game

/api/puzzle/leaderboard - API to show the list of top 10 high scored words and their scores

/api/puzzle/{puzzleId}/submit - API to submit words

/api/puzzle/{puzzleId}/stop - API to stop the puzzle game

