# MiQey Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/libaro/secure-id.svg?style=flat-square)](https://packagist.org/packages/libaro/secure-id)
[![Total Downloads](https://img.shields.io/packagist/dt/libaro/secure-id.svg?style=flat-square)](https://packagist.org/packages/libaro/secure-id)

The SMiQey Client Laravel Package simplifies the integration of the MiQey functionality into your Laravel projects. MiQey is designed to facilitate a secure login procedure by generating sign requests, managing user responses through QR codes or SMS, and seamlessly logging users into your projects.

## Installation

You can install the package via composer:

```bash
composer require libaro/miqey-client
```

Publish the config file: 
```php
php artisan vendor:publish --provider="Libaro\MiQey\MiQeyServiceProvider" --tag="config"
```
The content of the config file:
```php
return [
    'api_url' => env('SECURE_ID_API_URL', 'https://secureid.digitalhq.com/api/generate'),
    'api_key' => env('SECURE_ID_API_KEY'),
    'api_url_prefix' => env('SECURE_ID_API_URL_PREFIX', '/api/secure-id'),
];
```

## Usage

The default WebhookHandler can be replaced by a custom handler in the config file for handling events to authenticating users.
```php
class SecureIdWebhookHandler implements WebhookHandlerInterface
{
	public function handleWebhook(string $phone, string $code): void
	{
		event(new SMSSignRequestReceived($code, $phone));
	}
}
```

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

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
