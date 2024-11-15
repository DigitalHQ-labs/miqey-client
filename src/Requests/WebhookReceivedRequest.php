<?php

namespace DigitalHQ\MiQey\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebhookReceivedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required',
            'code' => 'required',
        ];
    }
}
