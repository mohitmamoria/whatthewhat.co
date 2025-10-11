<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class QuickHttpBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $password = $request->getPassword();

        $hash = config('auth.quick_basic.password_hash');

        $okPass = $hash && Hash::check((string) $password, $hash);

        if (!$okPass) {
            return response('Unauthorized', 401)
                ->header('WWW-Authenticate', sprintf('Basic realm="%s"', addslashes('Restricted Area')));
        }
        return $next($request);
    }
}
