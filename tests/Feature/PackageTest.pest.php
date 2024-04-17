<?php


use Libaro\MiQey\MiQeyServiceProvider;
use Libaro\MiQey\Services\SignAgentService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

//test('registers the service provider', function () {
//    $serviceProvider = new SecureIdServiceProvider(App::getInstance());
//    expect($serviceProvider)->toBeInstanceOf(SecureIdServiceProvider::class);
//});


//test('handles a webhook using WebhookHandlerInterface', function () {
//    $handler = new DefaultWebhookHandler();
//
//    // Mock the Log facade to ensure that the Log::info method is called
//    Log::shouldReceive('info')->once();
//
//    $handler->handleWebhook('1234567890', '987654');
//});

//test('handles a webhook request using WebhookController', function () {
//    // Mock the Config facade to return the default webhook handler class
//    Config::set('secure-id.webhook_handlers', [DefaultWebhookHandler::class]);
//
//    // Mock the app function to return an instance of DefaultWebhookHandler
//    App::shouldReceive('make')->once()->andReturn(new DefaultWebhookHandler());
//
//    // Mock the post request to the webhook controller
//    Http::fake([
//        '/api/secure-id/webhook' => Http::response(['message' => 'Webhook handled successfully'], 200),
//    ]);
//
//    $response = $this->postJson('/api/secure-id/webhook', ['phone' => '1234567890', 'code' => '987654']);
//
//    $response->assertStatus(200);
//    $response->assertJson(['message' => 'Webhook handled successfully']);
//});
