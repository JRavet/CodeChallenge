Steps to test:
1) Navigate (via terminal) to the directory containing this README
2) Run the following command to install the project's dependencies: composer install
3) Run the following command to start the webserver: php artisan serve
4) Open a web browser
5) Go to 127.0.0.1:8000 to view the one and only page.
6) Back in the terminal, run the following command to run the tests: ./vendor/phpunit/phpunit/phpunit
    - optionally, append "--group groupNameGoesHere" or "--filter functionNameGoesHere" to run specific tests