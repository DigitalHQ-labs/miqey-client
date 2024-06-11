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

## Example login page

```php
<x-layout>
<div class="flex flex-col items-center"><div class="flex py-3 shrink-0 items-center bg-gray-100 rounded justify-center w-1/2">
            <h1 class="text-3xl">My Application</h1>
        </div>
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-slate-700">Sign in to your account</h2>
        <div class="text-center mt-4">
            @if($sign['type'] === 'sms')
                <h4 class="text-gray-500">Press the button to send an SMS and sign in.</h4>
            @else
                <h4 class="text-gray-500">Scan the QR code and send the generated SMS-message. You will be automatically logged in.</h4>
            @endif
        </div>
    </div>
    <div>
        <div class="flex flex-row justify-center pt-5">
            <div>
                @if($sign['type'] === 'sms')
                    <a href="{!! $sign['data'] !!}"
                       class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        {{ __('Send SMS to login') }}
                    </a>
                @else
                    {!! $sign['data'] !!}
                @endif
            </div>
        </div>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        const pusherKey = '{{ config("broadcasting.connections.pusher.key") }}';
        const subChannel = 'signRequest_{{ $sign["code"] }}';
        const authEndpoint = '/miqey/validate';

        const pusher = new Pusher(pusherKey, {
            cluster: 'eu'
        });

        const channel = pusher.subscribe(subChannel);
        channel.bind('sign-request-received', function (data) {
            window.location.href = authEndpoint + '?token=' + data.token + '&redirect_to=/dashboard'
        });
    </script>
</x-layout>
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
