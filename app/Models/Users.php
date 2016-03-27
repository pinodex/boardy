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

use Boardy\Services\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;

    /**
     * {@inheritDoc}
     */
    protected $table = 'users';

    /**
     * {@inheritDoc}
     */
    protected $dates = ['deleted_at'];

    /**
     * {@inheritDoc}
     */
    protected $fillable = ['name', 'username', 'email', 'password'];

    /**
     * {@inheritDoc}
     */
    protected $hidden = ['password'];

    /**
     * Allows for automatic password hashing
     *
     * @param string $password User's password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

}
