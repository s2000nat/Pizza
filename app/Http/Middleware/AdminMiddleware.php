<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Проверка, что входящий запрос выполнил Админ
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }
        return response()->json(['message' => 'Only Admin access.'], Response::HTTP_FORBIDDEN);
    }

}
