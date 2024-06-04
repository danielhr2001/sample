<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsBan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->is_ban) {
            return response()->json(["code" => "user_is_ban", "message" => "شما بن شده اید! برای برسی این موضوع با پشتیبانی تماس حاصل فرمایید."], 403);
        }
        return $next($request);
    }
}
