<?php

namespace Libaro\MiQey\Handlers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Libaro\MiQey\Events\SignSmsRequestReceived;
use Libaro\MiQey\Requests\WebhookReceivedRequest;

class WebhookHandler
{
    public function __invoke(WebhookReceivedRequest $request)
    {
        $data = $request->validated();

        $signature = $request->header('Signature');

        $calculatedSignature = hash_hmac('sha256', $request->getContent(), config('miqey.webhook_secret'));

        if (! hash_equals($signature, $calculatedSignature)) {
            return response()->json(status: 401);
        }

        $phone = $data['phone'];
        $code = $data['code'];

        $token = Str::random(32);

        Cache::put($token, $phone, now()->addSeconds(10));

        event(new SignSmsRequestReceived($code, $token));

        $now = now();

        for($i = 0; $i < 10; $i++) {
            dispatch(function() use ($token, $code) {
                event(new SignSmsRequestReceived($code, $token));
            })->delay($now->addSeconds($i+1));
        }

        return response()->json(status: 204);
    }
}
