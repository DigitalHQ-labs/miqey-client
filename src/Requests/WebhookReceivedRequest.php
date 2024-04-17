<?php

namespace Libaro\MiQey\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebhookReceivedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|regex:^\+[1-9]\d{1,14}$',
            'code' => 'required',
        ];
    }
}