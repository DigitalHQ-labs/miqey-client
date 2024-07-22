<?php

namespace Libaro\MiQey\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ValidationController extends Controller
{
    public function __invoke(Request $request)
    {
        $hasToken = Cache::has($request->get('token'));

        if (! $hasToken) {
            // todo: change to exception?
            abort(403, 'token mismatch');
        }

        $phoneNumber = Cache::pull($request->get('token'));

        $userClass = config('miqey.user_model');
        $user = $userClass::query()
            ->where(config('miqey.user_phone_column', 'phone_number'), '=', $phoneNumber)
            ->first();

        if (is_null($user)) {
            // todo: change to exception?
            abort(403, 'user not found');
        }

        Auth::login($user, config('miqey.remember_user'));

        return redirect()->to($request->get('redirect_to', '/'));
    }
}
