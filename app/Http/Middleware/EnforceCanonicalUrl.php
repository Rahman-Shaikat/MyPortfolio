<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceCanonicalUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('seo.enforce_canonical') || ! $request->isMethodSafe()) {
            return $next($request);
        }

        $canonicalRoot = rtrim((string) config('seo.url'), '/');
        $requestRoot = $request->getSchemeAndHttpHost();

        if ($canonicalRoot !== $requestRoot) {
            return redirect()->to($canonicalRoot.$request->getRequestUri(), 301)
                ->withHeaders(['Cache-Control' => 'public, max-age=3600']);
        }

        return $next($request);
    }
}
