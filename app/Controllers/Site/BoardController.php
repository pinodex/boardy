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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Boardy\Services\TemplateModel;
use Boardy\Services\Theme;
use Boardy\Models\Board;

class BoardController
{
    public function index(Request $request, Application $app)
    {
        return $app->redirect($app->path('site.index'));
    }

    public function browse(Request $request, Application $app, $slug)
    {
        try {
            $board = Board::bySlug($slug);
        } catch (AccessDeniedException $e) {
            return Theme::view('errors/access_dened');
        } catch (ModelNotFoundException $e) {
            return Theme::view('errors/not_found');
        }

        TemplateModel::overrideBoards(function () use ($board) {
            return [$board->toArray()];
        });

        return Theme::view('index', [
            'current_board_slug' => $slug
        ]);
    }
}
