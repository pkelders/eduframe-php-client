# eduframe-php-client

[![CodeFactor](https://www.codefactor.io/repository/github/drieam/eduframe-php-client/badge)](https://www.codefactor.io/repository/github/drieam/eduframe-php-client)

PHP Client for Eduframe V1

## Installation
This package is puslished on packagist.

```
composer require drieam/eduframe-php-client
```

### Access token
Fetching published courses can be executed without an access token.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$connection = new \Eduframe\Connection();
```
However when accessing invoices or users an access token is required.
An access token can be obtained by going to your profile page in the Eduframe admin dashboard.

```
$connection->setAccessToken( 'ACCESS_TOKEN' );
```

### Normal actions
After you have set the api key, the data can be fetched as following:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$connection = new \Eduframe\Connection();

// Set this in case you need an access token for your requests.
$connection->setAccessToken('ACCESSTOKEN');

// Set up a new Eduframe instance and inject the connection
$client = new Eduframe\Client( $connection );

// Example: Get courses
$courses = $client->courses()->all();

// Example: Get courses with includes in this case the course tabs
$courses_with_tabs = $client->courses()->all(['include' => 'course_tab_contents.course_tab']);

// Example: Fetch list of planned courses with meetings
$planned_courses = $client->planned_courses()->all(['include' => 'meetings']);

// Example: Fetch a single planned course by id
$planned_course = $client->planned_courses()->find(123456789);

// Example: Create a lead
$lead = $client->leads();
$lead->company_name = 'Drieam';
$lead->first_name = 'Luuk';
$lead->middle_name = 'van';
$lead->last_name = 'Hulten';
$lead->address = $client->addresses([
    'address' => 'Don Boscostraat 4',  
    'postal_code' => '5611 KW',  
    'city' => 'Eindhoven',  
    'country' => 'NL',  
]);
$lead->save();
```

## Code example
See for example: [example.php](example.php)
