<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProductAcction
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
        if (($request->v1 == 'range' && $request->v2 == 'sort') || ($request->v2 == 'range' && $request->v1 == 'sort')) {
            if ($request->min && $request->max && $request->orderBy && $request->column) {
                return $next($request);
            }
        }
    }
}
