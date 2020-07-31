<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        } else {
            App::setLocale(config('app.locale'));
            Session::put('applocale', config('app.locale'));
        }

        return $next($request);
    }
}
