<?php

namespace Helldar\LastModified\Middlewares;

use Closure;
use Helldar\LastModified\Services\Check;
use Illuminate\Http\Request;

class CheckLastModified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->isDisabled()) {
            return $next($request);
        }

        $service = $this->service($request);

        if ($service->isNotModified()) {
            return response(null, 304);
        }

        return $this->setLastModified($request, $next, $service);
    }

    protected function setLastModified(Request $request, Closure $next, Check $service)
    {
        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        $date = $service->getDate();

        return $response->setLastModified($date);
    }

    protected function service(Request $request): Check
    {
        return new Check($request);
    }

    protected function isDisabled(): bool
    {
        return ! config('last_modified.enabled');
    }
}
