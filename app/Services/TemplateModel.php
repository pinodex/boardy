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

use Silex\Application;
use Boardy\Services\Config;
use Boardy\Services\Auth;
use Boardy\Models\Group;
use Boardy\Models\Post;
use Illuminate\Support\Collection;

class TemplateModel
{
    /**
     * @var array Array of boards. Cached for the current request.
     */
    private static $boards;

    /**
     * @var array Array of posts. Cached for the current request.
     */
    private static $posts;

    /**
     * Get boards for template display
     * 
     * @return array
     */
    private static function boards()
    {
        if (self::$boards) {
            return self::$boards;
        }

        $groups = Auth::groups();
        $boards = array();

        foreach ($groups as $group) {
            foreach ($group->boards as $board) {
                if (array_key_exists($board->id, $boards)) {
                    continue;
                }

                $boards[$board->id] = $board->toArray();
            }
        }

        self::$boards = $boards;
        return $boards;
    }

    /**
     * Get posts for template display
     * 
     * @return array
     */
    private static function posts()
    {
        if (self::$posts) {
            return self::$posts;
        }

        $boards = self::boards();
        $boardIds = array();

        foreach ($boards as $board) {
            $boardIds[] = $board['id'];
        }

        self::$posts = Post::where('parent_id', null)
            ->whereIn('board_id', $boardIds)
            ->with('board', 'author')
            ->get()->toArray();

        return self::$posts;
    }

    /**
     * Override boards source
     * 
     * @param callable $cb Callback which should return an array of boards
     */
    public static function overrideBoards(callable $cb)
    {
        // Override boards with value returned by $cb.
        self::$boards = $cb();

        // Call this method to cache posts for the overridden boards.
        self::posts();

        // Set to null to get the non-overridden boards for template display.
        self::$boards = null;
    }

    public static function __callStatic($name, $args)
    {
        switch ($name) {
            case 'board':
                return self::boards();

            case 'post':
                return self::posts();
        }

        throw new \RuntimeException(sprintf("Model '%s' not found.", $name));
    }
}
