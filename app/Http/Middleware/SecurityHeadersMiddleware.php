<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request and attach essential security headers.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Remove PHP version disclosure from header (Resolves O-01 partial)
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        $response = $next($request);

        // Remove from response object headers if set by framework / web server
        $response->headers->remove('X-Powered-By');

        // 2. Content Security Policy (Resolves F-03)
        // Accommodates Vite assets, Livewire scripts & styles, Alpine.js, TomSelect CDN, Google Fonts, Bunny Fonts, Cloudflare Turnstile, Google Maps, and camera / QR blobs
        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://challenges.cloudflare.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdn.jsdelivr.net",
            "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net https://cdn.jsdelivr.net",
            "img-src 'self' data: blob: https:",
            "media-src 'self' data: blob:",
            "connect-src 'self' https://challenges.cloudflare.com https://cdn.jsdelivr.net",
            "frame-src 'self' https://challenges.cloudflare.com https://maps.google.com https://www.google.com",
            "object-src 'self'",
            "base-uri 'self'",
            "form-action 'self' https://challenges.cloudflare.com",
        ];

        if (app()->environment('production') || $request->isSecure()) {
            $cspDirectives[] = 'upgrade-insecure-requests';
        }

        $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        // 3. Essential Security Headers (Pentest best practice)
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(), geolocation=()');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        return $response;
    }
}
