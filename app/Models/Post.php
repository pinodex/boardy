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

class Post extends Model
{
    /**
     * {@inheritDoc}
     */
    public $timestamps = false;

    /**
     * Get post board
     * 
     * @return Boardy\Models\Board
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get post parent post
     * 
     * @return Post
     */
    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    /**
     * Get post children
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function children()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    /**
     * Get post author
     * 
     * @return Boardy\Models\User
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get post last editor
     * 
     * @return Boardy\Models\User
     */
    public function lastEditor()
    {
        return $this->belongsTo(User::class);
    }
}
