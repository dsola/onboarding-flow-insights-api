# On-boarding flow insights API
- This API provides information about the user retention based on the date and the on boarding step.
- The information is provided with JSON format.

## Installation
You just need to run `composer` to install the dependencies.
```bash
$ composer install
```
## Running the application
- You can use the PHP localhost server in your machine, from the root folder:
```bash
$ cd public
$ php -S localhost:5555
```
- Another option is using Docker. You simply need to run the docker composer using the `docker-compose.yml` provided in 
the root  folder.
```bash
$ docker-composer up -d
```
## Usage
To run this application you need to start a web server in order to activate the route that offers the data about the users
retentions of different samples where the user within the boarding process.

For the moment the API only provides a single route to get the series data in weekly cohorts about the user retention based on the on boarding step.

The route is `/api/v1/on_boarding_flow/insights`.

This is an example of a response when we request this route:
```json
{
    "statusCode": 200,
    "data": [
        {
            "title": "2016-07-19 2016-07-26",
            "series": [
                {
                    "user_retained_percentage": 100,
                    "step": {
                        "percentage": 0,
                        "name": "Create an account"
                    }
                },
                ...
            ]
        },
        {
            "title": "2016-08-04 2016-08-11",
            "series": [
                {
                    "user_retained_percentage": 100,
                    "step": {
                        "percentage": 0,
                        "name": "Create an account"
                    }
                },
              ...
            ]
        },
        ...
    ]
}
```
### Using Docker
Same idea but we need to execute the command in the container and redirect the std output.
```php
docker exec -it <CONTAINER ID OR NAME> bash -c "php -f run.php <YOUR INPUT FILE>.txt 2>&1"
```
## Running Tests
This application is completely tested to be sure everything works fine and to give the reader some help to understand 
the implementation.
### Locally
Simply run the PHPUnit binary located in the `vendor` folder.
```php
vendor/bin/phpunit
```
### Using Docker
Same idea but we need to execute the command in the container and redirect the std output.
```php
docker exec -it <CONTAINER ID OR NAME> bash -c "vendor/bin/phpunit 2>&1"
```
