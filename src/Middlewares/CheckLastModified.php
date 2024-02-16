<?php

/*
 * This file is part of the "dragon-code/last-modified" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/last-modified
 */

namespace DragonCode\LastModified\Middlewares;

use Closure;
use DragonCode\LastModified\Facades\Config;
use DragonCode\LastModified\Services\Checker;
use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckLastModified
{
    public function handle(Request $request, Closure $next): JsonResponse|Response
    {
        if ($this->isDisabled() || $this->disallowMethod($request)) {
            return $next($request);
        }

        $service = $this->service($request);

        if ($service->isNotModified()) {
            return response()->noContent(StatusCodeInterface::STATUS_NOT_MODIFIED);
        }

        return $this->setLastModified($request, $next, $service);
    }

    protected function setLastModified(Request $request, Closure $next, Checker $service): JsonResponse|Response
    {
        /** @var Response $response */
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

    protected function disallowMethod(Request $request): bool
    {
        return ! in_array($request->getRealMethod(), $this->requestMethods(), true);
    }

    protected function requestMethods(): array
    {
        return [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_HEAD];
    }
}
