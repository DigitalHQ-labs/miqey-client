<?php

namespace Libaro\MiQey\Services;

use Exception;
use \Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;

class SignAgentService
{

    private const API_ENDPOINT = 'https://secureid.digitalhq.com/api/';

    /**
     * @return string[]
     * @throws Exception
     */
    public function getSign(): array
    {
        $message = $this->getMessage();
        return $this->getSignFromMessage($message);
    }


    /**
     * @return string[]
     * @throws Exception
     */
    private function getMessage(): array
    {
        $response = $this->doApiCall('generate');

        /** @var array<string, string> $result */
        $result = $response->json();

        return $result;
    }

    /**
     * @return string
     */
    private function getMethod(): string
    {
        if ((new Agent())->isDesktop()) {
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
        $agent = new Agent;
        $sign = [];

        $sign['type'] = $this->getMethod();
        $sign['code'] = $data['code'];

        if ($agent->isDesktop()) {
            $sign['data'] = $data[$method];
            return $sign;
        }

        if ($agent->isAndroidOS()) {
            $sign['data'] = $data['android'];
            return $sign;
        }

        $sign['data'] = $data['ios'];
        return $sign;
    }

    private function doApiCall(string $path): Response
    {
        if (is_null(config('miqey.api_key'))) {
            throw new \RuntimeException('No apikey defined for miQey');
        }

        return Http::post(self::API_ENDPOINT.$path, [
            'api_key' => config('miqey.api_key'),
        ]);
    }
}
