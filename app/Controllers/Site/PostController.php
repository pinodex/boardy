<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Controllers\Site;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Boardy\Services\Theme;
use Boardy\Models\Post;

class PostController
{
    public function index(Request $request, Application $app)
    {
        return $app->redirect($app->path('site.index'));
    }

    public function read(Request $request, Application $app, $id, $slug)
    {
        try {
            $post = Post::with('author', 'children', 'children.author')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Theme::view('errors/not_found');
        }

        if ($slug != $post->slug) {
            return $app->redirect($app->path('site.post.read', [
                'id'    => $id,
                'slug'  => $post->slug
            ]));
        }

        if (!$post->board->userHasAccess()) {
            return Theme::view('errors/access_denied');
        }

        return Theme::view('post', [
            'post' => $post->toArray()
        ]);
    }
}
