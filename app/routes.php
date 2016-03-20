<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Boardy\Routes;
use Symfony\Component\HttpFoundation\JsonResponse;

$app->mount('/', new Routes\Site\MainRoute);
$app->mount('/auth', new Routes\Site\AuthRoute);

$app->mount('/api', new Routes\Api\MainRoute);
$app->mount('/api/users', new Routes\Api\MainRoute);

$app->error(function (\Exception $e, $code) use ($app) {
    $request = $app['request_stack']->getCurrentRequest();

    // If the request URL starts with /api,
    // send a JSON formatted error
    if (strpos($request->getPathInfo(), '/api') === 0) {
        return new JsonResponse([
            'code' => $code,
            'message' => $e->getMessage()
        ]);
    }
});
