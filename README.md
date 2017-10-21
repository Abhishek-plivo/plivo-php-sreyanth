# Plivo PHP Helper SDK

**Note**: `Bleeding edge: Use with caution`
## Description
Plivo PHP helper library to access PlivoCloud API and generate Plivo XML

## Installation

[Download](https://getcomposer.org/download/) and [install](https://getcomposer.org/doc/00-intro.md#globally) composer, a dependency manager for PHP.

Run the command `composer require plivo/plivo-php` in your project directory to update your `composer.json` file and download the plivo-php library.

OR

You can clone this repository and then run the command `composer install` to generate autoload files.
Then you can `require 'vendor/autoload.php'` in your php source code to use the Plivo library

### Authentication:

To use the PHP SDK with a single client, create an api object with `$api = new PlivoApi()`, and all API calls will use this global client by default.
We recommend that you store your credentials in the `PLIVO_AUTH_ID` and the `PLIVO_AUTH_TOKEN` environment variables, so as to avoid the possibility of accidentally committing them to source control. If you do this, you can initialise the client with no arguments and it will automatically fetch them from the environment variables:

```php
$api = new PlivoApi();
```

Alternatively, you can provide these to `PlivoApi()`'s constructor yourself:

```php
$api = new PlivoApi("YOU_AUTH_ID", "YOUR_AUTH_TOKEN");
```

If you are making several requests to Plivo's API, please re-use the same client instance for maximum efficiency.

## The Basics

To send a message:

```php
$api = new PlivoApi();
$api->message->create('14153336666', ['14156667777', '14156668888'], 'Test Message');
```

To make a call

```php
$api = new PlivoApi();
$api->call->create('14153336666', ['14156667777', '14156668888'], 'http://s3.amazonaws.com/static.plivo.com/answer.xml');
```

To list all objects of any resource, simply use the request object itself as an iterable:

```php
$api = new PlivoApi();
$messages = $api->message->list;
foreach ($message as $messages) {
    echo $message->id;
}
```

To generate PlivoXML:

```php
$response = new Response();
$response->addSpeak('Hello World, from Plivo!');
echo($response->toXML());
```