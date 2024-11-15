<?php

use Illuminate\Support\Facades\Route;
use DigitalHQ\MiQey\Handlers\WebhookHandler;
use DigitalHQ\MiQey\Http\Controllers\ValidationController;

Route::post('/miqey/webhook', WebhookHandler::class)->name('miqey.webhook');
Route::get('/miqey/validate', ValidationController::class)->middleware('web')->name('miqey.validate');
