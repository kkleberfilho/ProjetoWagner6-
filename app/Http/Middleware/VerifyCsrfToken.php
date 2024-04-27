<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends Middleware
{
    public function handle($request, Closure $next)
    {
        if (! $this->isReading($request) && ! $this->tokensMatch($request)) {
            Log::warning('CSRF token mismatch detected.');
            throw new TokenMismatchException;
        }

        return parent::handle($request, $next);
    }
}
