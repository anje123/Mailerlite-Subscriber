## Subscriber Management System with MailerLite Integration

This project adds a subscriber management system to an existing web application, and integrates it with the MailerLite API.


# The following features were added 
- Create new subscriber by accessing the URL /subscriber/create
- Update an existing subscriber by accessing the URL /subscriber/edit
- Delete an existing subscriber from the subscriber page
- View all subscribers by accessing the URL /subscriber
- A request class to handle validations
- a middleware that checks if a key exists in the database before accessing other routes
- Encryption of Mailerlite Api key, as storing a raw key can be very unsafe


## Some Subscriber Management System Technical integration Details:

- Implements the repository design pattern for scalability, robustness and flexibility, This makes our code more robust to changes, such as if a decision was made later on to switch to a mail source that isn't MailerLite, this can easily be done without breaking any thing.
- Uses of the PHP MailerLite SDK package installed via Composer.
- Service providers was created for Mailerlite easy instantiation and dependency injection 

## Installation
To install the project, follow these steps:

- Clone the repository
- Install dependencies using Composer: composer install
- Set up the database and environment variables
- Run the database migrations: php artisan migrate
- Start the server: php artisan serve

## Usage
To use the subscriber management system, access the appropriate URLs as described above. The MailerLite integration is automatically available and can be accessed by using the MailerLite class as needed.

## Usage

The project includes tests that can be run using PHPUnit. To run the tests, execute the following command: php artisan test

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
