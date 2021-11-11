<?php

namespace DragonCode\LastModified\Middlewares;

use Closure;
use DragonCode\LastModified\Facades\Config;
use DragonCode\LastModified\Services\Checker;
use Illuminate\Http\Request;

class CheckLastModified
{
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

    protected function setLastModified(Request $request, Closure $next, Checker $service)
    {
        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        $date = $service->getDate();

        return $response->setLastModified($date);
    }

    protected function service(Request $request): Checker
    {
        return Checker::make($request);
    }

    protected function isDisabled(): bool
    {
        return Config::disabled();
    }
}
