# MiQey Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/libaro/miqey-client.svg?style=flat-square)](https://packagist.org/packages/libaro/miqey-client)
[![Total Downloads](https://img.shields.io/packagist/dt/libaro/miqey-client.svg?style=flat-square)](https://packagist.org/packages/libaro/miqey-client)

The MiQey Client Laravel Package simplifies the integration of the MiQey functionality into your Laravel projects. MiQey is designed to facilitate a secure login procedure by generating sign requests, managing user responses through QR codes or SMS, and seamlessly logging users into your projects.

## Installation

You can install the package via composer:

```bash
composer require libaro/miqey-client
```

Publish the config file: 
```php
php artisan vendor:publish --provider="Libaro\MiQey\MiQeyServiceProvider" --tag="config"
```

## Usage

Add the following to your login page:

````javascript
const pusherKey = 'your pusher key';
const subChannel = 'signRequest_{generated_code_from_MiQey}';
const authEndpoint = '/miqey/validate';

var pusher = new Pusher(pusherKey, {
    cluster: 'eu'
});

var channel = pusher.subscribe(subChannel);
channel.bind('sign-request-received', function (data) {
    window.location.href = authEndpoint + '?token=' + data.token
});
````

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


### Security

If you discover any security related issues, please email github@libaro.be instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
