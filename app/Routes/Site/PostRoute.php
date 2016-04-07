<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Routes\Site;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Boardy\Controllers\Site\PostController;

class PostRoute implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];
        
        $controller->get('/', [PostController::class, 'index']);
        
        $controller->get('/{id}-{slug}', [PostController::class, 'read'])
            ->bind('site.post.read')
            ->value('slug', null);

        $controller->post('/{id}-{slug}/reply', [PostController::class, 'reply'])
            ->bind('site.post.reply')
            ->value('slug', null);
        
        return $controller;
    }
}
