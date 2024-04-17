<?php

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Libaro\SecureId\MiQey;
use Mockery\MockInterface;
use Tests\TestCase;

//test('confirm environment is set to testing', function () {
//    expect(config('app.env'))->toBe('testing');
//});

test('LaravelSlowQueries can be loaded', function () {
    $package = new MiQey;

    expect($package)->toBeInstanceOf(MiQey::class);
});
