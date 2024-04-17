<?php

return [
    'api_url' => env('SECURE_ID_API_URL', 'https://secureid.digitalhq.com/api/generate'),
    'api_key' => env('SECURE_ID_API_KEY'),
    'api_url_prefix' => env('SECURE_ID_API_URL_PREFIX', '/api/secure-id'),
];
