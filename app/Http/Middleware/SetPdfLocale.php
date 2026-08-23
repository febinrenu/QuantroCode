<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetPdfLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($locale = $request->header('X-Pdf-Locale', $request->query('pdf_locale'))) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
