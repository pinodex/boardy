<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Services;

use Boardy\Models\Board;
use Boardy\Models\Post;
use Illuminate\Support\Collection;

class TemplateModel
{
    /**
     * Get boards for template display
     * 
     * @return array
     */
    public static function boards()
    {
        return Board::all()->filter(function (Board $item) {
            return $item->userHasAccess();
        })->toArray();
    }

    /**
     * Get posts for template display
     * 
     * @return array
     */
    public static function posts($boards = array())
    {
        $boards = (new Collection($boards))->pluck('id')->all();

        return Post::where('parent_id', null)
            ->whereIn('board_id', $boards)
            ->with('board', 'author')
            ->get()->toArray();
    }
}
