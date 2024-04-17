<?php

namespace Libaro\MiQey\Services;

use Exception;
use \Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;

class SignAgentService
{
    /** @var Agent */
    private $agent;

    /**
     *
     */
    public function __construct()
    {
        $this->agent = new Agent();
    }


    /**
     * @param string $callbackUrl
     * @return string[]
     * @throws Exception
     */
    public function getSign(string $callbackUrl = 'default'): array
    {
        $message = $this->getMessage();
        return $this->getSignFromMessage($message);
    }


    /**
     * @param string $template
     * @param string $customCode
     * @param string $callbackUrl
     * @return string[]
     * @throws Exception
     */
    private function getMessage(string $template = '', string $customCode = '', string $callbackUrl = 'default'): array
    {
        $apiKey = config('secure-id.api_key');
        if (! $apiKey) {
            throw new \RuntimeException('No apikey defined for miQey');
        }

        /** @var string $apiUrl */
        $apiUrl = config('secure-id.api_url');

        $response = Http::post($apiUrl, [
            'api_key' => $apiKey,
            'type' => $this->getMethod(),
            'template' => $template,
            'customCode' => $customCode,
            'callback_url' => $callbackUrl,
        ]);

        /** @var array<string, string> $result */
        $result = $response->json();

        return $result;
    }

    /**
     * @return string
     */
    private function getMethod(): string
    {
        if ($this->agent->isDesktop()) {
            return 'qr';
        }

        return 'sms';
    }


    /**
     * @param array<string, string> $data
     * @return array<string, string>
     */
    private function getSignFromMessage(array $data): array
    {
        $method = $this->getMethod();
        $sign = [];

        $sign['type'] = $this->getMethod();
        $sign['code'] = $data['code'];

        if ($this->agent->isDesktop()) {
            $sign['data'] = $data[$method];
            return $sign;
        }

        if ($this->agent->isAndroidOS()) {
            $sign['data'] = $data['android'];
            return $sign;
        }

        $sign['data'] = $data['ios'];
        return $sign;
    }
}
