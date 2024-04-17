<?php

use Illuminate\Support\Facades\Route;

Route::name('api.secure-id.')
    ->prefix(config('secure-id.api_url_prefix'))
    ->group(function () {
        //Route::name('sign')
        //    ->post('sign/webhook', [WebhookController::class, 'handle']);
    });
