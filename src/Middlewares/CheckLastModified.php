<?php

namespace Helldar\LastModified\Middlewares;

use Closure;
use Helldar\LastModified\Services\Check;

class CheckLastModified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\config('last_modified.enabled')) {
            return $next($request);
        }

        $service = new Check($request);

        if ($service->isNotModified()) {
            return \response(null, 304);
        }

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        $date = $service->getDate();

        return $response->setLastModified($date);
    }
}
