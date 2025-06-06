<?php
//
//
//use DigitalHQ\SecureId\SecureIdServiceProvider;
//use DigitalHQ\SecureId\Services\SignAgentService;
//use DigitalHQ\SecureId\Interfaces\WebhookHandlerInterface;
//use DigitalHQ\SecureId\Interfaces\DefaultWebhookHandler;
//use DigitalHQ\SecureId\Http\Requests\WebhookValidationRequest;
//use DigitalHQ\SecureId\Http\Controllers\Api\WebhookController;
//use Illuminate\Support\Facades\Config;
//use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\App;
//use Illuminate\Support\Facades\Route;
//
//test('registers the service provider', function () {
//    $serviceProvider = new SecureIdServiceProvider(App::getInstance());
//    expect($serviceProvider)->toBeInstanceOf(SecureIdServiceProvider::class);
//});
//
//test('generates a sign using SignAgentService', function () {
//    Config::set('secure-id.api_key', 'your_api_key_here');
//    Config::set('secure-id.api_url', 'https://secureid.digitalhq.com/api/generate');
//
//    $signAgentService = new SignAgentService();
//
//    // Mock the Http facade to return a sample response
//    Http::fake([
//        '*' => Http::response(['code' => '123456', 'sms' => 'SMS Content', 'qr' => 'QR Code Content'], 200),
//    ]);
//
//    $sign = $signAgentService->getSign();
//
//    expect($sign['type'])->toBe('qr');
//    expect($sign['code'])->toBe('123456');
//    expect($sign['data'])->toBe('QR Code Content');
//});
//
//test('handles a webhook using WebhookHandlerInterface', function () {
//    $handler = new DefaultWebhookHandler();
//
//    // Mock the Log facade to ensure that the Log::info method is called
//    Log::shouldReceive('info')->once();
//
//    $handler->handleWebhook('1234567890', '987654');
//});
//
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
