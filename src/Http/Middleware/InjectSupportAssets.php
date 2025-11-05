<?php

namespace KevinBHarris\Support\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InjectSupportAssets
{
    /**
     * Handle an incoming request and inject custom CSS for support icons.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only inject assets into admin HTML responses
        if ($request->is('admin/*') && 
            $response->headers->get('Content-Type') &&
            str_contains($response->headers->get('Content-Type'), 'text/html')) {
            
            $content = $response->getContent();
            
            // Inject CSS before </head>
            $cssLink = '<link rel="stylesheet" href="' . asset('vendor/support/assets/css/admin.css') . '">';
            $content = str_replace('</head>', $cssLink . '</head>', $content);
            
            $response->setContent($content);
        }
        
        return $response;
    }
}
