<?php

namespace Helldar\LastModified;

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
        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        $service = new Check($request);

        if ($service->isNotModified()) {
            return $response->setNotModified();
        }

        $date = $service->getDate();

        return $response->setLastModified($date);
    }
}
