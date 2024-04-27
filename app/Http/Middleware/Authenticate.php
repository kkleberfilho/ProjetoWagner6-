<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
{
    if ($request->expectsJson()) {
        // Log para requisições JSON
        \Log::debug('Request expects JSON.');
    } else {
        // Log para outras requisições
        \Log::debug('Request does not expect JSON. Redirecting to login page.');
    }
    
    return $request->expectsJson() ? null : route('site.login');
}

}
