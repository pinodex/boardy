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

class Group extends Model
{
    /**
     * {@inheritDoc}
     */
    public $timestamps = false;

    /**
     * Get group boards
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function boards()
    {
        return $this->belongsToMany(Board::class, 'board_groups');
    }

    /**
     * Get group users
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }
}
