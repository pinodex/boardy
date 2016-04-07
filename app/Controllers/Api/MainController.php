<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Controllers\Api;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController
{
    public function index(Request $request, Application $app)
    {
        return new JsonResponse();
    }

    public function markdown(Request $request, Application $app)
    {
        $markdown = $app['markdown']->text($request->request->get('text'));

        return Response::create($markdown, 200, [
            'content-type' => 'text/plain'
        ]);
    }
}
