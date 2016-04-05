<?php

/*
 * This file is part of the Boardy forum software
 *
 * (c) Raphael Marco <raphaelmarco@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Boardy\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Boardy\Services\Auth;

class Board extends Model
{
    /**
     * {@inheritDoc}
     */
    public $timestamps = false;

    /**
     * Get posts from board
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get board parent board
     * 
     * @return Board
     */
    public function parent()
    {
        return $this->belongsTo(Board::class, 'parent_id');
    }

    /**
     * Get board children
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function children()
    {
        return $this->hasMany(Board::class, 'parent_id');
    }

    /**
     * Get board groups
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'board_groups');
    }

    public function userHasAccess()
    {
        $hasAccess = false;

        Auth::groups()->each(function ($item) use (&$hasAccess) {
            if ($this->groups->contains($item)) {
                $hasAccess = true;
            }
        });

        return $hasAccess;
    }

    /**
     * Get board by slug.
     * This also checks for the current user and returns null
     * if it has no permissions to access or not found.
     * 
     * @param string $slug Board slug
     * 
     * @return self
     */
    public static function bySlug($slug)
    {
        $board = self::where('slug', $slug)->firstOrFail();

        if (!$board->userHasAccess()) {
            throw new AccessDeniedException();
        }

        return $board;
    }
}
