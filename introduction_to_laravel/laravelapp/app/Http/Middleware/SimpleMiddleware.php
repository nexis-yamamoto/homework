<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SimpleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $persons = [
            ['name' => 'taro', 'mail' => 'taro@yamada'],
            ['name' => 'hanako', 'mail' => 'hanako@flower'],
            ['name' => 'sachiko', 'mail' => 'sachiko@happy'],
        ];
        $request->merge(['middleware_persons' => $persons]);
        return $next($request);
    }
}
