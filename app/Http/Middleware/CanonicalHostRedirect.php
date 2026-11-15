<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanonicalHostRedirect
{
    /**
     * Redirect production traffic to the configured canonical scheme/host with a
     * permanent 301 so www / http variants do not compete as duplicate URLs.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->isProduction()) {
            return $next($request);
        }

        $canonical = rtrim((string) config('app.url'), '/');
        $parts = $canonical === '' ? false : parse_url($canonical);

        if (! $parts || empty($parts['host'])) {
            return $next($request);
        }

        $canonicalScheme = $parts['scheme'] ?? 'https';
        $canonicalHost = $parts['host'];
        $canonicalPort = $parts['port'] ?? null;

        $requestHost = $request->getHost();
        $requestScheme = $request->getScheme();
        $requestPort = $request->getPort();

        $hostMatches = strcasecmp($canonicalHost, $requestHost) === 0;
        $schemeMatches = $canonicalScheme === $requestScheme;
        $portMatches = $canonicalPort === null
            || (int) $canonicalPort === (int) $requestPort;

        if ($hostMatches && $schemeMatches && $portMatches) {
            return $next($request);
        }

        // Only redirect safe requests; POST bodies must not be dropped.
        if (! $request->isMethodSafe()) {
            return $next($request);
        }

        return redirect()->away($canonical . $request->getRequestUri(), 301);
    }
}
