<?php

namespace Libaro\MiQey\Services;

use Exception;
use \Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;
use Libaro\MiQey\Exceptions\ApplicationTypeNotSupportedException;
use Libaro\MiQey\Exceptions\FreeMessagesLimitExceededException;
use Libaro\MiQey\Exceptions\WalletNotActivatedException;

class SignAgentService
{
    private const API_ENDPOINT = 'https://secureid.digitalhq.com/api/';

    private bool $base64EncodedQr = false;

    /**
     * @return string[]
     * @throws Exception
     */
    public function getSign(): array
    {
        $message = $this->getMessage();
        return $this->getSignFromMessage($message);
    }

    public function getRawSign(): array
    {
        return $this->getMessage();
    }

    /**
     * @return self
     */
    public function withBase64EncodedQr(): self
    {
        $this->base64EncodedQr = true;

        return $this;
    }

    /**
     * @return string[]
     * @throws Exception
     */
    private
    function getMessage(): array
    {
        $response = $this->doApiCall('generate');

        /** @var array<string, string> $result */
        $result = $response->json();

        if ($response->status() !== 200) {
            $errorMessage = $response->json('message');
            return match ($response->json('error')) {
                'ApplicationNotSupported' => throw new ApplicationTypeNotSupportedException($errorMessage),
                'WalletNotActivated' => throw new WalletNotActivatedException($errorMessage),
                'FreeMessagesLimitExceeded' => throw new FreeMessagesLimitExceededException($errorMessage),
                default => throw new Exception(),
            };
        }

        return $result;
    }

    /**
     * @return string
     */
    private
    function getMethod(): string
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
    private
    function getSignFromMessage(array $data): array
    {
        $method = $this->getMethod();
        $agent = new Agent;
        $sign = [];

        $sign['type'] = $method;
        $sign['code'] = $data['code'];

        if ($agent->isDesktop()) {
            if ($method === 'qr' && $this->base64EncodedQr && isset($data['base64Qr'])) {
                $sign['data'] = $data['base64Qr'];
                return $sign;
            };

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

        return Http::post(self::API_ENDPOINT . $path, [
            'api_key' => config('miqey.api_key'),
        ]);
    }
}
